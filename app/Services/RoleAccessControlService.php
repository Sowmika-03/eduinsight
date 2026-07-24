<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\User;

class RoleAccessControlService
{
    /**
     * Enforce role-based access control and automatically scope NLP queries based on user role
     */
    public static function applyRoleScope(array $parseResult, User $user): array
    {
        $roleSlug = strtolower($user->role->slug ?? 'student');
        $intent = $parseResult['intent'] ?? 'search';
        $entities = $parseResult['entities'] ?? [];
        $sql = $parseResult['sql'] ?? '';

        $unauthorized = false;
        $authorizationMessage = null;

        // 1. ADMIN ROLE: Institution Scope (Green)
        if ($roleSlug === 'admin') {
            return array_merge($parseResult, [
                'role_scoped' => true,
                'role_slug' => 'admin',
                'unauthorized' => false,
                'role_context' => [
                    'role_name' => 'Administrator',
                    'role_slug' => 'admin',
                    'current_scope' => 'Institution Scope',
                    'access_level' => 'Full Analytics',
                    'scope_badge_class' => 'bg-emerald-100 text-emerald-800 border-emerald-300', // Green
                    'scope_badge_label' => 'Institution Scope',
                    'department' => 'Institution Wide',
                    'security_model' => 'Role-Based Access Control (RBAC)',
                    'visible_data' => ['Students', 'Faculty', 'Courses', 'Reports'],
                    'role_explanation' => 'You have institution-wide access to all academic records, departments, students, faculty and analytics.',
                    'requested_dept' => !empty($entities['programs']) ? implode(', ', array_map('strtoupper', $entities['programs'])) : 'All Departments',
                    'applied_dept' => 'All Departments',
                    'role_scope_applied' => 'Unrestricted Institution Access',
                    'explanation' => 'You have institution-wide access to all academic records, departments, students, faculty and analytics.',
                    'is_cross_dept' => false,
                    'scope_notice' => null,
                    'why_seeing_this' => null,
                ]
            ]);
        }

        // 2. HOD ROLE: Department Scope (Blue) / Scope Adjusted (Amber)
        if ($roleSlug === 'hod') {
            $hodRecord = DB::table('hods')->where('user_id', $user->id)->first();
            if (!$hodRecord) {
                $hodRecord = DB::table('faculty')->where('user_id', $user->id)->first();
            }
            $dept = $hodRecord ? strtoupper($hodRecord->department) : 'MCA';
            $escapedDept = addslashes(strtolower($dept));

            $isCrossDept = false;
            $requestedDeptStr = !empty($entities['programs']) ? implode(', ', array_map('strtoupper', $entities['programs'])) : $dept;
            $scopeNotice = null;
            $whySeeingThis = null;

            if (!empty($entities['programs'])) {
                $requestedDepts = array_map('strtoupper', $entities['programs']);
                if (!in_array($dept, $requestedDepts)) {
                    $isCrossDept = true;
                    $requestedDeptStr = implode(', ', $requestedDepts);
                    $scopeNotice = "Your query requested {$requestedDeptStr} data. According to institutional Role-Based Access Control (RBAC), this request has been automatically evaluated within your authorized {$dept} department.";

                    $whySeeingThis = [
                        'what_is_rbac' => 'Role-Based Access Control (RBAC) is an institutional data security model that restricts analytics visibility based on assigned administrative responsibility.',
                        'why_restricted' => "Your query requested data for {$requestedDeptStr}. The AI automatically restricted execution to the {$dept} department to protect cross-department data privacy.",
                        'how_broader' => "To analyze {$requestedDeptStr} data, please sign in as Administrator or {$requestedDeptStr} Head of Department."
                    ];
                }
            }

            $entities['programs'] = [$dept];

            if (str_contains($sql, 'FROM faculty f')) {
                $hodCondition = "LOWER(f.department) = '{$escapedDept}'";
            } elseif (str_contains($sql, 'FROM courses c')) {
                $hodCondition = "(LOWER(c.course_code) LIKE '%{$escapedDept}%' OR LOWER(c.course_name) LIKE '%{$escapedDept}%')";
            } else {
                $hodCondition = "(LOWER(s.program) = '{$escapedDept}' OR LOWER(b.branch_name) = '{$escapedDept}' OR s.student_id LIKE '%{$dept}%')";
            }

            $sql = self::injectScopeCondition($sql, $hodCondition);

            $badgeClass = $isCrossDept 
                ? 'bg-amber-100 text-amber-800 border-amber-300'  // Scope Adjusted (Amber)
                : 'bg-blue-100 text-blue-800 border-blue-300';   // Department Scope (Blue)

            $accessLabel = $isCrossDept ? 'Scope Adjusted' : 'Department Scope';
            $currentScopeName = $isCrossDept ? 'Scope Adjusted' : 'Department Scope';

            return array_merge($parseResult, [
                'sql' => $sql,
                'entities' => $entities,
                'role_scoped' => true,
                'role_slug' => 'hod',
                'hod_department' => $dept,
                'unauthorized' => false,
                'authorization_message' => $scopeNotice,
                'role_context' => [
                    'role_name' => 'Head of Department',
                    'role_slug' => 'hod',
                    'current_scope' => $currentScopeName,
                    'access_level' => 'Department Analytics',
                    'scope_badge_class' => $badgeClass,
                    'scope_badge_label' => $accessLabel,
                    'department' => $dept,
                    'security_model' => 'Role-Based Access Control (RBAC)',
                    'visible_data' => ["{$dept} Students", "{$dept} Faculty", "{$dept} Courses", "{$dept} Reports"],
                    'role_explanation' => 'You are currently viewing analytics for your assigned department only.',
                    'requested_dept' => $requestedDeptStr,
                    'applied_dept' => $dept,
                    'role_scope_applied' => $isCrossDept ? 'Cross-Department Scope Adjustment' : 'Department Scope Restriction',
                    'explanation' => 'You are currently viewing analytics for your assigned department only.',
                    'is_cross_dept' => $isCrossDept,
                    'requested_dept_str' => $requestedDeptStr,
                    'scope_notice' => $scopeNotice,
                    'why_seeing_this' => $whySeeingThis,
                ]
            ]);
        }

        // 3. FACULTY ROLE: Course Scope (Purple)
        if ($roleSlug === 'faculty') {
            $facultyRecord = DB::table('faculty')->where('user_id', $user->id)->first();
            $facId = $facultyRecord ? $facultyRecord->id : 0;
            $dept = $facultyRecord ? strtoupper($facultyRecord->department) : 'MCA';

            $courseIds = DB::table('courses')->where('faculty_id', $facId)->pluck('id')->toArray();
            $courseIdList = !empty($courseIds) ? implode(',', $courseIds) : '0';

            if (str_contains($sql, 'FROM faculty f')) {
                $facCondition = "f.user_id = {$user->id}";
            } elseif (str_contains($sql, 'FROM courses c')) {
                $facCondition = "c.faculty_id = {$facId}";
            } else {
                $facCondition = "s.id IN (SELECT student_id FROM marks WHERE course_id IN ({$courseIdList}))";
            }

            $sql = self::injectScopeCondition($sql, $facCondition);

            return array_merge($parseResult, [
                'sql' => $sql,
                'role_scoped' => true,
                'role_slug' => 'faculty',
                'faculty_id' => $facId,
                'unauthorized' => false,
                'role_context' => [
                    'role_name' => 'Faculty',
                    'role_slug' => 'faculty',
                    'current_scope' => 'Course Scope',
                    'access_level' => 'Course Analytics',
                    'scope_badge_class' => 'bg-purple-100 text-purple-800 border-purple-300', // Purple
                    'scope_badge_label' => 'Course Scope',
                    'department' => $dept,
                    'security_model' => 'Role-Based Access Control (RBAC)',
                    'visible_data' => ['Assigned Courses', 'Enrolled Students', 'Subject Marks', 'Course Reports'],
                    'role_explanation' => 'Analytics are restricted to students and courses assigned to you.',
                    'assigned_courses_count' => count($courseIds),
                    'requested_dept' => !empty($entities['programs']) ? implode(', ', array_map('strtoupper', $entities['programs'])) : $dept,
                    'applied_dept' => "Assigned Courses ({$dept})",
                    'role_scope_applied' => 'Course Scope Restriction',
                    'explanation' => 'Analytics are restricted to students and courses assigned to you.',
                    'is_cross_dept' => false,
                    'scope_notice' => null,
                    'why_seeing_this' => null,
                ]
            ]);
        }

        // 4. STUDENT ROLE: Personal Scope (Orange) / Scope Adjusted (Amber)
        if ($roleSlug === 'student') {
            $studentRecord = DB::table('students')->where('user_id', $user->id)->first();
            $dept = $studentRecord ? strtoupper($studentRecord->program ?? 'MCA') : 'MCA';
            $userQuery = strtolower($parseResult['raw_query'] ?? '');

            $isUnauthorizedSearch = false;
            if (in_array($parseResult['intent'] ?? 'search', ['department_performance', 'compare', 'faculty_performance', 'highest', 'lowest']) ||
                preg_match('/\b(?:all|every|others|compare|department|branch|which|rank)\b/i', $userQuery)) {
                $isUnauthorizedSearch = true;
            }

            $studentCondition = "s.user_id = {$user->id}";
            $sql = self::injectScopeCondition($sql, $studentCondition);

            $scopeNotice = null;
            $whySeeingThis = null;
            $badgeClass = 'bg-orange-100 text-orange-800 border-orange-300'; // Personal Scope (Orange)
            $accessLabel = 'Personal Scope';
            $currentScopeName = 'Personal Scope';

            if ($isUnauthorizedSearch) {
                $scopeNotice = "This result has been restricted according to institutional role-based access policies. The AI continues processing your query using your authorized academic scope (Personal Profile).";
                $badgeClass = 'bg-amber-100 text-amber-800 border-amber-300'; // Scope Adjusted (Amber)
                $accessLabel = 'Scope Adjusted';
                $currentScopeName = 'Scope Adjusted';

                $whySeeingThis = [
                    'what_is_rbac' => 'Role-Based Access Control (RBAC) safeguards institutional data privacy by scoping student access exclusively to personal performance records.',
                    'why_restricted' => 'Your query requested institution-wide or peer student records. The AI automatically restricted execution to your own student profile.',
                    'how_broader' => 'To view cohort-wide analytics, please consult a Faculty Member, Head of Department, or Administrator.'
                ];
            }

            return array_merge($parseResult, [
                'sql' => $sql,
                'role_scoped' => true,
                'role_slug' => 'student',
                'student_record' => $studentRecord,
                'unauthorized' => false,
                'authorization_message' => $scopeNotice,
                'role_context' => [
                    'role_name' => 'Student',
                    'role_slug' => 'student',
                    'current_scope' => $currentScopeName,
                    'access_level' => 'Personal Analytics',
                    'scope_badge_class' => $badgeClass,
                    'scope_badge_label' => $accessLabel,
                    'student_name' => $user->name,
                    'student_id' => $studentRecord->student_id ?? 'Self',
                    'semester' => $studentRecord->semester ?? 'Current',
                    'department' => $dept,
                    'security_model' => 'Role-Based Access Control (RBAC)',
                    'visible_data' => ['Personal Attendance', 'Personal Marks', 'Personal Risk Status', 'Personal Profile'],
                    'role_explanation' => 'Only your personal academic information is available.',
                    'requested_dept' => !empty($entities['programs']) ? implode(', ', array_map('strtoupper', $entities['programs'])) : 'Peer Records',
                    'applied_dept' => 'Personal Profile',
                    'role_scope_applied' => 'Personal Profile Security Restriction',
                    'explanation' => 'Only your personal academic information is available.',
                    'is_cross_dept' => $isUnauthorizedSearch,
                    'scope_notice' => $scopeNotice,
                    'why_seeing_this' => $whySeeingThis,
                ]
            ]);
        }

        return $parseResult;
    }

    /**
     * Get default Role Context for a User before running a query
     */
    public static function getRoleContextForUser(User $user): array
    {
        $roleSlug = strtolower($user->role->slug ?? 'student');

        if ($roleSlug === 'admin') {
            return [
                'role_name' => 'Administrator',
                'role_slug' => 'admin',
                'current_scope' => 'Institution Scope',
                'access_level' => 'Full Analytics',
                'scope_badge_class' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
                'scope_badge_label' => 'Institution Scope',
                'department' => 'Institution Wide',
                'security_model' => 'Role-Based Access Control (RBAC)',
                'visible_data' => ['Students', 'Faculty', 'Courses', 'Reports'],
                'role_explanation' => 'You have institution-wide access to all academic records, departments, students, faculty and analytics.',
                'requested_dept' => 'All Departments',
                'applied_dept' => 'All Departments',
                'role_scope_applied' => 'Unrestricted Institution Access',
                'explanation' => 'You have institution-wide access to all academic records, departments, students, faculty and analytics.',
                'is_cross_dept' => false,
                'scope_notice' => null,
                'why_seeing_this' => null,
            ];
        }

        if ($roleSlug === 'hod') {
            $hodRecord = DB::table('hods')->where('user_id', $user->id)->first();
            if (!$hodRecord) {
                $hodRecord = DB::table('faculty')->where('user_id', $user->id)->first();
            }
            $dept = $hodRecord ? strtoupper($hodRecord->department) : 'MCA';

            return [
                'role_name' => 'Head of Department',
                'role_slug' => 'hod',
                'current_scope' => 'Department Scope',
                'access_level' => 'Department Analytics',
                'scope_badge_class' => 'bg-blue-100 text-blue-800 border-blue-300',
                'scope_badge_label' => 'Department Scope',
                'department' => $dept,
                'security_model' => 'Role-Based Access Control (RBAC)',
                'visible_data' => ["{$dept} Students", "{$dept} Faculty", "{$dept} Courses", "{$dept} Reports"],
                'role_explanation' => 'You are currently viewing analytics for your assigned department only.',
                'requested_dept' => $dept,
                'applied_dept' => $dept,
                'role_scope_applied' => 'Department Scope Restriction',
                'explanation' => 'You are currently viewing analytics for your assigned department only.',
                'is_cross_dept' => false,
                'scope_notice' => null,
                'why_seeing_this' => null,
            ];
        }

        if ($roleSlug === 'faculty') {
            $facultyRecord = DB::table('faculty')->where('user_id', $user->id)->first();
            $dept = $facultyRecord ? strtoupper($facultyRecord->department) : 'MCA';

            return [
                'role_name' => 'Faculty',
                'role_slug' => 'faculty',
                'current_scope' => 'Course Scope',
                'access_level' => 'Course Analytics',
                'scope_badge_class' => 'bg-purple-100 text-purple-800 border-purple-300',
                'scope_badge_label' => 'Course Scope',
                'department' => $dept,
                'security_model' => 'Role-Based Access Control (RBAC)',
                'visible_data' => ['Assigned Courses', 'Enrolled Students', 'Subject Marks', 'Course Reports'],
                'role_explanation' => 'Analytics are restricted to students and courses assigned to you.',
                'requested_dept' => $dept,
                'applied_dept' => "Assigned Courses ({$dept})",
                'role_scope_applied' => 'Course Scope Restriction',
                'explanation' => 'Analytics are restricted to students and courses assigned to you.',
                'is_cross_dept' => false,
                'scope_notice' => null,
                'why_seeing_this' => null,
            ];
        }

        // Default Student
        $studentRecord = DB::table('students')->where('user_id', $user->id)->first();
        $dept = $studentRecord ? strtoupper($studentRecord->program ?? 'MCA') : 'MCA';

        return [
            'role_name' => 'Student',
            'role_slug' => 'student',
            'current_scope' => 'Personal Scope',
            'access_level' => 'Personal Analytics',
            'scope_badge_class' => 'bg-orange-100 text-orange-800 border-orange-300',
            'scope_badge_label' => 'Personal Scope',
            'department' => $dept,
            'security_model' => 'Role-Based Access Control (RBAC)',
            'visible_data' => ['Personal Attendance', 'Personal Marks', 'Personal Risk Status', 'Personal Profile'],
            'role_explanation' => 'Only your personal academic information is available.',
            'requested_dept' => 'Personal Profile',
            'applied_dept' => 'Personal Profile',
            'role_scope_applied' => 'Personal Profile Security Restriction',
            'explanation' => 'Only your personal academic information is available.',
            'is_cross_dept' => false,
            'scope_notice' => null,
            'why_seeing_this' => null,
        ];
    }

    /**
     * Safely inject a WHERE scope condition into an existing SQL query
     */
    protected static function injectScopeCondition(string $sql, string $condition): string
    {
        $trimSql = trim($sql);

        if (preg_match('/FROM\s*\(\s*SELECT\s+.*?\s+FROM\s+students\s+s\b/i', $trimSql)) {
            $subqueryStart = strpos($trimSql, '(');
            $subqueryEnd = strrpos($trimSql, ')');

            if ($subqueryStart !== false && $subqueryEnd !== false) {
                $subqueryBody = substr($trimSql, $subqueryStart + 1, $subqueryEnd - $subqueryStart - 1);
                $modifiedSubquery = self::injectScopeConditionToSingleQuery($subqueryBody, $condition);
                return substr($trimSql, 0, $subqueryStart + 1) . $modifiedSubquery . substr($trimSql, $subqueryEnd);
            }
        }

        return self::injectScopeConditionToSingleQuery($trimSql, $condition);
    }

    /**
     * Helper to inject condition into a single SELECT query without outer subquery wrapper
     */
    protected static function injectScopeConditionToSingleQuery(string $trimSql, string $condition): string
    {
        $len = strlen($trimSql);
        $parenDepth = 0;
        $topLevelWherePos = -1;
        $topLevelGroupPos = -1;
        $topLevelOrderPos = -1;
        $topLevelLimitPos = -1;

        for ($i = 0; $i < $len; $i++) {
            $char = $trimSql[$i];
            if ($char === '(') {
                $parenDepth++;
            } elseif ($char === ')') {
                $parenDepth--;
            } elseif ($parenDepth === 0) {
                $substr = substr($trimSql, $i);
                if ($topLevelWherePos === -1 && preg_match('/^WHERE\b/i', $substr)) {
                    $topLevelWherePos = $i;
                } elseif ($topLevelGroupPos === -1 && preg_match('/^GROUP\s+BY\b/i', $substr)) {
                    $topLevelGroupPos = $i;
                } elseif ($topLevelOrderPos === -1 && preg_match('/^ORDER\s+BY\b/i', $substr)) {
                    $topLevelOrderPos = $i;
                } elseif ($topLevelLimitPos === -1 && preg_match('/^LIMIT\b/i', $substr)) {
                    $topLevelLimitPos = $i;
                }
            }
        }

        if ($topLevelWherePos !== -1) {
            $insertPos = $topLevelWherePos + 5;
            return substr($trimSql, 0, $insertPos) . " ({$condition}) AND " . substr($trimSql, $insertPos);
        }

        $positions = array_filter([$topLevelGroupPos, $topLevelOrderPos, $topLevelLimitPos], fn($p) => $p !== -1);
        if (!empty($positions)) {
            $insertPos = min($positions);
            return substr($trimSql, 0, $insertPos) . " WHERE ({$condition}) " . substr($trimSql, $insertPos);
        }

        return $trimSql . " WHERE ({$condition})";
    }
}

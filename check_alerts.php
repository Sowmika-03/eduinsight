<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== DUMMY ALERTS ADDED ===\n";
$alerts = DB::table('alerts')->count();
echo "Total Alerts: $alerts\n";

echo "\n=== ALERT DISTRIBUTION ===\n";
$alertsByType = DB::table('alerts')
    ->select('alert_type', DB::raw('COUNT(*) as count'))
    ->groupBy('alert_type')
    ->get();

foreach ($alertsByType as $a) {
    echo "{$a->alert_type}: {$a->count}\n";
}

echo "\n=== RECENT ALERTS ===\n";
$recentAlerts = DB::table('alerts')
    ->join('students', 'alerts.student_id', '=', 'students.id')
    ->join('users', 'students.user_id', '=', 'users.id')
    ->join('courses', 'alerts.course_id', '=', 'courses.id')
    ->select('users.name', 'courses.course_name', 'alerts.alert_type', 'alerts.severity', 'alerts.alert_date')
    ->orderBy('alerts.alert_date', 'desc')
    ->limit(5)
    ->get();

echo "Latest 5 alerts:\n";
foreach ($recentAlerts as $alert) {
    echo "- {$alert->name}: {$alert->alert_type} ({$alert->severity}) - {$alert->course_name} - {$alert->alert_date}\n";
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'account_type' => 'required|in:student,faculty',
        ]);

        // Get the appropriate role
        $role = Role::where('slug', $validated['account_type'])->first();
        
        if (!$role) {
            return back()->withErrors(['account_type' => 'Invalid account type']);
        }

        // Create user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => $role->id,
            'status' => 'active',
        ]);

        // If student, create student profile
        if ($validated['account_type'] === 'student') {
            $studentId = 'STU' . str_pad($user->id, 5, '0', STR_PAD_LEFT);
            \App\Models\Student::create([
                'user_id' => $user->id,
                'student_id' => $studentId,
                'admission_year' => date('Y'),
                'semester' => '1',
                'program' => 'B.Tech',
                'batch' => date('Y') . '-' . (date('Y') + 4),
            ]);
        }
        
        // If faculty, create faculty profile (pending approval)
        elseif ($validated['account_type'] === 'faculty') {
            $employeeId = 'FAC' . str_pad($user->id, 3, '0', STR_PAD_LEFT);
            \App\Models\Faculty::create([
                'user_id' => $user->id,
                'employee_id' => $employeeId,
                'department' => 'General',
                'specialization' => 'General',
                'qualification' => 'Not Specified',
                'experience_years' => 0,
                'approval_status' => 'pending',
                'max_students' => 0,
            ]);
        }

        // Log the user in
        Auth::login($user);
        
        return redirect($this->redirectPath())->with('success', 'Account created successfully!');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended($this->redirectPath());
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'You have been logged out successfully');
    }

    protected function redirectPath()
    {
        $user = Auth::user();
        $role = $user->role->slug ?? null;

        return match($role) {
            'admin' => '/admin/dashboard',
            'hod' => '/hod/dashboard',
            'faculty' => '/faculty/dashboard',
            'student' => '/student/dashboard',
            'parent' => '/parent/dashboard',
            default => '/',
        };
    }
}

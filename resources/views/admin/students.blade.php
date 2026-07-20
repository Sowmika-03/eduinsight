@extends('layouts.app')

@section('title', 'Student Records')

@section('content')

<x-dashboard.section-header 
    title="Enrolled Student Directory" 
    subtitle="Institutional records for 200 enrolled students across MCA, B.Tech CSE, IT, and MBA programs" 
    badge="200 Students">
    <x-slot:actions>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary text-xs">
            <i class="fas fa-arrow-left"></i> Back to Command Center
        </a>
    </x-slot:actions>
</x-dashboard.section-header>

<div class="bg-white border border-slate-200 rounded-2xl p-5 sm:p-6 shadow-xs mb-8">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Student Name</th>
                    <th>Email Address</th>
                    <th>Program & Branch</th>
                    <th>Semester</th>
                    <th>Overall Risk Status</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                    <tr class="hover:bg-slate-50/80 transition duration-150">
                        <!-- Student ID -->
                        <td>
                            <span class="font-mono text-xs font-bold text-slate-900 bg-slate-100 px-2 py-1 rounded border border-slate-200">
                                {{ $student->student_id }}
                            </span>
                        </td>

                        <!-- Name & Avatar -->
                        <td>
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-full bg-slate-900 text-white flex items-center justify-center text-xs font-bold shrink-0">
                                    {{ strtoupper(substr($student->user->name, 0, 2)) }}
                                </div>
                                <span class="font-bold text-slate-900 text-xs">{{ $student->user->name }}</span>
                            </div>
                        </td>

                        <!-- Email -->
                        <td class="text-xs text-slate-600 font-medium">
                            {{ $student->user->email }}
                        </td>

                        <!-- Program & Branch -->
                        <td>
                            <span class="text-xs font-semibold text-slate-800">{{ $student->program }}</span>
                            <span class="text-[11px] text-slate-500 font-medium block">Batch {{ $student->batch ?? $student->admission_year }}</span>
                        </td>

                        <!-- Semester -->
                        <td>
                            <span class="px-2 py-0.5 text-xs font-semibold rounded bg-blue-50 text-blue-700 border border-blue-100">
                                Semester {{ $student->semester }}
                            </span>
                        </td>

                        <!-- Risk Status -->
                        <td>
                            @php
                                $maxRisk = $student->academicRisks->max('risk_level');
                            @endphp
                            @if($maxRisk === 'High Risk')
                                <span class="px-2.5 py-0.5 text-[10px] font-bold rounded-full bg-red-100 text-red-800 border border-red-200">HIGH RISK</span>
                            @elseif($maxRisk === 'Medium Risk')
                                <span class="px-2.5 py-0.5 text-[10px] font-bold rounded-full bg-amber-100 text-amber-800 border border-amber-200">MEDIUM RISK</span>
                            @else
                                <span class="px-2.5 py-0.5 text-[10px] font-bold rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200">LOW RISK</span>
                            @endif
                        </td>

                        <!-- Actions -->
                        <td class="text-right">
                            <a href="{{ route('email.send', ['recipient_type' => 'student', 'student_id' => $student->id, 'subject' => 'Academic Notice - ' . $student->student_id]) }}" 
                               class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-semibold rounded-md bg-blue-50 text-blue-700 hover:bg-blue-600 hover:text-white transition border border-blue-100">
                                <i class="fas fa-paper-plane text-[10px]"></i> Send Email
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-slate-400 py-8">
                            No student records found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $students->links() }}
    </div>
</div>

@endsection

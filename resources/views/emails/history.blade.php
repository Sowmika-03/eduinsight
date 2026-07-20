@extends('layouts.app')

@section('title', 'Email Delivery Logs')

@section('content')

@php
    use App\Models\EmailLog;
    
    // Calculate Email KPI Metrics
    $queryBase = EmailLog::query();
    if (Auth::user()->role->slug !== 'admin') {
        $queryBase->where('sender_id', Auth::id());
    }

    $totalSentCount = (clone $queryBase)->count();
    $deliveredCount = (clone $queryBase)->where('status', 'sent')->count();
    $pendingCount   = (clone $queryBase)->where('status', 'pending')->count();
    $failedCount    = (clone $queryBase)->where('status', 'failed')->count();
@endphp

<!-- Header & Action Bar -->
<div class="bg-white border border-slate-200 rounded-2xl p-5 sm:p-6 mb-8 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
        <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-purple-600 mb-1">
            <i class="fas fa-history"></i>
            <span>Institutional Communication Gateway</span>
        </div>
        <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">
            Email Delivery Logs & Audit
        </h1>
        <p class="text-xs text-slate-500 font-medium mt-0.5">
            Audit logs of sent academic warnings, parent notifications, and automated SMTP delivery statuses
        </p>
    </div>

    <div class="flex items-center gap-2 shrink-0">
        <a href="{{ route('email.send') }}" class="px-4 py-2 text-xs font-bold rounded-xl bg-blue-600 hover:bg-blue-700 text-white transition shadow-2xs flex items-center gap-1.5">
            <i class="fas fa-paper-plane text-xs"></i>
            <span>Send New Notification</span>
        </a>
    </div>
</div>

<!-- 4 KPI Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <x-dashboard.kpi-card 
        title="Emails Sent" 
        value="{{ $totalSentCount }}" 
        icon="fas fa-paper-plane" 
        color="purple" 
        change="Total Dispatched Messages" 
        changeType="neutral" 
        subtitle="Notification Log" />

    <x-dashboard.kpi-card 
        title="Delivered" 
        value="{{ $deliveredCount }}" 
        icon="fas fa-check-circle" 
        color="emerald" 
        change="{{ $totalSentCount > 0 ? round(($deliveredCount / $totalSentCount) * 100, 1) : 100 }}% Success Rate" 
        changeType="up" 
        subtitle="SMTP Gateway" />

    <x-dashboard.kpi-card 
        title="Pending" 
        value="{{ $pendingCount }}" 
        icon="fas fa-clock" 
        color="amber" 
        change="Queue Processing" 
        changeType="neutral" 
        subtitle="Awaiting Delivery" />

    <x-dashboard.kpi-card 
        title="Failed" 
        value="{{ $failedCount }}" 
        icon="fas fa-exclamation-circle" 
        color="red" 
        change="{{ $failedCount > 0 ? 'Resend Available' : 'No Delivery Errors' }}" 
        changeType="{{ $failedCount > 0 ? 'down' : 'up' }}" 
        subtitle="Bounce / Error Logs" />
</div>

<!-- Search & Filter Controls -->
<div class="bg-white border border-slate-200 rounded-2xl p-4 sm:p-5 mb-8 shadow-xs">
    <form method="GET" action="{{ route('email.history') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-3 items-end">
        <!-- Search Field -->
        <div class="sm:col-span-2">
            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Search Logs</label>
            <div class="relative">
                <i class="fas fa-search absolute left-3.5 top-2.5 text-slate-400 text-xs"></i>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Search by subject, recipient email, or message text..." 
                       class="w-full pl-9 pr-4 py-1.5 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-blue-500 text-slate-900 font-medium">
            </div>
        </div>

        <!-- Status Filter & Submit -->
        <div class="flex items-center gap-2">
            <div class="flex-1">
                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Status Filter</label>
                <select name="status" class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-xs rounded-xl px-3 py-1.5 font-medium focus:bg-white focus:border-blue-500">
                    <option value="">All Statuses</option>
                    <option value="sent" {{ request('status') === 'sent' ? 'selected' : '' }}>Delivered / Sent</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
            </div>

            <div class="flex items-center gap-1.5 self-end">
                <button type="submit" class="px-4 py-1.5 text-xs font-bold rounded-xl bg-slate-900 text-white hover:bg-slate-800 transition">
                    Apply
                </button>
                <a href="{{ route('email.history') }}" class="px-3 py-1.5 text-xs font-semibold rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 transition border border-slate-200">
                    Reset
                </a>
            </div>
        </div>
    </form>
</div>

<!-- Modernized Delivery Log Table -->
<div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-xs">
    @if ($emailLogs->count())
        <div class="table-responsive">
            <table class="table mb-0">
                <thead class="sticky top-0 bg-slate-50 border-b border-slate-200 z-10">
                    <tr>
                        <th class="text-xs font-bold text-slate-700 py-3">Subject & Message Preview</th>
                        <th class="text-xs font-bold text-slate-700 py-3">Recipient Email</th>
                        <th class="text-xs font-bold text-slate-700 py-3">Dispatched By</th>
                        <th class="text-xs font-bold text-slate-700 py-3">Delivery Status</th>
                        <th class="text-xs font-bold text-slate-700 py-3">Timestamp</th>
                        <th class="text-xs font-bold text-slate-700 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($emailLogs as $log)
                        <tr class="hover:bg-slate-50/80 transition duration-150">
                            <td class="text-xs py-3">
                                <span class="font-extrabold text-slate-900 block leading-snug">{{ Str::limit($log->subject, 45) }}</span>
                                <span class="text-[11px] text-slate-400 font-medium block mt-0.5">{{ Str::limit($log->message, 65) }}</span>
                            </td>
                            <td class="text-xs font-bold text-slate-800 py-3">
                                <code class="px-2 py-0.5 rounded bg-slate-100 text-blue-700 font-mono text-[11px]">{{ $log->receiver_email }}</code>
                            </td>
                            <td class="text-xs font-semibold text-slate-600 py-3">
                                {{ $log->sender->name ?? 'System Gateway' }}
                            </td>
                            <td class="text-xs py-3">
                                @if ($log->status === 'sent')
                                    <span class="px-2.5 py-0.5 text-[10px] font-bold rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200">
                                        DELIVERED
                                    </span>
                                @elseif ($log->status === 'failed')
                                    <span class="px-2.5 py-0.5 text-[10px] font-bold rounded-full bg-red-100 text-red-800 border border-red-200">
                                        FAILED
                                    </span>
                                @else
                                    <span class="px-2.5 py-0.5 text-[10px] font-bold rounded-full bg-amber-100 text-amber-800 border border-amber-200">
                                        PENDING
                                    </span>
                                @endif
                            </td>
                            <td class="text-xs text-slate-500 font-medium py-3">
                                {{ $log->sent_at ? $log->sent_at->format('M d, Y g:i A') . ' IST' : 'Recent' }}
                            </td>
                            <td class="text-xs py-3 text-right">
                                @if ($log->status === 'failed')
                                    <form action="{{ route('email.resend', $log) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit" class="px-2.5 py-1 text-xs font-bold rounded-lg bg-amber-50 text-amber-800 border border-amber-200 hover:bg-amber-100 transition" title="Resend Email">
                                            Resend
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-200 bg-slate-50/50">
            {{ $emailLogs->links() }}
        </div>
    @else
        <div class="p-10 text-center text-slate-400 text-xs">
            <i class="fas fa-inbox text-3xl text-slate-300 block mb-2"></i>
            No email delivery logs found matching search criteria.
        </div>
    @endif
</div>

@endsection

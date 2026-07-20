@extends('layouts.app')

@section('title', 'Email Delivery Audit Dashboard')

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

<div x-data="{ activeTab: 'table' }" class="space-y-6">

    <!-- Header & Action Bar -->
    <div class="bg-white border border-slate-200/90 rounded-2xl p-5 sm:p-6 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-purple-600 mb-1">
                <i class="fas fa-history"></i>
                <span>Institutional Communication Audit</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Email Delivery History
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">
                Audit logs, SMTP delivery status tracking, failed email retry controls, and timeline analytics.
            </p>
        </div>

        <div class="flex items-center gap-3 shrink-0">
            <div class="bg-slate-100 p-1 rounded-xl flex items-center border border-slate-200">
                <button @click="activeTab = 'table'" :class="activeTab === 'table' ? 'bg-white text-blue-700 shadow-2xs font-bold' : 'text-slate-600 font-semibold'" class="px-3 py-1.5 text-xs rounded-lg transition">
                    <i class="fas fa-table"></i> Logs Table
                </button>
                <button @click="activeTab = 'timeline'" :class="activeTab === 'timeline' ? 'bg-white text-purple-700 shadow-2xs font-bold' : 'text-slate-600 font-semibold'" class="px-3 py-1.5 text-xs rounded-lg transition">
                    <i class="fas fa-stream"></i> Timeline View
                </button>
            </div>

            <a href="{{ route('email.send') }}" class="px-4 py-2 text-xs font-extrabold rounded-xl bg-blue-600 hover:bg-blue-700 text-white transition shadow-2xs flex items-center gap-1.5">
                <i class="fas fa-paper-plane text-xs"></i>
                <span>Send Notification</span>
            </a>
        </div>
    </div>

    <!-- 4 KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
                <span>Total Emails</span>
                <i class="fas fa-paper-plane text-purple-500"></i>
            </div>
            <div class="text-2xl font-black text-slate-900 mt-1">{{ $totalSentCount }}</div>
            <div class="text-[11px] text-purple-700 font-semibold mt-1">Dispatched Notifications</div>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
                <span>Delivered</span>
                <i class="fas fa-check-circle text-emerald-500"></i>
            </div>
            <div class="text-2xl font-black text-emerald-600 mt-1">{{ $deliveredCount }}</div>
            <div class="text-[11px] text-emerald-600 font-bold mt-1">{{ $totalSentCount > 0 ? round(($deliveredCount / $totalSentCount) * 100, 1) : 100 }}% Delivery Success</div>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
                <span>Pending Queue</span>
                <i class="fas fa-clock text-amber-500"></i>
            </div>
            <div class="text-2xl font-black text-amber-600 mt-1">{{ $pendingCount }}</div>
            <div class="text-[11px] text-slate-500 font-medium mt-1">SMTP Queue</div>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
                <span>Failed Deliveries</span>
                <i class="fas fa-exclamation-circle text-red-500"></i>
            </div>
            <div class="text-2xl font-black text-red-600 mt-1">{{ $failedCount }}</div>
            <div class="text-[11px] text-red-600 font-bold mt-1">{{ $failedCount > 0 ? 'Action Required' : 'Zero Errors' }}</div>
        </div>
    </div>

    <!-- Search & Filter Controls -->
    <div class="bg-white border border-slate-200 rounded-2xl p-4 sm:p-5 shadow-xs">
        <form method="GET" action="{{ route('email.history') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-3 items-end">
            <div class="sm:col-span-2">
                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Search Email Logs</label>
                <div class="relative">
                    <i class="fas fa-search absolute left-3.5 top-2.5 text-slate-400 text-xs"></i>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Search subject, recipient email, or content..." 
                           class="w-full pl-9 pr-4 py-1.5 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-blue-500 text-slate-900 font-medium">
                </div>
            </div>

            <div class="flex items-center gap-2">
                <div class="flex-1">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Status Filter</label>
                    <select name="status" class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-xs rounded-xl px-3 py-1.5 font-semibold focus:bg-white focus:border-blue-500">
                        <option value="">All Statuses</option>
                        <option value="sent" {{ request('status') === 'sent' ? 'selected' : '' }}>Delivered / Sent</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed</option>
                    </select>
                </div>

                <div class="flex items-center gap-1.5 self-end">
                    <button type="submit" class="px-4 py-1.5 text-xs font-bold rounded-xl bg-slate-900 text-white hover:bg-slate-800 transition">
                        Filter
                    </button>
                    <a href="{{ route('email.history') }}" class="px-3 py-1.5 text-xs font-semibold rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 transition border border-slate-200">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- TABLE VIEW -->
    <div x-show="activeTab === 'table'" class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-xs">
        @if ($emailLogs->count())
            <div class="table-responsive">
                <table class="table mb-0 w-full text-left border-collapse">
                    <thead class="sticky top-0 bg-slate-50 border-b border-slate-200 z-10 text-[11px] uppercase tracking-wider text-slate-500 font-extrabold">
                        <tr>
                            <th class="py-3 px-4">Subject & Message Preview</th>
                            <th class="py-3 px-4">Recipient</th>
                            <th class="py-3 px-4">Dispatched By</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4">Delivery Time</th>
                            <th class="py-3 px-4 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs">
                        @foreach ($emailLogs as $log)
                            <tr class="hover:bg-slate-50/80 transition duration-150">
                                <td class="py-3 px-4">
                                    <span class="font-extrabold text-slate-900 block leading-snug">{{ Str::limit($log->subject, 45) }}</span>
                                    <span class="text-[11px] text-slate-500 font-medium block mt-0.5">{{ Str::limit($log->message, 65) }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    <code class="px-2 py-0.5 rounded bg-blue-50 text-blue-700 font-mono text-[11px] font-bold border border-blue-100">{{ $log->receiver_email }}</code>
                                </td>
                                <td class="py-3 px-4 font-semibold text-slate-600">
                                    {{ $log->sender->name ?? 'System Admin' }}
                                </td>
                                <td class="py-3 px-4">
                                    @if ($log->status === 'sent')
                                        <span class="px-2.5 py-0.5 text-[10px] font-black rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200">
                                            DELIVERED
                                        </span>
                                    @elseif ($log->status === 'failed')
                                        <span class="px-2.5 py-0.5 text-[10px] font-black rounded-full bg-red-100 text-red-800 border border-red-200">
                                            FAILED
                                        </span>
                                    @else
                                        <span class="px-2.5 py-0.5 text-[10px] font-black rounded-full bg-amber-100 text-amber-800 border border-amber-200">
                                            PENDING
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-slate-500 font-medium">
                                    {{ $log->sent_at ? $log->sent_at->format('M d, Y g:i A') : 'Recent' }}
                                </td>
                                <td class="py-3 px-4 text-right">
                                    @if ($log->status === 'failed')
                                        <form action="{{ route('email.resend', $log) }}" method="POST" class="inline-block">
                                            @csrf
                                            <button type="submit" class="px-2.5 py-1 text-xs font-bold rounded-lg bg-amber-100 hover:bg-amber-200 text-amber-900 border border-amber-200 transition" title="Retry Sending">
                                                <i class="fas fa-redo text-[10px]"></i> Retry
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-slate-400 text-[11px]">&mdash;</span>
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
            <!-- EMPTY STATE ILLUSTRATION -->
            <div class="p-12 text-center text-slate-400 space-y-3">
                <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto text-2xl">
                    <i class="fas fa-inbox"></i>
                </div>
                <h4 class="text-sm font-extrabold text-slate-700">No Email History Found</h4>
                <p class="text-xs text-slate-500 max-w-sm mx-auto">No dispatched email logs match your current search filters.</p>
                <a href="{{ route('email.send') }}" class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-bold rounded-xl bg-blue-600 text-white hover:bg-blue-700 transition">
                    <i class="fas fa-paper-plane"></i> Send First Notification
                </a>
            </div>
        @endif
    </div>

    <!-- TIMELINE VIEW -->
    <div x-show="activeTab === 'timeline'" class="bg-white border border-slate-200 rounded-2xl p-6 shadow-xs">
        <h3 class="text-xs font-extrabold uppercase text-slate-800 tracking-wider mb-4 flex items-center gap-2">
            <i class="fas fa-stream text-purple-600"></i> Dispatch Timeline
        </h3>
        
        <div class="relative border-l-2 border-slate-200 ml-4 space-y-6">
            @forelse($emailLogs as $log)
                <div class="ml-6 relative">
                    <div class="absolute -left-[31px] top-0.5 w-4 h-4 rounded-full border-2 border-white {{ $log->status === 'sent' ? 'bg-emerald-500' : ($log->status === 'failed' ? 'bg-red-500' : 'bg-amber-500') }}"></div>
                    <div class="text-xs text-slate-400 font-semibold">{{ $log->sent_at ? $log->sent_at->format('M d, Y g:i A') : 'Recent' }}</div>
                    <div class="text-xs font-extrabold text-slate-900 mt-0.5">{{ $log->subject }}</div>
                    <div class="text-xs text-slate-600 font-medium">To: <code class="text-blue-700">{{ $log->receiver_email }}</code></div>
                    <div class="text-[11px] text-slate-500 bg-slate-50 p-2 rounded-lg mt-1 border border-slate-100">{{ Str::limit($log->message, 100) }}</div>
                </div>
            @empty
                <div class="text-xs text-slate-400 ml-6">No timeline events recorded.</div>
            @endforelse
        </div>
    </div>

</div>
@endsection

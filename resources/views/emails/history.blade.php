@extends('layouts.app')

@section('title', 'Email Delivery Logs')

@section('content')
<div class="space-y-6">

    <!-- Header & Action Bar -->
    <div class="bg-white border border-slate-200/80 rounded-2xl p-5 sm:p-6 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-purple-600 mb-1">
                <i class="fas fa-history"></i>
                <span>Institutional Communication Gateway</span>
            </div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">
                Email Notification Delivery Logs
            </h1>
            <p class="text-xs text-slate-500 font-medium mt-0.5">
                Audit logs of sent academic warnings, parent notifications, and automated email delivery statuses.
            </p>
        </div>

        <div class="flex items-center gap-2 shrink-0">
            <a href="{{ route('email.send') }}" class="px-4 py-2 text-xs font-bold rounded-xl bg-blue-600 hover:bg-blue-700 text-white transition shadow-2xs flex items-center gap-1.5">
                <i class="fas fa-paper-plane text-xs"></i>
                <span>Send New Notification</span>
            </a>
        </div>
    </div>

    <!-- Search & Filter Controls -->
    <div class="bg-white border border-slate-200/90 rounded-2xl p-4 shadow-xs">
        <form method="GET" action="{{ route('email.history') }}" class="flex flex-col sm:flex-row items-center justify-between gap-3">
            <div class="relative flex-1 w-full">
                <i class="fas fa-search absolute left-3.5 top-3 text-slate-400 text-xs"></i>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Search by subject, email, or message text..." 
                       class="w-full pl-9 pr-4 py-2 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-0 text-slate-900 font-medium">
            </div>

            <div class="flex items-center gap-2 w-full sm:w-auto">
                <select name="status" class="bg-slate-50 border border-slate-200 text-slate-700 text-xs rounded-xl px-3 py-2 font-medium focus:ring-0 focus:border-blue-500">
                    <option value="">All Statuses</option>
                    <option value="sent" {{ request('status') === 'sent' ? 'selected' : '' }}>Delivered / Sent</option>
                    <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                </select>

                <button type="submit" class="px-4 py-2 text-xs font-bold rounded-xl bg-slate-900 text-white hover:bg-slate-800 transition">
                    Filter Logs
                </button>
            </div>
        </form>
    </div>

    <!-- Delivery Logs Table (Full Width 90-95%) -->
    <div class="bg-white border border-slate-200/90 rounded-2xl overflow-hidden shadow-xs">
        @if ($emailLogs->count())
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="text-xs font-bold text-slate-700 py-3">Subject & Preview</th>
                            <th class="text-xs font-bold text-slate-700 py-3">Recipient Email</th>
                            <th class="text-xs font-bold text-slate-700 py-3">Sent By</th>
                            <th class="text-xs font-bold text-slate-700 py-3">Status</th>
                            <th class="text-xs font-bold text-slate-700 py-3">Timestamp</th>
                            <th class="text-xs font-bold text-slate-700 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($emailLogs as $log)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="text-xs py-3">
                                    <span class="font-extrabold text-slate-900 block leading-snug">{{ Str::limit($log->subject, 45) }}</span>
                                    <span class="text-[11px] text-slate-400 font-medium block mt-0.5">{{ Str::limit($log->message, 65) }}</span>
                                </td>
                                <td class="text-xs font-bold text-slate-800 py-3">
                                    {{ $log->receiver_email }}
                                </td>
                                <td class="text-xs font-semibold text-slate-600 py-3">
                                    {{ $log->sender->name ?? 'System' }}
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
                                            <button type="submit" class="px-2.5 py-1 text-xs font-bold rounded-lg bg-amber-50 text-amber-800 border border-amber-200 hover:bg-amber-100 transition mr-1" title="Resend Email">
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

            <div class="p-4 border-t border-slate-200">
                {{ $emailLogs->links() }}
            </div>
        @else
            <div class="p-10 text-center text-slate-400 text-xs">
                <i class="fas fa-inbox text-3xl text-slate-300 block mb-2"></i>
                No email delivery logs found matching search criteria.
            </div>
        @endif
    </div>

</div>
@endsection

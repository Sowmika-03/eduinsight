@extends('layouts.app')

@section('title', 'EduInsight AI - Queries & History Analytics')

@section('content')

@php
    $totalQueries = \App\Models\NlQuery::count();
    $successQueries = \App\Models\NlQuery::where('query_status', 'success')->count();
    $successRate = $totalQueries > 0 ? round(($successQueries / $totalQueries) * 100, 1) : 100;
    $avgSpeed = \App\Models\NlQuery::avg('execution_time') ? round(\App\Models\NlQuery::avg('execution_time')) : 14;
@endphp

<div class="space-y-6">

    <!-- Header & Action Bar -->
    <div class="bg-white border border-slate-200/80 rounded-2xl p-5 sm:p-6 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-purple-600 mb-1">
                <i class="fas fa-brain"></i>
                <span>EduInsight AI &bull; Intelligence Audit Logs</span>
            </div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">
                AI Query History & Execution Analytics
            </h1>
            <p class="text-xs text-slate-500 font-medium mt-0.5">
                Audit logs of natural language queries, database SQL execution speeds, and user decision support conversations.
            </p>
        </div>

        <div class="flex items-center gap-2 shrink-0">
            <a href="{{ route('nlp.create') }}" class="px-4 py-2 text-xs font-bold rounded-xl bg-blue-600 hover:bg-blue-700 text-white transition shadow-2xs inline-flex items-center gap-2">
                <i class="fas fa-plus-circle text-xs"></i>
                <span>New AI Conversation</span>
            </a>
        </div>
    </div>

    <!-- Analytics KPI Cards (4 Columns Full Width) -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white border border-slate-200/90 rounded-2xl p-4 shadow-xs">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Total AI Queries</span>
            <div class="flex items-baseline justify-between">
                <span class="text-2xl font-extrabold text-slate-900">{{ $totalQueries }}</span>
                <i class="fas fa-comments text-purple-600 text-base"></i>
            </div>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-2xl p-4 shadow-xs">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Execution Success Rate</span>
            <div class="flex items-baseline justify-between">
                <span class="text-2xl font-extrabold text-emerald-600">{{ $successRate }}%</span>
                <i class="fas fa-check-circle text-emerald-600 text-base"></i>
            </div>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-2xl p-4 shadow-xs">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Avg Execution Speed</span>
            <div class="flex items-baseline justify-between">
                <span class="text-2xl font-extrabold text-blue-600">{{ $avgSpeed }}ms</span>
                <i class="fas fa-bolt text-amber-500 text-base"></i>
            </div>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-2xl p-4 shadow-xs">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Status Badge</span>
            <div class="flex items-center gap-2 mt-1">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                <span class="text-xs font-bold text-emerald-700">EduInsight AI Online</span>
            </div>
        </div>
    </div>

    <!-- Search & Filter Controls -->
    <div class="bg-white border border-slate-200/90 rounded-2xl p-4 shadow-xs">
        <form action="{{ route('nlp.index') }}" method="GET" class="flex flex-col sm:flex-row items-center justify-between gap-3">
            <div class="relative flex-1 w-full">
                <i class="fas fa-search absolute left-3.5 top-3 text-slate-400 text-xs"></i>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Search query text, user name, or SQL..." 
                       class="w-full pl-9 pr-4 py-2 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-0 text-slate-900 font-medium">
            </div>

            <div class="flex items-center gap-2 w-full sm:w-auto">
                <select name="status" class="bg-slate-50 border border-slate-200 text-slate-700 text-xs rounded-xl px-3 py-2 font-medium focus:ring-0 focus:border-blue-500">
                    <option value="">All Statuses</option>
                    <option value="success" {{ request('status') == 'success' ? 'selected' : '' }}>Success Only</option>
                    <option value="error" {{ request('status') == 'error' ? 'selected' : '' }}>Error Only</option>
                </select>
                <button type="submit" class="px-4 py-2 text-xs font-bold rounded-xl bg-slate-900 text-white hover:bg-slate-800 transition">
                    Filter Logs
                </button>
            </div>
        </form>
    </div>

    <!-- Query Audit Log Table (Full Width 90-95%) -->
    <div class="bg-white border border-slate-200/90 rounded-2xl overflow-hidden shadow-xs">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="text-xs font-bold text-slate-700 py-3">Natural Language Query</th>
                        <th class="text-xs font-bold text-slate-700 py-3">User & Role</th>
                        <th class="text-xs font-bold text-slate-700 py-3">Status</th>
                        <th class="text-xs font-bold text-slate-700 py-3">Records Returned</th>
                        <th class="text-xs font-bold text-slate-700 py-3">Speed</th>
                        <th class="text-xs font-bold text-slate-700 py-3">Timestamp</th>
                        <th class="text-xs font-bold text-slate-700 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($queries as $query)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="text-xs py-3">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-xs shrink-0">
                                        <i class="fas fa-brain"></i>
                                    </div>
                                    <span class="font-extrabold text-slate-900">{{ $query->natural_language_query }}</span>
                                </div>
                            </td>
                            <td class="text-xs py-3">
                                <span class="font-bold text-slate-800 block">{{ $query->user->name ?? 'User' }}</span>
                                <span class="text-[10px] text-slate-400 uppercase tracking-wider font-semibold">{{ $query->user->role->slug ?? 'Admin' }}</span>
                            </td>
                            <td class="text-xs py-3">
                                @if($query->query_status === 'success')
                                    <span class="px-2.5 py-0.5 text-[10px] font-bold rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200">SUCCESS</span>
                                @elseif($query->query_status === 'error')
                                    <span class="px-2.5 py-0.5 text-[10px] font-bold rounded-full bg-red-100 text-red-800 border border-red-200">ERROR</span>
                                @else
                                    <span class="px-2.5 py-0.5 text-[10px] font-bold rounded-full bg-amber-100 text-amber-800 border border-amber-200">PROCESSING</span>
                                @endif
                            </td>
                            <td class="text-xs font-bold text-slate-800 py-3">
                                {{ $query->result_count ?? 0 }} Records
                            </td>
                            <td class="text-xs font-mono text-slate-500 py-3">
                                {{ $query->execution_time }}ms
                            </td>
                            <td class="text-xs text-slate-500 font-medium py-3">
                                {{ $query->created_at ? $query->created_at->format('M d, Y g:i A') : 'Recent' }} IST
                            </td>
                            <td class="text-xs py-3 text-right">
                                <a href="{{ route('nlp.show', $query) }}" class="px-3 py-1.5 text-xs font-bold rounded-xl bg-blue-50 text-blue-700 hover:bg-blue-600 hover:text-white transition border border-blue-200">
                                    View Response &rarr;
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-slate-400 py-8 text-xs">
                                <i class="fas fa-comments text-2xl text-slate-300 block mb-2"></i>
                                No query logs recorded.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-200">
            {{ $queries->links() }}
        </div>
    </div>

</div>

@endsection

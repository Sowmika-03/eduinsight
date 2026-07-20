@extends('layouts.app')

@section('title', 'EduInsight AI - Academic Assistant')

@section('content')

@php
    $allQueries = \App\Models\NlQuery::where('user_id', Auth::id())->latest()->get();
    
    // Group Query History into Today, Yesterday, and Older
    $todayQueries     = $allQueries->filter(fn($q) => $q->created_at->isToday());
    $yesterdayQueries = $allQueries->filter(fn($q) => $q->created_at->isYesterday());
    $olderQueries     = $allQueries->filter(fn($q) => !$q->created_at->isToday() && !$q->created_at->isYesterday());

    $roleSlug = Auth::user()->role->slug ?? 'admin';
    $roleName = ucfirst(Auth::user()->role->name ?? $roleSlug);
@endphp

<div class="grid grid-cols-1 lg:grid-cols-4 gap-6 min-h-[calc(100vh-140px)]">
    
    <!-- LEFT SIDEBAR: Clean Grouped Query History -->
    <div class="lg:col-span-1 space-y-4">
        <div class="bg-white border border-slate-200/80 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-3">
                <div class="flex items-center gap-2">
                    <i class="fas fa-history text-blue-600 text-xs"></i>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800">Query History</h3>
                </div>
                <a href="{{ route('nlp.create') }}" class="p-1 text-xs font-bold text-blue-600 hover:text-blue-800 transition" title="New AI Session">
                    <i class="fas fa-plus-circle"></i>
                </a>
            </div>

            <div class="space-y-3 max-h-[520px] overflow-y-auto pr-1">
                
                <!-- TODAY GROUP -->
                @if($todayQueries->isNotEmpty())
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-blue-600 block mb-1.5 px-1">Today</span>
                        <div class="space-y-1.5">
                            @foreach($todayQueries as $qItem)
                                <div class="group p-2.5 rounded-xl border border-slate-200/80 hover:border-blue-300 hover:bg-slate-50 transition">
                                    <a href="{{ route('nlp.show', $qItem) }}" class="block">
                                        <p class="text-xs font-semibold text-slate-800 group-hover:text-blue-600 truncate leading-snug">
                                            {{ $qItem->natural_language_query }}
                                        </p>
                                    </a>
                                    <div class="flex items-center justify-between mt-1.5 text-[10px] text-slate-400">
                                        <span>{{ $qItem->created_at->format('h:i A') }}</span>
                                        <div class="flex items-center gap-2">
                                            <button type="button" class="text-slate-300 hover:text-amber-500 transition" title="Favorite"><i class="fas fa-star"></i></button>
                                            <button type="button" class="text-slate-300 hover:text-blue-600 transition" title="Pin"><i class="fas fa-thumbtack"></i></button>
                                            <button type="button" class="text-slate-300 hover:text-red-600 transition" title="Delete"><i class="fas fa-trash-alt"></i></button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- YESTERDAY GROUP -->
                @if($yesterdayQueries->isNotEmpty())
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-1.5 px-1">Yesterday</span>
                        <div class="space-y-1.5">
                            @foreach($yesterdayQueries as $qItem)
                                <div class="group p-2.5 rounded-xl border border-slate-200/80 hover:border-blue-300 hover:bg-slate-50 transition">
                                    <a href="{{ route('nlp.show', $qItem) }}" class="block">
                                        <p class="text-xs font-semibold text-slate-800 group-hover:text-blue-600 truncate leading-snug">
                                            {{ $qItem->natural_language_query }}
                                        </p>
                                    </a>
                                    <div class="flex items-center justify-between mt-1.5 text-[10px] text-slate-400">
                                        <span>Yesterday</span>
                                        <div class="flex items-center gap-2">
                                            <button type="button" class="text-slate-300 hover:text-amber-500 transition"><i class="fas fa-star"></i></button>
                                            <button type="button" class="text-slate-300 hover:text-blue-600 transition"><i class="fas fa-thumbtack"></i></button>
                                            <button type="button" class="text-slate-300 hover:text-red-600 transition"><i class="fas fa-trash-alt"></i></button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- OLDER GROUP -->
                @if($olderQueries->isNotEmpty())
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-1.5 px-1">Older Conversations</span>
                        <div class="space-y-1.5">
                            @foreach($olderQueries as $qItem)
                                <div class="group p-2.5 rounded-xl border border-slate-200/80 hover:border-blue-300 hover:bg-slate-50 transition">
                                    <a href="{{ route('nlp.show', $qItem) }}" class="block">
                                        <p class="text-xs font-semibold text-slate-800 group-hover:text-blue-600 truncate leading-snug">
                                            {{ $qItem->natural_language_query }}
                                        </p>
                                    </a>
                                    <div class="flex items-center justify-between mt-1.5 text-[10px] text-slate-400">
                                        <span>{{ $qItem->created_at->format('M d, Y') }}</span>
                                        <div class="flex items-center gap-2">
                                            <button type="button" class="text-slate-300 hover:text-amber-500 transition"><i class="fas fa-star"></i></button>
                                            <button type="button" class="text-slate-300 hover:text-blue-600 transition"><i class="fas fa-thumbtack"></i></button>
                                            <button type="button" class="text-slate-300 hover:text-red-600 transition"><i class="fas fa-trash-alt"></i></button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($allQueries->isEmpty())
                    <div class="text-center py-6 text-slate-400 text-xs">
                        <i class="fas fa-comments text-lg block mb-1 text-slate-300"></i>
                        No previous query history.
                    </div>
                @endif

            </div>
        </div>
    </div>

    <!-- MAIN DECISION SUPPORT ASSISTANT INTERFACE -->
    <div class="lg:col-span-3 flex flex-col justify-between bg-white border border-slate-200/80 rounded-2xl p-6 sm:p-8 shadow-xs relative">
        
        <div>
            <!-- Header Section -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-5 mb-8">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight flex items-center gap-2">
                        <span>EduInsight AI</span>
                    </h1>
                    <p class="text-xs sm:text-sm font-semibold text-slate-500 mt-1">
                        Academic Decision Support Assistant
                    </p>
                </div>
                
                <!-- Status Badge -->
                <span class="px-3.5 py-1.5 text-xs font-bold rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 shrink-0 self-start sm:self-auto flex items-center gap-2 shadow-2xs">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>EduInsight AI Online</span>
                </span>
            </div>

            <!-- Intro / Description Box -->
            <div class="mb-8">
                <p class="text-xs sm:text-sm text-slate-600 font-medium leading-relaxed">
                    Ask anything about attendance, marks, student performance, risk prediction, faculty analytics or academic reports.
                </p>
            </div>

            <!-- Primary Focus Search Area -->
            <form action="{{ route('nlp.store') }}" method="POST" id="queryForm" onsubmit="animateProcessingTimeline(event)" class="mb-8">
                @csrf
                <div class="bg-slate-50 border border-slate-200/90 rounded-2xl p-3 focus-within:border-blue-600 focus-within:bg-white focus-within:ring-2 focus-within:ring-blue-100 transition duration-200 shadow-xs">
                    <textarea name="natural_language_query" id="natural_language_query" rows="3" 
                              class="w-full bg-transparent border-0 focus:ring-0 text-xs sm:text-sm text-slate-900 placeholder-slate-400 resize-none font-medium" 
                              placeholder="Ask EduInsight AI about students, attendance, marks, faculty or academic analytics..." required></textarea>
                    
                    <div class="flex items-center justify-between border-t border-slate-200/60 pt-2.5 px-1">
                        <span class="text-[11px] text-slate-400 font-medium">Press Enter to send query</span>
                        <button type="submit" id="submitBtn" class="px-5 py-2 text-xs font-bold rounded-xl bg-blue-600 hover:bg-blue-700 text-white transition shadow-sm inline-flex items-center gap-2">
                            <span>Send</span>
                            <i class="fas fa-paper-plane text-[10px]"></i>
                        </button>
                    </div>
                </div>
            </form>

            <!-- Sequential Animated Steps Timeline (Hidden by default) -->
            <div id="processingTimelineBox" class="hidden mb-8 p-4 sm:p-5 rounded-2xl bg-blue-50/80 border border-blue-200/80 text-blue-950 text-xs shadow-2xs space-y-2">
                <div class="flex items-center gap-2 font-bold text-blue-900 mb-1">
                    <i class="fas fa-circle-notch fa-spin text-blue-600"></i>
                    <span>EduInsight AI Processing Timeline</span>
                </div>
                <div class="space-y-1.5 font-medium pl-6 text-slate-700">
                    <p id="pStep1" class="transition opacity-30">🧠 Understanding your question...</p>
                    <p id="pStep2" class="transition opacity-30">🔍 Searching academic records...</p>
                    <p id="pStep3" class="transition opacity-30">📊 Analysing attendance, marks and risk...</p>
                    <p id="pStep4" class="transition opacity-30">💡 Generating recommendations...</p>
                    <p id="pStep5" class="transition opacity-30 font-bold text-emerald-700">✅ Response ready.</p>
                </div>
            </div>

            <!-- 6 Suggested Prompt Cards -->
            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3 flex items-center gap-1.5">
                    <i class="fas fa-lightbulb text-amber-500"></i> Suggested Questions
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                    <button type="button" onclick="setQuery('Show students below 75% attendance')" 
                            class="text-left p-3.5 rounded-xl bg-white border border-slate-200 hover:border-blue-400 hover:bg-blue-50/40 transition duration-150 shadow-2xs group flex flex-col justify-between">
                        <div class="flex items-center justify-between w-full mb-1">
                            <span class="text-xs font-bold text-slate-900 group-hover:text-blue-600">Students below 75% attendance</span>
                            <i class="fas fa-arrow-right text-[10px] text-slate-300 group-hover:text-blue-600"></i>
                        </div>
                        <span class="text-[11px] text-slate-400 font-medium">Filter attendance shortages</span>
                    </button>

                    <button type="button" onclick="setQuery('Show High Risk students')" 
                            class="text-left p-3.5 rounded-xl bg-white border border-slate-200 hover:border-blue-400 hover:bg-blue-50/40 transition duration-150 shadow-2xs group flex flex-col justify-between">
                        <div class="flex items-center justify-between w-full mb-1">
                            <span class="text-xs font-bold text-slate-900 group-hover:text-blue-600">High Risk Students</span>
                            <i class="fas fa-arrow-right text-[10px] text-slate-300 group-hover:text-blue-600"></i>
                        </div>
                        <span class="text-[11px] text-slate-400 font-medium">Critical academic risk candidates</span>
                    </button>

                    <button type="button" onclick="setQuery('Department attendance summary')" 
                            class="text-left p-3.5 rounded-xl bg-white border border-slate-200 hover:border-blue-400 hover:bg-blue-50/40 transition duration-150 shadow-2xs group flex flex-col justify-between">
                        <div class="flex items-center justify-between w-full mb-1">
                            <span class="text-xs font-bold text-slate-900 group-hover:text-blue-600">Department Analytics</span>
                            <i class="fas fa-arrow-right text-[10px] text-slate-300 group-hover:text-blue-600"></i>
                        </div>
                        <span class="text-[11px] text-slate-400 font-medium">Departmental performance metrics</span>
                    </button>

                    <button type="button" onclick="setQuery('Show top performing students')" 
                            class="text-left p-3.5 rounded-xl bg-white border border-slate-200 hover:border-blue-400 hover:bg-blue-50/40 transition duration-150 shadow-2xs group flex flex-col justify-between">
                        <div class="flex items-center justify-between w-full mb-1">
                            <span class="text-xs font-bold text-slate-900 group-hover:text-blue-600">Top Performing Students</span>
                            <i class="fas fa-arrow-right text-[10px] text-slate-300 group-hover:text-blue-600"></i>
                        </div>
                        <span class="text-[11px] text-slate-400 font-medium">Highest total exam scores</span>
                    </button>

                    <button type="button" onclick="setQuery('Which faculty manages the highest number of students?')" 
                            class="text-left p-3.5 rounded-xl bg-white border border-slate-200 hover:border-blue-400 hover:bg-blue-50/40 transition duration-150 shadow-2xs group flex flex-col justify-between">
                        <div class="flex items-center justify-between w-full mb-1">
                            <span class="text-xs font-bold text-slate-900 group-hover:text-blue-600">Faculty Performance</span>
                            <i class="fas fa-arrow-right text-[10px] text-slate-300 group-hover:text-blue-600"></i>
                        </div>
                        <span class="text-[11px] text-slate-400 font-medium">Advisor workload distribution</span>
                    </button>

                    <button type="button" onclick="setQuery('Students requiring immediate intervention')" 
                            class="text-left p-3.5 rounded-xl bg-white border border-slate-200 hover:border-blue-400 hover:bg-blue-50/40 transition duration-150 shadow-2xs group flex flex-col justify-between">
                        <div class="flex items-center justify-between w-full mb-1">
                            <span class="text-xs font-bold text-slate-900 group-hover:text-blue-600">Generate Academic Report</span>
                            <i class="fas fa-arrow-right text-[10px] text-slate-300 group-hover:text-blue-600"></i>
                        </div>
                        <span class="text-[11px] text-slate-400 font-medium">Intervention guidance summary</span>
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection

@section('scripts')
<script>
function setQuery(queryText) {
    const input = document.getElementById('natural_language_query');
    input.value = queryText;
    input.focus();
}

function animateProcessingTimeline(e) {
    const form = document.getElementById('queryForm');
    const submitBtn = document.getElementById('submitBtn');
    const timelineBox = document.getElementById('processingTimelineBox');
    const textarea = document.getElementById('natural_language_query');
    
    if (!textarea.value.trim()) return;

    e.preventDefault();
    submitBtn.disabled = true;
    timelineBox.classList.remove('hidden');

    const steps = [
        document.getElementById('pStep1'),
        document.getElementById('pStep2'),
        document.getElementById('pStep3'),
        document.getElementById('pStep4'),
        document.getElementById('pStep5')
    ];

    let stepDelay = 220;
    steps.forEach((stepEl, idx) => {
        setTimeout(() => {
            if (stepEl) {
                stepEl.classList.remove('opacity-30');
                stepEl.classList.add('font-bold', 'text-blue-800');
                if (idx === 4) {
                    stepEl.classList.remove('text-blue-800');
                    stepEl.classList.add('text-emerald-700');
                }
            }
        }, stepDelay * (idx + 1));
    });

    setTimeout(() => {
        form.submit();
    }, stepDelay * 6);
}

// Enter Key Handler (submit on Enter without Shift)
document.addEventListener('DOMContentLoaded', function() {
    const textarea = document.getElementById('natural_language_query');
    if (textarea) {
        textarea.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                document.getElementById('queryForm').requestSubmit();
            }
        });
    }
});
</script>
@endsection

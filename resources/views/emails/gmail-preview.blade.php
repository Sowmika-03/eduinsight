<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gmail - Urgent Academic Warning & Low Attendance Alert</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #f6f8fc; }
    </style>
</head>
<body class="bg-slate-100 text-slate-900 min-h-screen">
    <!-- Gmail Header Topbar -->
    <header class="bg-white border-b border-slate-200 px-4 py-2.5 flex items-center justify-between shadow-2xs">
        <div class="flex items-center gap-4">
            <i class="fas fa-bars text-slate-500 text-lg cursor-pointer"></i>
            <div class="flex items-center gap-2">
                <i class="fab fa-google text-red-500 text-xl"></i>
                <span class="font-bold text-slate-700 text-lg">Gmail</span>
            </div>
        </div>

        <div class="flex-1 max-w-2xl mx-8">
            <div class="relative">
                <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                <input type="text" value="from:wwwbvndksowmika@gmail.com EduInsight Notification" class="w-full pl-10 pr-4 py-2 bg-slate-100 rounded-full text-xs font-medium focus:bg-white focus:ring-2 focus:ring-blue-500 border border-slate-200">
            </div>
        </div>

        <div class="flex items-center gap-4">
            <span class="px-2.5 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-bold border border-blue-200">
                bvndksowmika03@gmail.com
            </span>
            <div class="w-8 h-8 rounded-full bg-purple-600 text-white font-bold flex items-center justify-center text-xs">
                S
            </div>
        </div>
    </header>

    <!-- Main Container -->
    <div class="flex max-w-7xl mx-auto mt-4 px-4 gap-4">
        <!-- Sidebar -->
        <div class="w-56 space-y-1 text-xs font-bold text-slate-600 shrink-0">
            <button class="w-full py-3 px-4 rounded-2xl bg-blue-100 text-blue-900 font-extrabold flex items-center gap-3 shadow-sm mb-4 hover:shadow transition">
                <i class="fas fa-pen text-sm"></i> Compose
            </button>
            <div class="flex items-center justify-between px-4 py-2 rounded-r-full bg-blue-50 text-blue-700 border-l-4 border-blue-600">
                <div class="flex items-center gap-3"><i class="fas fa-inbox"></i> Inbox</div>
                <span class="text-[10px] bg-blue-600 text-white font-extrabold px-1.5 py-0.5 rounded-full">1</span>
            </div>
            <div class="flex items-center gap-3 px-4 py-2 hover:bg-slate-200 rounded-r-full cursor-pointer"><i class="far fa-star"></i> Starred</div>
            <div class="flex items-center gap-3 px-4 py-2 hover:bg-slate-200 rounded-r-full cursor-pointer"><i class="far fa-clock"></i> Snoozed</div>
            <div class="flex items-center gap-3 px-4 py-2 hover:bg-slate-200 rounded-r-full cursor-pointer"><i class="far fa-paper-plane"></i> Sent</div>
        </div>

        <!-- Email Body Card -->
        <div class="flex-1 bg-white rounded-2xl border border-slate-200 p-6 shadow-md">
            <!-- Email Top Controls -->
            <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-4">
                <div class="flex items-center gap-3 text-slate-500">
                    <button class="hover:text-slate-800"><i class="fas fa-arrow-left"></i></button>
                    <button class="hover:text-slate-800"><i class="fas fa-archive"></i></button>
                    <button class="hover:text-slate-800"><i class="fas fa-exclamation-triangle"></i></button>
                    <button class="hover:text-slate-800"><i class="fas fa-trash"></i></button>
                </div>
                <span class="text-xs text-slate-400 font-medium">1 of 124</span>
            </div>

            <!-- Email Subject -->
            <div class="flex items-start justify-between mb-6">
                <div>
                    <h1 class="text-xl font-extrabold text-slate-900 tracking-tight flex items-center gap-2">
                        <span class="px-2 py-0.5 rounded-md bg-red-100 text-red-700 text-xs font-black uppercase">Urgent Alert</span>
                        [EduInsight] Attendance & Risk Warning: Computer Science Engineering (CS201)
                    </h1>
                    <div class="flex items-center gap-2 mt-2">
                        <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-600 text-[10px] font-bold">Inbox</span>
                        <span class="text-xs text-slate-400">July 23, 2026, 01:30 AM (1 hour ago)</span>
                    </div>
                </div>
                <div class="flex items-center gap-2 text-slate-400">
                    <i class="far fa-star cursor-pointer hover:text-amber-400"></i>
                    <i class="fas fa-reply cursor-pointer hover:text-slate-600"></i>
                </div>
            </div>

            <!-- Sender Info Header -->
            <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-200 mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-blue-600 text-white font-black flex items-center justify-center text-sm shadow-xs">
                        EI
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="font-extrabold text-slate-900 text-xs">EduInsight System &bull; Prof. K. Srimannarayana</span>
                            <span class="text-[10px] text-slate-400">&lt;wwwbvndksowmika@gmail.com&gt;</span>
                        </div>
                        <p class="text-[11px] text-slate-500 font-medium">to: <span class="font-semibold text-slate-700">bvndksowmika03+24cse001@gmail.com</span></p>
                    </div>
                </div>
                <span class="text-[10px] font-bold bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded-full flex items-center gap-1">
                    <i class="fas fa-lock text-[9px]"></i> Signed by gmail.com
                </span>
            </div>

            <!-- RENDERED EMAIL CONTENT HTML (as received in Gmail) -->
            <div class="p-6 rounded-2xl border border-blue-100 bg-white shadow-xs" style="max-width: 680px; margin: 0 auto; font-family: Arial, sans-serif;">
                <div style="text-align: center; border-bottom: 2px solid #2563eb; padding-bottom: 15px; margin-bottom: 20px;">
                    <h2 style="color: #1e3a8a; margin: 0; font-size: 22px; font-weight: 800;">🎓 EduInsight Academic Portal</h2>
                    <p style="color: #64748b; margin: 5px 0 0 0; font-size: 12px; font-weight: 600; text-transform: uppercase;">Official System Email Notification</p>
                </div>

                <div style="background-color: #eff6ff; border-left: 4px solid #2563eb; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                    <p style="margin: 0; font-size: 14px; font-weight: 700; color: #1e40af;">
                        Dear Student / Parent,
                    </p>
                    <p style="margin: 8px 0 0 0; font-size: 13px; color: #1e293b; line-height: 1.6;">
                        This is an automated notification regarding course attendance and performance risk. Your current attendance in <strong>CS201 Database Systems</strong> has fallen below the mandatory <strong>75.0% threshold</strong> (Current: 58.5%).
                    </p>
                </div>

                <div style="background-color: #fffbebf5; border: 1px solid #fef3c7; padding: 15px; border-radius: 12px; margin-bottom: 20px;">
                    <h4 style="margin: 0 0 8px 0; color: #92400e; font-size: 13px; font-weight: 800;">⚠️ Recommended Action Plan:</h4>
                    <ul style="margin: 0; padding-left: 20px; color: #78350f; font-size: 12px; line-height: 1.7;">
                        <li>Attend all upcoming lectures and practical lab sessions without fail.</li>
                        <li>Schedule an academic advisory session with your department counselor.</li>
                        <li>Submit pending internal assessments to satisfy minimum grade criteria.</li>
                    </ul>
                </div>

                <div style="text-align: center; margin-top: 25px; margin-bottom: 25px;">
                    <a href="http://127.0.0.1:8000/student/dashboard" style="background: linear-gradient(to right, #1d4ed8, #2563eb); color: #ffffff; padding: 12px 28px; border-radius: 10px; font-weight: bold; font-size: 13px; text-decoration: none; display: inline-block;">
                        Open Student Portal Dashboard &rarr;
                    </a>
                </div>

                <div style="border-top: 1px solid #e2e8f0; pt: 15px; margin-top: 20px; font-size: 11px; color: #94a3b8; text-align: center;">
                    <p style="margin: 0;">Sent via EduInsight SMTP Delivery Engine &bull; Ref Log #1042</p>
                    <p style="margin: 4px 0 0 0;">&copy; {{ date('Y') }} EduInsight Platform. Confidential Academic Notice.</p>
                </div>
            </div>

            <!-- Email Footer Actions -->
            <div class="mt-8 pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500 font-semibold">
                <div class="flex items-center gap-3">
                    <button class="px-3 py-1.5 rounded-xl border border-slate-200 hover:bg-slate-50 transition flex items-center gap-2"><i class="fas fa-reply text-slate-400"></i> Reply</button>
                    <button class="px-3 py-1.5 rounded-xl border border-slate-200 hover:bg-slate-50 transition flex items-center gap-2"><i class="fas fa-share text-slate-400"></i> Forward</button>
                </div>
                <span>Gmail Delivery Status: <strong class="text-emerald-600 font-extrabold">Delivered to Inbox</strong></span>
            </div>
        </div>
    </div>
</body>
</html>

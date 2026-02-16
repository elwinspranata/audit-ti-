<x-auditor-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f3f4f6; /* gray-100 */
        }
        .dark body {
            background-color: #111827; /* gray-900 */
        }

        .section-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-bottom: 2rem;
        }
        .dark .section-card {
            background: #1f2937;
            border-color: #374151;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
        }
        .dark .section-title { color: #f9fafb; }

        .data-label {
            font-size: 0.75rem;
            font-weight: 700;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.25rem;
            display: block;
        }
        .dark .data-label { color: #9ca3af; }

        .data-value {
            font-size: 1rem;
            color: #111827;
            font-weight: 500;
        }
        .dark .data-value { color: #f3f4f6; }
    </style>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <a href="{{ route('auditor.dashboard') }}" class="inline-flex items-center text-sm font-semibold text-blue-600 dark:text-blue-400 hover:text-blue-700 transition-all mb-4 group">
                        <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali ke Dashboard
                    </a>
                    <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white">Audit Report Details</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">Reviewing results for {{ $report->assessment->name ?? 'Assessment Project' }}</p>
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ route('auditor.report.pdf', $report) }}" class="px-6 py-2.5 bg-gray-900 text-white dark:bg-white dark:text-gray-900 rounded-lg font-bold text-sm shadow-md hover:opacity-90 transition-all flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Export PDF
                    </a>
                    @if($report->status === 'draft')
                        <a href="{{ route('auditor.report.edit', $report) }}" class="px-6 py-2.5 bg-indigo-100 text-indigo-700 border border-indigo-200 rounded-lg font-bold text-sm hover:bg-indigo-200 transition-all">
                            Edit Report
                        </a>
                        <form action="{{ route('auditor.report.finalize', $report) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menyelesaikan laporan ini? Laporan yang sudah final tidak dapat diedit lagi.')">
                            @csrf
                            <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white rounded-lg font-bold text-sm shadow-md hover:bg-blue-700 transition-all flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                SET FINAL REPORT
                            </button>
                        </form>
                    @else
                        <span class="px-6 py-2.5 bg-emerald-100 text-emerald-700 rounded-lg font-black text-xs uppercase tracking-widest border border-emerald-200">
                            REPORT FINALIZED
                        </span>
                    @endif
                </div>
            </div>

            @php
                $itProcessFocals = collect($report->it_process_focal_points ?? []);
                $pointsByLevel = [
                    5 => $itProcessFocals->where('rating', 5)->count(),
                    4 => $itProcessFocals->where('rating', 4)->count(),
                    3 => $itProcessFocals->where('rating', 3)->count(),
                    2 => $itProcessFocals->where('rating', 2)->count(),
                    1 => $itProcessFocals->where('rating', 1)->count(),
                ];
            @endphp

            {{-- ============ PAGE 1: COVER & CONTACTS ============ --}}
            <div class="mb-10 flex items-center gap-4">
                <div class="h-px bg-gray-200 dark:bg-gray-800 flex-grow"></div>
                <span class="px-4 py-1.5 bg-gray-900 text-white text-[10px] font-black uppercase tracking-[0.3em] rounded-full">Halaman 1: Cover & Kontak</span>
                <div class="h-px bg-gray-200 dark:bg-gray-800 flex-grow"></div>
            </div>

            <div class="section-card">
                <h2 class="section-title">
                    <svg class="w-6 h-6 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Cover Information
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="md:col-span-2">
                        <label class="data-label">Report Title</label>
                        <div class="text-2xl font-bold dark:text-white">{{ $report->report_title }}</div>
                    </div>
                    <div>
                        <label class="data-label">Company Name</label>
                        <div class="data-value">{{ $report->company_name }}</div>
                    </div>
                    <div>
                        <label class="data-label">Sign-off Authority</label>
                        <div class="data-value">{{ $report->sign_off_authority }}</div>
                    </div>
                    <div class="md:col-span-2">
                        <label class="data-label">Address / Department</label>
                        <div class="data-value">{{ $report->company_address }}</div>
                    </div>
                </div>
            </div>

            <div class="section-card">
                <h2 class="section-title">
                    <svg class="w-6 h-6 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Internal Audit Contacts
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="p-4 bg-gray-50 dark:bg-gray-800/50 rounded-xl">
                        <label class="data-label">Audit Director</label>
                        <div class="font-bold dark:text-white">{{ $report->audit_director }}</div>
                        <div class="text-sm text-gray-500">{{ $report->audit_director_phone }}</div>
                    </div>
                    <div class="p-4 bg-gray-50 dark:bg-gray-800/50 rounded-xl">
                        <label class="data-label">Audit Manager</label>
                        <div class="font-bold dark:text-white">{{ $report->audit_manager }}</div>
                        <div class="text-sm text-gray-500">{{ $report->audit_manager_phone }}</div>
                    </div>
                    <div class="p-4 bg-gray-50 dark:bg-gray-800/50 rounded-xl">
                        <label class="data-label">Lead Auditor</label>
                        <div class="font-bold dark:text-white">{{ $report->lead_auditor_name }}</div>
                        <div class="text-sm text-gray-500">{{ $report->lead_auditor_phone }}</div>
                    </div>
                </div>
            </div>

            {{-- ============ PAGE 2: EXECUTIVE SUMMARY ============ --}}
            <div class="mb-10 mt-16 flex items-center gap-4">
                <div class="h-px bg-gray-200 dark:bg-gray-800 flex-grow"></div>
                <span class="px-4 py-1.5 bg-indigo-600 text-white text-[10px] font-black uppercase tracking-[0.3em] rounded-full">Halaman 2: Executive Summary</span>
                <div class="h-px bg-gray-200 dark:bg-gray-800 flex-grow"></div>
            </div>

            <div class="section-card">
                <h2 class="section-title">
                    <svg class="w-6 h-6 mr-3 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Assessment Summary
                </h2>
                <div class="space-y-6">
                    <div>
                        <label class="data-label">Executive Summary</label>
                        <div class="data-value whitespace-pre-wrap">{{ $report->executive_summary }}</div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="data-label">Background</label>
                            <div class="data-value text-sm whitespace-pre-wrap">{{ $report->background }}</div>
                        </div>
                        <div>
                            <label class="data-label">Scope</label>
                            <div class="data-value text-sm whitespace-pre-wrap">{{ $report->scope }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section-card">
                <h2 class="section-title">
                    <svg class="w-6 h-6 mr-3 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                    Officer Response
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-6">
                    <div>
                        <label class="data-label">Name & Title</label>
                        <div class="data-value">{{ $report->officer_name }} - {{ $report->officer_title }}</div>
                    </div>
                    <div>
                        <label class="data-label">Response Date</label>
                        <div class="data-value">{{ $report->officer_response_date ? \Carbon\Carbon::parse($report->officer_response_date)->format('d F Y') : '-' }}</div>
                    </div>
                </div>
                <div>
                    <label class="data-label">Response Text</label>
                    <div class="p-4 bg-gray-50 dark:bg-gray-800/50 rounded-xl border border-gray-100 dark:border-gray-700 italic">
                        "{{ $report->officer_response }}"
                    </div>
                </div>
            </div>

            {{-- ============ PAGE 3: EVALUATION & FOCAL POINTS ============ --}}
            <div class="mb-10 mt-16 flex items-center gap-4">
                <div class="h-px bg-gray-200 dark:bg-gray-800 flex-grow"></div>
                <span class="px-4 py-1.5 bg-blue-600 text-white text-[10px] font-black uppercase tracking-[0.3em] rounded-full">Halaman 3: Evaluation & Focal Points</span>
                <div class="h-px bg-gray-200 dark:bg-gray-800 flex-grow"></div>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
                <div class="section-card mb-0">
                    <div class="bg-black py-2 px-6 -mx-8 -mt-8 mb-6">
                        <h3 class="text-white text-[10px] font-black uppercase tracking-widest text-center">Evaluation Distribution</h3>
                    </div>
                    <div class="overflow-x-auto border border-gray-100 dark:border-gray-700 rounded-xl">
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="bg-gray-50 dark:bg-gray-800">
                                    @foreach([5, 4, 3, 2, 1] as $lvl)
                                    <th class="border border-gray-100 dark:border-gray-700 py-2 px-4 text-[10px] font-black italic text-gray-500 dark:text-gray-400">Level {{ $lvl }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach([5, 4, 3, 2, 1] as $lvl)
                                    @php $count = $pointsByLevel[$lvl] ?? 0; @endphp
                                    <td class="border border-gray-100 dark:border-gray-700 py-3 px-4 text-center font-black text-xl text-blue-600 dark:text-blue-400">{{ $count }}</td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="section-card mb-0">
                    <h2 class="section-title">
                        <svg class="w-6 h-6 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                        IT Process Rating Summary
                    </h2>
                    <div class="overflow-hidden rounded-xl border border-gray-100 dark:border-gray-700">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th class="px-4 py-2 text-left text-[10px] font-black text-gray-500 dark:text-gray-400 uppercase">IT Process</th>
                                    <th class="px-4 py-2 text-center text-[10px] font-black text-gray-500 dark:text-gray-400 uppercase w-24">Rating</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-100 dark:divide-gray-800">
                                @foreach($itProcessFocals as $focal)
                                    <tr>
                                        <td class="px-4 py-3 text-[11px] font-bold text-gray-700 dark:text-gray-300">{{ $focal['process_name'] }}</td>
                                        <td class="px-4 py-3 text-center">
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 text-[11px] font-black border border-blue-100 dark:border-blue-800">
                                                {{ $focal['rating'] }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <div class="section-card">
                <h2 class="section-title">
                    <svg class="w-6 h-6 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                    IT Process Focal Points Analysis
                </h2>
                <div class="space-y-6">
                    @forelse($itProcessFocals as $index => $focal)
                        <div class="p-6 bg-gray-50 dark:bg-gray-800/50 rounded-xl border border-gray-100 dark:border-gray-700">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex gap-4">
                                    <div class="w-10 h-10 bg-blue-600 text-white rounded-lg flex items-center justify-center font-bold">
                                        {{ $index + 1 }}
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-lg dark:text-white">{{ $focal['process_name'] }}</h4>
                                        <p class="text-xs text-blue-600 font-bold uppercase tracking-widest">Rating: Level {{ $focal['rating'] }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div>
                                    <label class="data-label">Justification</label>
                                    <ul class="list-disc list-inside space-y-1">
                                        @foreach($focal['justification_points'] ?? [] as $point)
                                            <li class="text-sm dark:text-gray-300">{{ $point }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div>
                                    <label class="data-label">Indicators / Metrics</label>
                                    <ul class="list-disc list-inside space-y-1">
                                        @foreach($focal['indicators'] ?? [] as $indicator)
                                            <li class="text-sm dark:text-gray-300">{{ $indicator }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 py-10 italic">No focal points analyzed.</p>
                    @endforelse
                </div>
            </div>

            {{-- Footer --}}
            <div class="mt-12 text-center text-gray-500 text-xs py-8 border-t border-gray-200 dark:border-gray-800">
                <p>&copy; {{ date('Y') }} {{ $report->company_name }}. Internal Audit Management System.</p>
            </div>
        </div>
    </div>
</x-auditor-layout>

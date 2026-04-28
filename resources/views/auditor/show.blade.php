<x-auditor-layout>
    <div class="py-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            {{-- Back Button --}}
            <div class="mb-6">
                <a href="{{ route('auditor.dashboard') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Dashboard
                </a>
            </div>

            {{-- Flash Messages --}}
            @if (session('success'))
                <div class="p-4 mb-6 text-green-800 bg-green-100 border-l-4 border-green-500 rounded-lg dark:bg-green-900/30 dark:text-green-400">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="p-4 mb-6 text-red-800 bg-red-100 border-l-4 border-red-500 rounded-lg dark:bg-red-900/30 dark:text-red-400">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Assessment Info --}}
            <div class="p-6 mb-6 bg-white rounded-lg shadow dark:bg-gray-800">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $assessment->name ?? 'Assessment #' . $assessment->id }}</h1>
                        <p class="text-gray-600 dark:text-gray-400">{{ $assessment->user->name }} - {{ $assessment->user->email }}</p>
                    </div>
                    @if($assessment->status === 'completed')
                        @php
                            $canComplete = $verificationStats['pending'] === 0 && $verificationStats['needs_revision'] === 0;
                        @endphp
                        <div class="flex flex-col items-end gap-2">
                            <form action="{{ route('auditor.complete', $assessment) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                    class="px-6 py-2 text-white bg-green-600 rounded-lg {{ $canComplete ? 'hover:bg-green-700' : 'opacity-50 cursor-not-allowed bg-gray-500' }}"
                                    {{ !$canComplete ? 'disabled' : '' }}
                                    onclick="return confirm('Yakin ingin menandai assessment ini sebagai terverifikasi?')">
                                    <svg class="inline w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Selesaikan Verifikasi
                                </button>
                            </form>
                            @if(!$canComplete)
                                <p class="text-[10px] text-red-500 font-bold uppercase animate-pulse">
                                    {{ $verificationStats['needs_revision'] > 0 ? 'Tunggu User Memperbaiki Revisi' : 'Selesaikan Semua Verifikasi Terlebih Dahulu' }}
                                </p>
                            @endif
                        </div>
                    @elseif($assessment->status === 'verified')
                        <div class="flex gap-3">
                            @if($assessment->auditReport)
                                <a href="{{ route('auditor.report.show', $assessment->auditReport) }}" 
                                   class="px-6 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 flex items-center transition-all shadow-md shadow-blue-500/20">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Lihat Laporan
                                </a>
                                <a href="{{ route('auditor.report.pdf', $assessment->auditReport) }}" 
                                   class="p-2 text-red-600 bg-red-50 hover:bg-red-100 rounded-lg dark:bg-red-900/20 dark:text-red-400" title="Download PDF">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </a>
                                <a href="{{ route('auditor.report.excel', $assessment->auditReport) }}" 
                                   class="p-2 text-emerald-600 bg-emerald-50 hover:bg-emerald-100 rounded-lg dark:bg-emerald-900/20 dark:text-emerald-400" title="Download Excel">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 014-4h4m-4-4l4 4-4 4m-12-4h18"></path>
                                    </svg>
                                </a>
                            @else
                                <a href="{{ route('auditor.report.create', $assessment) }}" 
                                   class="px-6 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 flex items-center transition-all shadow-md shadow-blue-500/20">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Buat Laporan Audit
                                </a>
                            @endif
                        </div>
                    @endif
                </div>

                {{-- Verification Stats --}}
                <div class="grid grid-cols-2 gap-4 mt-4 md:grid-cols-4">
                    <div class="p-4 text-center bg-gray-100 rounded-lg dark:bg-gray-700">
                        <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $verificationStats['total'] }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total Jawaban</p>
                    </div>
                    <div class="p-4 text-center bg-green-100 rounded-lg dark:bg-green-900/30">
                        <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $verificationStats['verified'] }}</p>
                        <p class="text-sm text-green-600 dark:text-green-400">Terverifikasi</p>
                    </div>
                    <div class="p-4 text-center bg-yellow-100 rounded-lg dark:bg-yellow-900/30">
                        <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ $verificationStats['pending'] }}</p>
                        <p class="text-sm text-yellow-600 dark:text-yellow-400">Menunggu</p>
                    </div>
                    <div class="p-4 text-center bg-red-100 rounded-lg dark:bg-red-900/30">
                        <p class="text-2xl font-bold text-red-600 dark:text-red-400">{{ $verificationStats['needs_revision'] }}</p>
                        <p class="text-sm text-red-600 dark:text-red-400">Perlu Revisi</p>
                    </div>
                </div>
            </div>

            {{-- Jawaban per CobitItem --}}
            @foreach($groupedJawabans as $cobitId => $cobitData)
                <div class="p-6 mb-6 bg-white rounded-lg shadow dark:bg-gray-800">
                    <h2 class="mb-4 text-lg font-semibold text-gray-800 dark:text-white">
                        {{ $cobitData['cobitItem']->nama_item }}
                    </h2>

                    @foreach($cobitData['kategoris'] as $kategoriId => $kategoriData)
                        <div class="mb-6">
                            <h3 class="mb-3 font-medium text-gray-700 dark:text-gray-300">
                                {{ $kategoriData['kategori']->nama }}
                            </h3>

                            @foreach($kategoriData['levels'] as $levelId => $levelData)
                                @if($levelData['jawabans']->isNotEmpty())
                                    <div class="p-4 mb-4 border rounded-lg dark:border-gray-700">
                                        <h4 class="mb-3 font-medium text-blue-600 dark:text-blue-400">
                                            {{ $levelData['level']->nama_level }}
                                        </h4>

                                        <div class="space-y-4">
                                        <div class="overflow-hidden border rounded-lg border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50">
                                            <table class="w-full text-left border-collapse">
                                                <thead>
                                                    <tr class="bg-gray-200/50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
                                                        <th class="px-4 py-3 text-[11px] font-bold text-gray-500 dark:text-gray-400 uppercase w-12 text-center">No</th>
                                                        <th class="px-4 py-3 text-[11px] font-bold text-gray-500 dark:text-gray-400 uppercase w-24">PG</th>
                                                        <th class="px-4 py-3 text-[11px] font-bold text-gray-500 dark:text-gray-400 uppercase">Aktivitas Tata Kelola</th>
                                                        <th class="px-4 py-3 text-[11px] font-bold text-gray-500 dark:text-gray-400 uppercase w-64 text-center">Temuan (N, P, L, F)</th>
                                                        <th class="px-4 py-3 text-[11px] font-bold text-gray-500 dark:text-gray-400 uppercase">Bukti & Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                                    @foreach($levelData['jawabans'] as $index => $jawaban)
                                                        <tr class="hover:bg-gray-200/30 dark:hover:bg-gray-800/80 transition-colors group">
                                                            <td class="px-4 py-4 text-sm text-gray-500 dark:text-gray-400 text-center align-top">{{ $index + 1 }}</td>
                                                            <td class="px-4 py-4 text-sm font-medium text-gray-700 dark:text-gray-200 align-top">
                                                                {{ explode(' - ', $cobitData['cobitItem']->nama_item)[0] }}.{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                                            </td>
                                                            <td class="px-4 py-4 text-sm text-gray-600 dark:text-gray-300 align-top leading-relaxed">
                                                                {{ $jawaban->quisioner->pertanyaan ?? 'N/A' }}
                                                            </td>
                                                            <td class="px-4 py-4 align-top">
                                                                <div class="flex flex-col items-center space-y-2">
                                                                    {{-- User's Original Choice --}}
                                                                    <div class="text-[10px] font-bold text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-800 px-2 py-0.5 rounded border border-gray-200 dark:border-gray-700">
                                                                        USER: <span class="text-blue-600 dark:text-blue-400 font-black">{{ $jawaban->jawaban ?? '-' }}</span>
                                                                    </div>
                                                                    
                                                                    <div class="flex justify-center items-end space-x-3">
                                                                        @foreach(['N', 'P', 'L', 'F'] as $l)
                                                                            <div class="flex flex-col items-center space-y-1">
                                                                                <span class="text-[9px] font-black text-gray-500 dark:text-gray-400">{{ $l }}</span>
                                                                                <input type="radio" 
                                                                                    name="jawaban_{{ $jawaban->id }}" 
                                                                                    value="{{ $l }}" 
                                                                                    form="verify-form-{{ $jawaban->id }}"
                                                                                    {{ $jawaban->jawaban === $l ? 'checked' : '' }}
                                                                                    class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 cursor-pointer">
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                                
                                                                {{-- User Original Evidence Link --}}
                                                                @if($jawaban->hasEvidence())
                                                                    <div class="mt-3 text-center">
                                                                        <a href="{{ route('auditor.evidence', $jawaban) }}" target="_blank" class="inline-flex items-center px-2 py-1 text-[10px] bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 rounded hover:bg-gray-200 dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-700 transition-colors">
                                                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                                            Lihat Bukti User
                                                                        </a>
                                                                    </div>
                                                                @else
                                                                    <div class="mt-3 text-center text-[10px] text-gray-400 italic">
                                                                        Tanpa Bukti User
                                                                    </div>
                                                                @endif
                                                            </td>
                                                            <td class="px-4 py-4 align-top">
                                                                {{-- Action & Evidence Form --}}
                                                                @if($jawaban->verification_status === 'pending')
                                                                    <form action="{{ route('auditor.verify', $jawaban) }}" method="POST" id="verify-form-{{ $jawaban->id }}" class="space-y-3">
                                                                        @csrf
                                                                        
                                                                        {{-- Evidence Editable Link --}}
                                                                        <div class="group/input">
                                                                            <div class="flex items-center space-x-2 mb-1">
                                                                                <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.826a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                                                                <span class="text-[10px] text-gray-400 font-bold">Instruksi/Bukti Auditor</span>
                                                                            </div>
                                                                            <textarea name="auditor_evidence" 
                                                                                rows="2"
                                                                                class="w-full px-2 py-1 text-[11px] border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 rounded focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all placeholder:text-gray-500 text-gray-700 dark:text-gray-300"
                                                                                placeholder="Link atau petunjuk revisi...">{{ $jawaban->auditor_evidence }}</textarea>
                                                                        </div>
                                                                        
                                                                        <div class="flex gap-1 pt-1">
                                                                            <button type="submit" name="verification_status" value="verified"
                                                                                class="flex-1 px-2 py-1.5 text-[10px] font-bold text-white bg-green-600 rounded hover:bg-green-700 transition-colors uppercase tracking-wider text-center">
                                                                                Verifikasi
                                                                            </button>
                                                                            <button type="submit" name="verification_status" value="needs_revision"
                                                                                class="flex-1 px-2 py-1.5 text-[10px] font-bold text-white bg-red-600 rounded hover:bg-red-700 transition-colors uppercase tracking-wider text-center">
                                                                                Revisi
                                                                            </button>
                                                                        </div>
                                                                    </form>
                                                                @else
                                                                    <div class="flex flex-col items-center space-y-2">
                                                                        @if($jawaban->verification_status === 'verified')
                                                                            <span class="px-2 py-1 text-[10px] font-bold text-green-700 bg-green-100 dark:bg-green-900/30 dark:text-green-400 rounded uppercase tracking-wider">✓ Terverifikasi</span>
                                                                        @else
                                                                            <span class="px-2 py-1 text-[10px] font-bold text-red-700 bg-red-100 dark:bg-red-900/30 dark:text-red-400 rounded uppercase tracking-wider">✗ Perlu Revisi</span>
                                                                        @endif
                                                                        
                                                                        @if($jawaban->auditor_evidence)
                                                                            <div class="w-full text-center px-2">
                                                                                @if(filter_var($jawaban->auditor_evidence, FILTER_VALIDATE_URL))
                                                                                    <a href="{{ $jawaban->auditor_evidence }}" target="_blank" class="text-[10px] text-blue-500 hover:text-blue-600 hover:underline break-all">
                                                                                        {{ $jawaban->auditor_evidence }}
                                                                                    </a>
                                                                                @else
                                                                                    <p class="text-[10px] text-slate-500 dark:text-slate-400 italic line-clamp-3">
                                                                                        {{ $jawaban->auditor_evidence }}
                                                                                    </p>
                                                                                @endif
                                                                            </div>
                                                                        @endif
                                                                        
                                                                        <button type="button" onclick="document.getElementById('re-verify-{{ $jawaban->id }}').classList.toggle('hidden')" class="text-[9px] text-blue-500 hover:underline">Ubah Status</button>
                                                                        
                                                                        <form action="{{ route('auditor.verify', $jawaban) }}" method="POST" id="re-verify-{{ $jawaban->id }}" class="hidden space-y-2 mt-2 pt-2 border-t border-gray-200 dark:border-gray-700 w-full">
                                                                            @csrf
                                                                            <textarea name="auditor_evidence" rows="1" class="w-full px-2 py-1 text-[10px] border rounded bg-transparent">{{ $jawaban->auditor_evidence }}</textarea>
                                                                            <div class="flex gap-1">
                                                                                <button type="submit" name="verification_status" value="verified" class="flex-1 py-1 text-[9px] bg-green-600 text-white rounded">Verifikasi</button>
                                                                                <button type="submit" name="verification_status" value="needs_revision" class="flex-1 py-1 text-[9px] bg-red-600 text-white rounded">Revisi</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
</x-auditor-layout>

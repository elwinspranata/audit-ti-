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
            <div class="p-6 mb-6 bg-white rounded-lg shadow dark:bg-slate-800">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $assessment->name ?? 'Assessment #' . $assessment->id }}</h1>
                        <p class="text-gray-600 dark:text-gray-400">{{ $assessment->user->name }} - {{ $assessment->user->email }}</p>
                    </div>
                    @if($assessment->status === 'completed')
                        <form action="{{ route('auditor.complete', $assessment) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-6 py-2 text-white bg-green-600 rounded-lg hover:bg-green-700"
                                onclick="return confirm('Yakin ingin menandai assessment ini sebagai terverifikasi?')">
                                <svg class="inline w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Selesaikan Verifikasi
                            </button>
                        </form>
                    @endif
                </div>

                {{-- Verification Stats --}}
                <div class="grid grid-cols-2 gap-4 mt-4 md:grid-cols-4">
                    <div class="p-4 text-center bg-gray-100 rounded-lg dark:bg-slate-700">
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
                <div class="p-6 mb-6 bg-white rounded-lg shadow dark:bg-slate-800">
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
                                    <div class="p-4 mb-4 border rounded-lg dark:border-slate-700">
                                        <h4 class="mb-3 font-medium text-blue-600 dark:text-blue-400">
                                            {{ $levelData['level']->nama_level }}
                                        </h4>

                                        <div class="space-y-4">
                                            @foreach($levelData['jawabans'] as $jawaban)
                                                <div class="p-4 rounded-lg {{ 
                                                    $jawaban->verification_status === 'verified' ? 'bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800' : 
                                                    ($jawaban->verification_status === 'needs_revision' ? 'bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800' : 
                                                    'bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600') 
                                                }}">
                                                    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                                                        <div class="flex-1">
                                                            <p class="mb-2 text-sm text-gray-600 dark:text-gray-400">
                                                                <strong>Pertanyaan:</strong> {{ $jawaban->quisioner->pertanyaan ?? 'N/A' }}
                                                            </p>
                                                            <p class="mb-2">
                                                                <strong>Jawaban:</strong> 
                                                                <span class="inline-flex items-center px-2 py-1 text-sm font-medium {{ $jawaban->jawaban === 'F' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }} rounded">
                                                                    {{ $jawaban->jawaban }}
                                                                </span>
                                                            </p>
                                                            
                                                            {{-- Evidence --}}
                                                            @if($jawaban->hasEvidence())
                                                                <div class="p-2 mt-2 bg-blue-50 rounded dark:bg-blue-900/20">
                                                                    <p class="text-sm text-blue-600 dark:text-blue-400">
                                                                        <strong>Bukti:</strong>
                                                                        @if($jawaban->evidence_type === 'link')
                                                                            <a href="{{ $jawaban->evidence_path }}" target="_blank" class="underline">{{ $jawaban->evidence_path }}</a>
                                                                        @else
                                                                            <a href="{{ route('auditor.evidence', $jawaban) }}" class="underline">{{ $jawaban->evidence_original_name }}</a>
                                                                        @endif
                                                                    </p>
                                                                </div>
                                                            @endif

                                                            {{-- Previous auditor notes --}}
                                                            @if($jawaban->auditor_notes)
                                                                <div class="p-2 mt-2 bg-gray-100 rounded dark:bg-slate-600">
                                                                    <p class="text-sm"><strong>Catatan Auditor:</strong> {{ $jawaban->auditor_notes }}</p>
                                                                </div>
                                                            @endif
                                                        </div>

                                                        {{-- Verification Form --}}
                                                        <div class="flex-shrink-0 w-full lg:w-64">
                                                            @if($jawaban->verification_status === 'pending')
                                                                <form action="{{ route('auditor.verify', $jawaban) }}" method="POST">
                                                                    @csrf
                                                                    <textarea name="auditor_notes" rows="2" 
                                                                        class="w-full px-3 py-2 mb-2 text-sm border rounded dark:bg-slate-700 dark:border-slate-600 dark:text-white"
                                                                        placeholder="Catatan (opsional)"></textarea>
                                                                    <div class="flex gap-2">
                                                                        <button type="submit" name="verification_status" value="verified"
                                                                            class="flex-1 px-3 py-2 text-sm text-white bg-green-600 rounded hover:bg-green-700">
                                                                            ✓ Verifikasi
                                                                        </button>
                                                                        <button type="submit" name="verification_status" value="needs_revision"
                                                                            class="flex-1 px-3 py-2 text-sm text-white bg-red-600 rounded hover:bg-red-700">
                                                                            ✗ Revisi
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            @else
                                                                <div class="text-center">
                                                                    @if($jawaban->verification_status === 'verified')
                                                                        <span class="inline-flex items-center px-3 py-1 text-sm font-medium text-green-800 bg-green-100 rounded-full">
                                                                            ✓ Terverifikasi
                                                                        </span>
                                                                    @else
                                                                        <span class="inline-flex items-center px-3 py-1 text-sm font-medium text-red-800 bg-red-100 rounded-full">
                                                                            ✗ Perlu Revisi
                                                                        </span>
                                                                    @endif
                                                                    @if($jawaban->verifier)
                                                                        <p class="mt-1 text-xs text-gray-500">oleh {{ $jawaban->verifier->name }}</p>
                                                                    @endif
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
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

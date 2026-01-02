<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold leading-tight text-gray-700 dark:text-sky-300">
                {{ __('Jawab Kuesioner - Level: ') . ($level->nama_level ?? 'Belum Ditentukan') }}
            </h2>
            <div class="text-sm text-gray-500 dark:text-gray-400">
                <span id="progress-text">0 / {{ $quisioners->count() }} Pertanyaan</span>
            </div>
        </div>
    </x-slot>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px)
            }

            to {
                opacity: 1;
                transform: translateX(0)
            }
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.02);
            }
        }

        .animate-fadeIn {
            animation: fadeIn .5s ease-out forwards;
            opacity: 0;
        }

        .animate-slideIn {
            animation: slideIn .4s ease-out forwards;
            opacity: 0;
        }

        .animate-pulse-subtle {
            animation: pulse 2s infinite;
        }

        .animation-delay-100 {
            animation-delay: .1s
        }

        .animation-delay-200 {
            animation-delay: .2s
        }

        .animation-delay-300 {
            animation-delay: .3s
        }

        .animation-delay-400 {
            animation-delay: .4s
        }

        .animation-delay-500 {
            animation-delay: .5s
        }

        .custom-radio {
            appearance: none;
            -webkit-appearance: none;
            width: 1.5em;
            height: 1.5em;
            border-radius: 50%;
            border: 2px solid #e5e7eb;
            outline: none;
            transition: all .3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            cursor: pointer;
            background: white;
        }

        .dark .custom-radio {
            border-color: #475569;
            background: #334155;
        }

        .custom-radio:hover {
            border-color: #0ea5e9;
            box-shadow: 0 0 0 3px rgba(14, 165, 233, .1);
            transform: scale(1.05);
        }

        .custom-radio:checked {
            border-color: #0ea5e9;
            background: linear-gradient(135deg, #0ea5e9, #0284c7);
            box-shadow: 0 0 0 3px rgba(14, 165, 233, .2);
        }

        .custom-radio:checked::before {
            content: '';
            display: block;
            width: .75em;
            height: .75em;
            border-radius: 50%;
            background: white;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0);
            animation: radioCheck .2s ease-out forwards;
        }

        @keyframes radioCheck {
            to {
                transform: translate(-50%, -50%) scale(1);
            }
        }

        .custom-radio:focus {
            box-shadow: 0 0 0 3px rgba(14, 165, 233, .4);
        }

        .question-card {
            background: rgba(30, 41, 59, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            transition: all .3s ease;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .dark .question-card {
            background: rgba(30, 41, 59, 0.8);
            border-color: #475569;
            backdrop-filter: blur(10px);
        }

        .question-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .dark .question-card:hover {
            box-shadow: 0 8px 25px -5px rgba(0, 0, 0, 0.3);
        }

        .question-card.answered {
            border-color: #10b981;
            background: linear-gradient(135deg, #ecfdf5, #f0fdf4);
        }

        .dark .question-card.answered {
            border-color: #059669;
            background: linear-gradient(135deg, rgba(5, 150, 105, 0.1), rgba(16, 185, 129, 0.1));
        }

        .option-button {
            display: flex;
            align-items: center;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            border: 2px solid #e5e7eb;
            background: white;
            transition: all .3s ease;
            cursor: pointer;
            min-width: 120px;
            justify-content: center;
            font-weight: 500;
        }

        .dark .option-button {
            border-color: #475569;
            background: #334155;
        }

        .option-button:hover {
            border-color: #0ea5e9;
            background: #f0f9ff;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(14, 165, 233, 0.15);
        }

        .dark .option-button:hover {
            border-color: #0ea5e9;
            background: rgba(14, 165, 233, 0.1);
        }

        .option-button.selected {
            border-color: #0ea5e9;
            background: linear-gradient(135deg, #0ea5e9, #0284c7);
            color: white;
            transform: scale(1.02);
        }

        .progress-bar {
            height: 6px;
            background: #e5e7eb;
            border-radius: 3px;
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .dark .progress-bar {
            background: #475569;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #0ea5e9, #06b6d4);
            transition: width .5s ease;
            border-radius: 3px;
        }

        .submit-button {
            background: linear-gradient(135deg, #0ea5e9, #0284c7);
            border: none;
            color: white;
            padding: 1rem 2rem;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all .3s ease;
            box-shadow: 0 4px 15px rgba(14, 165, 233, 0.3);
        }

        .submit-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(14, 165, 233, 0.4);
        }

        .submit-button:disabled {
            background: #9ca3af;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .draft-button {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            border: none;
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all .3s ease;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
        }

        .draft-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(245, 158, 11, 0.4);
        }

        .draft-button:disabled {
            background: #9ca3af;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .draft-status {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            background: #fef3c7;
            color: #92400e;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .dark .draft-status {
            background: rgba(245, 158, 11, 0.2);
            color: #fbbf24;
        }

        .completion-indicator {
            /* Properti display akan diatur oleh JavaScript */
            align-items: center;
            padding: 0.5rem 1rem;
            background: #10b981;
            color: white;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
            margin-left: 1rem;
        }

        .option-descriptions {
            margin-top: 1rem;
            padding: 1rem;
            background: #f8fafc;
            border-radius: 8px;
            border-left: 4px solid #0ea5e9;
        }

        .dark .option-descriptions {
            background: rgba(30, 41, 59, 0.5);
        }
    </style>

    <div class="min-h-screen py-8 bg-slate-950 dark:bg-gray-900 bg-gradient-to-br from-slate-950 via-gray-900 to-slate-900">
        <div class="max-w-6xl px-4 mx-auto sm:px-6 lg:px-8">

            {{-- Breadcrumb Navigation --}}
            <div class="mb-8 animate-fadeIn">
                @include('audit.partials.breadcrumbs', [
                    'breadcrumbs' => [
                        ['title' => $cobitItem->nama_item, 'url' => route('audit.showCategories', $cobitItem->id)],
                        [
                            'title' => $kategori->nama,
                            'url' => route('audit.showLevels', [$cobitItem->id, $kategori->id]),
                        ],
                        ['title' => $level->nama_level],
                    ],
                ])
            </div>

            {{-- Progress Bar --}}
            <div class="mb-8 animate-fadeIn animation-delay-100">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Progress Kuesioner</span>
                    <span class="text-sm text-gray-500 dark:text-gray-400" id="progress-percentage">0%</span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" id="progress-fill" style="width: 0%"></div>
                </div>
            </div>

            {{-- Main Content --}}
            <div class="space-y-6 animate-fadeIn animation-delay-200">
                @if ($errors->any())
                    <div
                        class="p-4 mb-6 bg-red-100 border border-red-300 rounded-lg dark:bg-red-700/20 animate-slideIn">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <div class="font-semibold text-red-700 dark:text-red-300">Whoops! Ada yang salah.</div>
                        </div>
                        <ul class="mt-2 text-sm text-red-600 list-disc list-inside dark:text-red-400">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="quisionerForm" action="{{ route('jawaban.store', $level->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="user_confirmation" id="user_confirmation_input" value="tidak_setuju">

                    @forelse ($quisioners as $index => $quisioner)
                        @php $delayClass = 'animation-delay-' . (($index % 5) + 1) . '00'; @endphp
                        <div class="question-card animate-slideIn {{ $delayClass }}"
                            data-question-id="{{ $quisioner->id }}">
                            <div class="flex items-start justify-between mb-6">
                                <div class="flex-1">
                                    <div class="flex items-center mb-3">
                                        <span
                                            class="inline-flex items-center justify-center w-8 h-8 mr-3 text-sm font-bold text-white bg-blue-500 rounded-full">
                                            {{ $loop->iteration }}
                                        </span>
                                        <h3 class="text-lg font-semibold text-gray-800 dark:text-sky-200">
                                            {{ $quisioner->pertanyaan }}
                                            <span class="ml-1 text-red-500">*</span>
                                        </h3>
                                    </div>
                                </div>
                                <div class="hidden completion-indicator" id="indicator-{{ $quisioner->id }}">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    Terjawab
                                </div>
                            </div>



                            {{-- <div class="grid grid-cols-2 gap-4 sm:grid-cols-4"> --}}
                            <div class="flex flex-wrap items-center justify-content-center gap-x-6 gap-y-3 sm:gap-x-8">
                                {{-- Radio buttons for options --}}
                                @foreach (['N', 'P', 'L', 'F'] as $option)
                                    @php
                                        $isSelected = isset($draftAnswers[$quisioner->id]) && $draftAnswers[$quisioner->id] === $option;
                                    @endphp
                                    <label class="option-button {{ $isSelected ? 'selected' : '' }}" data-option="{{ $option }}">
                                        <input type="radio" name="jawaban[{{ $quisioner->id }}]"
                                            value="{{ $option }}" class="hidden" required
                                            {{ $isSelected ? 'checked' : '' }}>
                                        <span class="text-lg font-semibold">{{ $option }}</span>
                                    </label>
                                @endforeach
                            </div>

                            {{-- Option descriptions --}}
                            <div class="option-descriptions">
                                <div class="text-sm text-gray-600 dark:text-gray-300">
                                    <strong>Keterangan:</strong>
                                    <span class="font-medium">N</span> = Tidak Ada,
                                    <span class="font-medium">P</span> = Sebagian,
                                    <span class="font-medium">L</span> = Lengkap,
                                    <span class="font-medium">F</span> = Penuh
                                </div>
                            </div>
                        </div>
                    @empty
                        <div
                            class="p-12 text-center bg-white shadow-xl dark:bg-slate-800/70 dark:backdrop-blur-md rounded-xl">
                            <div class="w-16 h-16 mx-auto mb-4 text-gray-400">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-300">Tidak Ada Kuesioner
                            </h3>
                            <p class="text-gray-500 dark:text-slate-400">Tidak ada kuesioner untuk level ini.</p>
                        </div>
                    @endforelse

                    @if ($quisioners->isNotEmpty())
                        <div class="pt-8 mt-10 border-t dark:border-slate-700/50">
                            <div class="flex flex-col items-center gap-4 sm:flex-row sm:justify-between sm:space-y-0">
                                {{-- Status Keterisian & Draft Status --}}
                                <div class="text-sm text-gray-600 dark:text-gray-400">
                                    <span id="completion-status">Mohon lengkapi semua pertanyaan sebelum mengirim</span>
                                    <span id="draft-status" class="ml-2 draft-status hidden">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span id="draft-status-text">Draft tersimpan</span>
                                    </span>
                                </div>

                                {{-- Grup Tombol Aksi --}}
                                <div class="flex flex-wrap items-center justify-center gap-3 w-full sm:w-auto sm:justify-end">
                                    {{-- Tombol Kembali --}}
                                    <a href="{{ route('audit.showLevels', [$cobitItem->id, $kategori->id]) }}"
                                        class="inline-flex items-center justify-center px-5 py-3 text-sm font-semibold text-center text-gray-700 transition-all duration-200 bg-white border border-gray-300 shadow-sm rounded-xl dark:bg-slate-800 dark:border-slate-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700">
                                        <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                                        </svg>
                                        Kembali
                                    </a>

                                    {{-- Tombol Simpan Draft --}}
                                    <button type="button" id="save-draft-btn" class="draft-button">
                                        <span class="flex items-center justify-center">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                                            </svg>
                                            Simpan Draft
                                        </span>
                                    </button>

                                    {{-- Tombol Kirim Jawaban --}}
                                    <button type="submit" id="submit-btn" class="submit-button" disabled>
                                        <span class="flex items-center justify-center">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                            </svg>
                                            Kirim
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>




    {{-- Modal Konfirmasi --}}
    <div id="confirmationModal"
        class="fixed inset-0 z-50 flex items-center justify-center hidden transition-opacity duration-300 ease-in-out bg-slate-900/80 backdrop-blur-sm">
        <div
            class="relative w-full max-w-md p-6 mx-4 transition-all duration-300 ease-in-out transform bg-white shadow-2xl sm:p-8 dark:bg-gradient-to-br dark:from-slate-800 dark:to-blue-950/90 rounded-xl dark:border dark:border-sky-700/50">
            <button type="button" id="closeModalBtn"
                class="absolute p-1 text-gray-400 transition-colors rounded-full top-4 right-4 hover:bg-gray-200 dark:hover:bg-slate-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 dark:focus:ring-offset-slate-800">
                <span class="sr-only">Tutup modal</span>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
            <h3 class="mb-5 text-xl font-bold text-gray-800 dark:text-sky-300">Konfirmasi Penilaian</h3>
            <p class="mb-8 text-sm leading-relaxed text-gray-600 dark:text-gray-300">
                Berdasarkan penilaian yang dilakukan, apakah saudara setuju aktivitas tersebut diatas
                memiliki capability level? (Semua aktivitas harus bernilai F untuk capability level
                tertinggi).
            </p>
            <div class="flex flex-col justify-end space-y-3 sm:flex-row sm:space-y-0 sm:space-x-4">
                <button type="button" id="confirmNo"
                    class="w-full sm:w-auto px-5 py-2.5 text-sm font-medium text-gray-800 bg-gray-200 dark:text-gray-200 dark:bg-slate-600 hover:bg-gray-300 dark:hover:bg-slate-500 rounded-lg shadow-sm focus:outline-none transition-all duration-300">
                    Tidak Setuju
                </button>
                <button type="button" id="confirmYes"
                    class="w-full sm:w-auto px-5 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 rounded-lg shadow-lg focus:outline-none transition-all duration-300">
                    Setuju
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- KUMPULAN SEMUA ELEMEN ---
            const form = document.getElementById('quisionerForm');
            // Hentikan jika form tidak ada di halaman ini
            if (!form) {
                return;
            }

            const submitBtn = document.getElementById('submit-btn');
            const saveDraftBtn = document.getElementById('save-draft-btn');
            const draftStatus = document.getElementById('draft-status');
            const draftStatusText = document.getElementById('draft-status-text');
            const totalQuestions = {{ $quisioners->count() }};
            const levelId = {{ $level->id }};
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Elemen Progress
            const progressFill = document.getElementById('progress-fill');
            const progressText = document.getElementById('progress-text');
            const progressPercentage = document.getElementById('progress-percentage');
            const completionStatus = document.getElementById('completion-status');

            // Elemen untuk Modal
            const modal = document.getElementById('confirmationModal');
            const confirmYesButton = document.getElementById('confirmYes');
            const confirmNoButton = document.getElementById('confirmNo');
            const userConfirmationInput = document.getElementById('user_confirmation_input');
            const closeModalBtn = document.getElementById('closeModalBtn');

            let answeredQuestions = 0;

            // Jangan jalankan apapun jika tidak ada kuesioner
            if (totalQuestions === 0) {
                return;
            }

            // --- FUNGSI UNTUK MENYIMPAN DRAFT ---
            async function saveDraft() {
                const formData = new FormData(form);
                const jawaban = {};
                
                // Collect all answered questions
                document.querySelectorAll('input[type="radio"]:checked').forEach(radio => {
                    const name = radio.getAttribute('name');
                    const match = name.match(/jawaban\[(\d+)\]/);
                    if (match) {
                        jawaban[match[1]] = radio.value;
                    }
                });

                // Show loading state
                if (saveDraftBtn) {
                    saveDraftBtn.disabled = true;
                    saveDraftBtn.innerHTML = '<span class="flex items-center justify-center"><svg class="w-4 h-4 mr-2 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Menyimpan...</span>';
                }

                try {
                    const response = await fetch(`/audit/${levelId}/draft`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ jawaban: jawaban })
                    });

                    const data = await response.json();

                    if (data.success) {
                        // Show success status
                        if (draftStatus) {
                            draftStatus.classList.remove('hidden');
                            draftStatusText.textContent = `Draft tersimpan (${data.saved_at})`;
                        }
                    } else {
                        alert('Gagal menyimpan draft: ' + (data.message || 'Terjadi kesalahan'));
                    }
                } catch (error) {
                    console.error('Error saving draft:', error);
                    alert('Gagal menyimpan draft. Silakan coba lagi.');
                } finally {
                    // Restore button state
                    if (saveDraftBtn) {
                        saveDraftBtn.disabled = false;
                        saveDraftBtn.innerHTML = '<span class="flex items-center justify-center"><svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>Simpan Draft</span>';
                    }
                }
            }

            // --- FUNGSI UNTUK MENGELOLA MODAL (DENGAN ANIMASI) ---
            function showModal() {
                if (!modal) return;
                const modalPanel = modal.querySelector('div.relative'); // Panel utama modal

                modal.style.display = 'flex';
                modal.classList.remove('hidden');
                // Trigger reflow agar transisi CSS berjalan dengan benar
                modal.offsetHeight;

                modal.classList.remove('opacity-0');
                if (modalPanel) {
                    // Hapus class yang membuat panel mengecil/transparan
                    modalPanel.classList.remove('opacity-0', 'scale-95');
                }
            }

            function hideModal() {
                if (!modal) return;
                const modalPanel = modal.querySelector('div.relative');

                modal.classList.add('opacity-0');
                if (modalPanel) {
                    // Tambahkan class untuk memulai animasi keluar
                    modalPanel.classList.add('opacity-0', 'scale-95');
                }

                // Sembunyikan elemen setelah animasi selesai (300ms)
                setTimeout(() => {
                    modal.style.display = 'none';
                    modal.classList.add('hidden');
                }, 300);
            }

            // --- FUNGSI UNTUK UPDATE PROGRESS BAR ---
            function updateProgress() {
                const percentage = totalQuestions > 0 ? Math.round((answeredQuestions / totalQuestions) * 100) : 0;
                if (progressFill) progressFill.style.width = percentage + '%';
                if (progressText) progressText.textContent = `${answeredQuestions} / ${totalQuestions} Pertanyaan`;
                if (progressPercentage) progressPercentage.textContent = percentage + '%';

                if (answeredQuestions === totalQuestions) {
                    if (submitBtn) submitBtn.disabled = false;
                    if (completionStatus) {
                        completionStatus.textContent =
                            'Semua pertanyaan sudah terjawab! Anda dapat mengirim jawaban.';
                        completionStatus.classList.add('text-green-600', 'dark:text-green-400');
                    }
                } else {
                    if (submitBtn) submitBtn.disabled = true;
                    if (completionStatus) {
                        completionStatus.textContent =
                            `Mohon lengkapi ${totalQuestions - answeredQuestions} pertanyaan yang tersisa`;
                        completionStatus.classList.remove('text-green-600', 'dark:text-green-400');
                    }
                }
            }

            // Atur Tampilan Pilihan yang Sudah Ada Saat Halaman Dimuat (termasuk dari draft)
            document.querySelectorAll('input[type="radio"]:checked').forEach(checkedRadio => {
                const parentLabel = checkedRadio.closest('.option-button');
                if (parentLabel) parentLabel.classList.add('selected');
                const parentCard = checkedRadio.closest('.question-card');
                if (parentCard && !parentCard.classList.contains('answered')) {
                    parentCard.classList.add('answered');
                    answeredQuestions++;
                }
            });
            updateProgress();

            // Show draft status if there are pre-filled answers from draft
            @if(!empty($draftAnswers))
            if (draftStatus) {
                draftStatus.classList.remove('hidden');
                draftStatusText.textContent = 'Draft dimuat';
            }
            @endif

            // Event listener untuk pilihan jawaban
            document.querySelectorAll('input[type="radio"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    const questionCard = this.closest('.question-card');
                    const optionButtons = questionCard.querySelectorAll('.option-button');
                    optionButtons.forEach(btn => btn.classList.remove('selected'));
                    this.closest('.option-button').classList.add('selected');
                    if (!questionCard.classList.contains('answered')) {
                        questionCard.classList.add('answered');
                        answeredQuestions++;
                    }
                    updateProgress();
                });
            });

            // Event listener untuk tombol simpan draft
            if (saveDraftBtn) {
                saveDraftBtn.addEventListener('click', function(event) {
                    event.preventDefault();
                    saveDraft();
                });
            }

            // Event listener untuk tombol kirim utama
            if (submitBtn) {
                submitBtn.addEventListener('click', function(event) {
                    event.preventDefault();
                    if (!form.checkValidity()) {
                        form.reportValidity();
                        return;
                    }
                    showModal();
                });
            }

            // Event Listener untuk SEMUA Tombol Modal
            if (confirmYesButton) {
                confirmYesButton.addEventListener('click', function() {
                    if (userConfirmationInput) userConfirmationInput.value = 'setuju';
                    form.submit();
                });
            }
            if (confirmNoButton) {
                confirmNoButton.addEventListener('click', function() {
                    if (userConfirmationInput) userConfirmationInput.value = 'tidak_setuju';
                    form.submit();
                });
            }
            if (closeModalBtn) {
                closeModalBtn.addEventListener('click', function() {
                    hideModal();
                });
            }
        });
    </script>
</x-app-layout>

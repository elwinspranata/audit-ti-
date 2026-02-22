<x-auditor-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f8fafc;
        }

        .section-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 1rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 800;
            color: #000000;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            border-bottom: 2px solid #000;
            padding-bottom: 0.5rem;
            text-transform: uppercase;
        }

        .form-label {
            display: block;
            font-size: 0.75rem;
            font-weight: 800;
            color: #475569;
            text-transform: uppercase;
            margin-bottom: 0.5rem;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            background: #ffffff;
            border: 1.5px solid #e2e8f0;
            border-radius: 0.5rem;
            font-size: 0.9375rem;
        }
    </style>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="mb-10 px-4 sm:px-0">
                <a href="{{ route('auditor.dashboard') }}" class="inline-flex items-center text-sm font-bold text-blue-600 hover:underline mb-4">
                    ← KEMBALI KE DASHBOARD
                </a>
                <h1 class="text-3xl font-black text-gray-900 tracking-tight text-uppercase">EDIT AUDIT REPORT (PDF SYNC)</h1>
                <p class="text-gray-500 mt-1">Hanya menampilkan kolom yang akan dicetak di laporan PDF 3 halaman.</p>
            </div>

            {{-- AUTOMATED SUMMARY SECTION --}}
            <div class="mb-10 space-y-6">
                {{-- TABLE 1: EVALUATION DISTRIBUTION (Horizontal) --}}
                <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
                    <div class="bg-black py-3 px-6">
                        <h3 class="text-white text-xs font-black uppercase tracking-widest text-center">Evaluation Distribution</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="bg-gray-100">
                                    @foreach([5, 4, 3, 2, 1] as $lvl)
                                    <th class="border border-gray-200 py-3 px-4 text-[11px] font-black italic text-gray-700">Level {{ $lvl }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach([5, 4, 3, 2, 1] as $lvl)
                                    <td id="dist-table-count-{{ $lvl }}" class="border border-gray-200 py-4 px-4 text-center font-black text-xl text-gray-900">0</td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    {{-- TABLE 2 & 3: IT PROCESS & RATING --}}
                    <div id="it-process-summary-card" class="bg-white rounded-2xl p-6 shadow-xl border border-gray-200 flex flex-col">
                        <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4 flex items-center justify-between">
                            IT Process Summary
                            <span class="text-blue-600 font-bold">AUTOMATED</span>
                        </h3>
                        <div class="overflow-hidden rounded-lg border border-gray-100 flex-grow">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-[10px] font-black text-gray-500 uppercase">IT Process Name</th>
                                        <th class="px-4 py-2 text-center text-[10px] font-black text-gray-500 uppercase w-24">COBIT Rating</th>
                                    </tr>
                                </thead>
                                <tbody id="it-process-summary-body" class="bg-white divide-y divide-gray-100">
                                    <!-- Dynamic Content -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- OVERALL MATURITY --}}
                    <div class="bg-white rounded-2xl p-6 shadow-xl border border-gray-200 flex flex-col justify-center items-center text-center">
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Overall Maturity Actual</span>
                        <div class="relative">
                            <span id="live-overall-rating" class="text-7xl font-black text-gray-900 tracking-tighter">{{ $report->maturity_rating_actual ? number_format($report->maturity_rating_actual, 1) : '0.0' }}</span>
                            <span class="absolute -top-1 -right-6 text-xl font-black text-blue-600">/5</span>
                        </div>
                        <div class="mt-4 px-4 py-1 bg-gray-100 rounded-full">
                            <span id="rating-label" class="text-[10px] font-black uppercase text-gray-600">
                                {{ $report->capability_label }}
                            </span>
                        </div>
                        <p class="mt-4 text-[9px] text-gray-400 italic">Otomatis terhitung berdasarkan rating di atas.</p>
                    </div>
                </div>
            </div>

            <form action="{{ route('auditor.report.update', $report) }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')

                {{-- HALAMAN 1: COVER --}}
                <div class="section-card">
                    <h2 class="section-title">Halaman 1: Cover & Kontak</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div class="md:col-span-2">
                            <label class="form-label">Judul Assessment (Joint Risk Assessment) *</label>
                            <input type="text" name="report_title" required class="form-input font-bold" value="{{ old('report_title', $report->report_title) }}">
                        </div>
                        <div>
                            <label class="form-label">Nama Perusahaan *</label>
                            <input type="text" name="company_name" required class="form-input" value="{{ old('company_name', $report->company_name) }}">
                        </div>
                        <div>
                            <label class="form-label">Sign-off Authority *</label>
                            <input type="text" name="sign_off_authority" required class="form-input" value="{{ old('sign_off_authority', $report->sign_off_authority) }}">
                        </div>
                        <div class="md:col-span-2">
                            <label class="form-label">Alamat / Departemen Pelaksana *</label>
                            <input type="text" name="company_address" required class="form-input" value="{{ old('company_address', $report->company_address) }}">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="form-label">Audit Director *</label>
                            <input type="text" name="audit_director" required class="form-input" value="{{ old('audit_director', $report->audit_director) }}">
                        </div>
                        <div>
                            <label class="form-label">Audit Manager *</label>
                            <input type="text" name="audit_manager" required class="form-input" value="{{ old('audit_manager', $report->audit_manager) }}">
                        </div>
                        <div>
                            <label class="form-label">Lead Auditor *</label>
                            <input type="text" name="lead_auditor_name" required class="form-input" value="{{ old('lead_auditor_name', $report->lead_auditor_name) }}">
                        </div>
                    </div>
                </div>

                {{-- HALAMAN 2: EXECUTIVE SUMMARY --}}
                <div class="section-card">
                    <h2 class="section-title">Halaman 2: Executive Summary & Response</h2>
                    <div class="space-y-6">
                        <div>
                            <label class="form-label">Overall Summary of Assessment Results *</label>
                            <textarea name="executive_summary" rows="5" required class="form-input">{{ old('executive_summary', $report->executive_summary) }}</textarea>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="form-label">Background *</label>
                                <textarea name="background" rows="4" required class="form-input">{{ old('background', $report->background) }}</textarea>
                            </div>
                            <div>
                                <label class="form-label">Scope *</label>
                                <textarea name="scope" rows="4" required class="form-input">{{ old('scope', $report->scope) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="mt-10 pt-8 border-t border-gray-100">
                        <h3 class="font-bold text-sm mb-4">Responsible Officer Overall Response</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                            <div>
                                <label class="form-label">Officer Name *</label>
                                <input type="text" name="officer_name" required class="form-input" value="{{ old('officer_name', $report->officer_name) }}">
                            </div>
                            <div>
                                <label class="form-label">Title (Jabatan) *</label>
                                <input type="text" name="officer_title" required class="form-input" value="{{ old('officer_title', $report->officer_title) }}">
                            </div>
                            <div>
                                <label class="form-label">Date of Response *</label>
                                <input type="date" name="officer_response_date" required class="form-input" value="{{ old('officer_response_date', $report->officer_response_date ? \Carbon\Carbon::parse($report->officer_response_date)->format('Y-m-d') : '') }}">
                            </div>
                        </div>
                        <div>
                            <label class="form-label">Response Text *</label>
                            <textarea name="officer_response" rows="4" required class="form-input">{{ old('officer_response', $report->officer_response) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- HALAMAN 3: FOCAL POINTS --}}
                <div class="section-card">
                    <div class="flex items-center justify-between mb-6 border-b-2 border-black pb-2">
                        <h2 class="text-xl font-extrabold uppercase tracking-tight">Halaman 3: IT Process Focal Points</h2>
                        <button type="button" onclick="addITProcessFocal()" class="bg-black text-white px-4 py-2 rounded text-xs font-bold uppercase hover:bg-gray-800 transition-colors">
                            + Tambah Proses
                        </button>
                    </div>
                    <p class="text-xs text-gray-400 mb-8 italic">* Evaluation Distribution akan dihitung otomatis di PDF berdasarkan rating proses di bawah ini.</p>
                    
                    <div id="it-process-focal-container" class="space-y-8"></div>
                </div>

                <div class="flex items-center justify-end gap-4 pt-6">
                    <a href="{{ route('auditor.report.show', $report) }}" class="text-sm font-bold text-gray-400 hover:text-black transition-colors">BATAL</a>
                    <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-lg font-black uppercase tracking-widest shadow-lg hover:bg-blue-700 transition-all transform hover:-translate-y-1">
                        SIMPAN PERUBAHAN
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let itProcessFocalCounter = 0;

        function addITProcessFocal(data = null) {
            const container = document.getElementById('it-process-focal-container');
            const index = itProcessFocalCounter++;
            const html = `
                <div class="p-6 ${data?.is_new_addition ? 'bg-blue-50/50 border-blue-200' : 'bg-gray-50 border-gray-200'} border rounded-xl relative mb-8 focal-item" id="it-process-focal-${index}">
                    <button type="button" onclick="removeFocal(${index})" class="absolute top-4 right-4 text-gray-300 hover:text-red-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                    ${data?.is_new_addition ? '<span class="absolute top-0 left-6 -translate-y-1/2 bg-blue-600 text-white text-[10px] font-black px-2 py-0.5 rounded-full uppercase tracking-widest shadow-sm">Proses Baru</span>' : ''}
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                        <div class="md:col-span-3">
                            <label class="form-label flex items-center gap-2">
                                IT Process Name
                                <span class="bg-blue-100 text-blue-600 text-[8px] px-1.5 py-0.5 rounded font-black uppercase tracking-tight">Automated</span>
                            </label>
                            <input type="text" name="it_process_focal_points[${index}][process_name]" required value="${data?.process_name || ''}" readonly class="form-input font-bold bg-gray-100 border-gray-200 cursor-not-allowed">
                        </div>
                        <div>
                            <label class="form-label">COBIT Rating (0-5)</label>
                            <div class="flex items-center gap-3">
                                <div class="w-full bg-blue-50 border border-blue-100 text-blue-700 font-black text-center py-2 rounded-lg">
                                    Level ${data?.rating || 0}
                                </div>
                                <input type="hidden" name="it_process_focal_points[${index}][rating]" value="${data?.rating || 0}" class="rating-select">
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="form-label">Rating Justification (Per Baris)</label>
                            <textarea name="it_process_focal_points[${index}][justification_text]" rows="3" class="form-input text-xs">${data?.justification_text || ''}</textarea>
                        </div>
                        <div>
                            <label class="form-label">Indicators / Metrics (Per Baris)</label>
                            <textarea name="it_process_focal_points[${index}][indicators_text]" rows="3" class="form-input text-xs">${data?.indicators_text || ''}</textarea>
                        </div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
        }

        function removeFocal(id) {
            const el = document.getElementById(`it-process-focal-${id}`);
            if (el) {
                el.remove();
                updateLiveMetrics();
            }
        }

        function updateLiveMetrics() {
            const focalItems = document.querySelectorAll('.focal-item');
            const counts = {5:0, 4:0, 3:0, 2:0, 1:0, 0:0};
            let totalRating = 0;
            let totalProc = 0;
            
            const summaryBody = document.getElementById('it-process-summary-body');
            if (summaryBody) summaryBody.innerHTML = '';

            focalItems.forEach(item => {
                const nameInput = item.querySelector('input[name*="[process_name]"]');
                const ratingSelect = item.querySelector('.rating-select');
                
                const name = nameInput ? nameInput.value : 'Unnamed Process';
                const val = ratingSelect ? parseInt(ratingSelect.value) : 0;
                
                counts[val]++;
                totalRating += val;
                totalProc++;

                // Update Summary Table
                if (summaryBody) {
                    const row = `
                        <tr>
                            <td class="px-4 py-2 text-[11px] font-medium text-gray-700">${name}</td>
                            <td class="px-4 py-2 text-center">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-50 text-blue-700 text-[11px] font-black border border-blue-100">
                                    ${val}
                                </span>
                            </td>
                        </tr>
                    `;
                    summaryBody.insertAdjacentHTML('beforeend', row);
                }
            });

            // Update Overall
            const avg = totalProc > 0 ? (totalRating / totalProc).toFixed(1) : "0.0";
            const liveRating = document.getElementById('live-overall-rating');
            if (liveRating) liveRating.innerText = avg;

            const labels = {
                0: 'Incomplete Process',
                1: 'Performed Process',
                2: 'Managed Process',
                3: 'Established Process',
                4: 'Predictable Process',
                5: 'Optimizing Process'
            };
            const roundedAvg = Math.floor(parseFloat(avg));
            const ratingLabel = document.getElementById('rating-label');
            if (ratingLabel) ratingLabel.innerText = labels[roundedAvg] || 'Not Assessed';

            // Update Dist
            [5,4,3,2,1].forEach(lvl => {
                const percent = totalProc > 0 ? (counts[lvl] / totalProc) * 100 : 0;
                
                // Bars (if still present)
                const bar = document.getElementById(`dist-bar-${lvl}`);
                const countText = document.getElementById(`dist-count-${lvl}`);
                if (bar) bar.style.width = percent + '%';
                if (countText) countText.innerText = counts[lvl] + ' Proc';

                // Table
                const tableCell = document.getElementById(`dist-table-count-${lvl}`);
                if (tableCell) tableCell.innerText = counts[lvl];
            });
        }

        // Init existing
        const itFocals = @json($report->it_process_focal_points ?? []);
        if (itFocals.length > 0) {
            itFocals.forEach(f => {
                f.justification_text = f.justification_points ? f.justification_points.join('\n') : '';
                f.indicators_text = f.indicators ? f.indicators.join('\n') : '';
                addITProcessFocal(f);
            });
        } else {
            addITProcessFocal();
        }
        
        // Initial Calculation
        updateLiveMetrics();
    </script>
</x-auditor-layout>

<div class="mt-12 mb-8 flex flex-col sm:flex-row items-center justify-center gap-4 p-8 bg-slate-50 border border-slate-200 rounded-2xl shadow-inner">
    @if(isset($designFactor) && $designFactor->is_locked)
        <div class="flex items-center px-10 py-4 text-base font-bold text-slate-500 bg-slate-200 rounded-xl cursor-not-allowed border border-slate-300">
            <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
            </svg>
            Analisis Terkunci
        </div>
    @else
        {{-- Save Button --}}
        <button type="submit" id="saveBtnMain"
            class="w-full sm:w-auto flex items-center justify-center px-10 py-4 text-base font-extrabold text-white bg-green-600 rounded-xl hover:bg-green-700 active:scale-95 transition-all shadow-md hover:shadow-lg">
            <svg class="w-6 h-6 mr-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
            </svg>
            Simpan Analisis {{ $type }}
        </button>

        {{-- Reset Button --}}
        <button type="button" id="resetAllBtn"
            class="w-full sm:w-auto flex items-center justify-center px-10 py-4 text-base font-extrabold text-white bg-red-600 rounded-xl hover:bg-red-700 active:scale-95 transition-all shadow-md hover:shadow-lg">
            <svg class="w-6 h-6 mr-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            Reset Semua DF
        </button>
    @endif
</div>

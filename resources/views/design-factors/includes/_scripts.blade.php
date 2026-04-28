@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const factorType = "{{ $type }}";
        const cobitMappings = {
            DF1: @json(\App\Utils\CobitData::getDF1Mapping()),
            DF2_EG_AG: @json(\App\Utils\CobitData::getDF2EgToAgMapping()),
            DF2_AG_GMO: @json(\App\Utils\CobitData::getDF2AgToGmoMapping()),
            DF3: @json(\App\Utils\CobitData::getDF3Mapping()),
            DF4: @json(\App\Utils\CobitData::getDF4Mapping()),
            DF6: @json(\App\Utils\CobitData::getDF6Mapping()),
            DF7: @json(\App\Utils\CobitData::getDF7Mapping()),
            DF8: @json(\App\Utils\CobitData::getDF8Mapping()),
            DF9: @json(\App\Utils\CobitData::getDF9Mapping()),
            DF10: @json(\App\Utils\CobitData::getDF10Mapping())
        };

        const importanceInputs = document.querySelectorAll('.importance-input');
        const df3Inputs = document.querySelectorAll('.df3-input');
        const baselineInputs = document.querySelectorAll('.baseline-input');

        let chartLabels = @json($designFactor->items->pluck('code'));
        let chartData = [];
        let barChart = null;
        let radarChart = null;

        const itemScoreHiddens = document.querySelectorAll('.item-score-hidden');
        const itemBaselineHiddens = document.querySelectorAll('.item-baseline-hidden');
        const itemScoreDisplays = document.querySelectorAll('.item-score-display');
        const itemBaselineDisplays = document.querySelectorAll('.item-baseline-display');

        let itemScores = [];
        let itemBaselines = [];

        // Populate from hidden inputs
        itemScoreHiddens.forEach((input, index) => {
            itemScores[index] = parseFloat(input.value) || 0;
        });
        itemBaselineHiddens.forEach((input, index) => {
            itemBaselines[index] = parseFloat(input.value) || 0;
        });

        // Common notification function
        window.showNotification = function(message, type = 'info') {
            const existingNotif = document.getElementById('inputNotification');
            if (existingNotif) existingNotif.remove();

            const notification = document.createElement('div');
            notification.id = 'inputNotification';
            notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg transition-all transform ${type === 'warning' ? 'bg-yellow-500 text-white' :
                type === 'error' ? 'bg-red-500 text-white' : 'bg-blue-500 text-white'}`;
            notification.innerHTML = `
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1-1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-medium">${message}</span>
                </div>`;
            document.body.appendChild(notification);
            setTimeout(() => {
                notification.style.opacity = '0';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        };

        // Shared risk display update
        window.updateRiskDisplays = function() {
            if (factorType === 'DF3') {
                const categories = {};
                df3Inputs.forEach(input => {
                    const key = input.dataset.key;
                    const val = parseInt(input.value) || 0;
                    const parentTd = input.closest('td');
                    parentTd.classList.remove('bg-val-1', 'bg-val-2', 'bg-val-3', 'bg-val-4', 'bg-val-5', 'importance-cell');
                    if (val >= 1 && val <= 5) parentTd.classList.add(`bg-val-${val}`);
                    else parentTd.classList.add('importance-cell');

                    if (!categories[key]) categories[key] = { impact: 3, likelihood: 3 };
                    if (input.classList.contains('impact-input')) categories[key].impact = parseFloat(input.value) || 3;
                    if (input.classList.contains('likelihood-input')) categories[key].likelihood = parseFloat(input.value) || 3;
                });

                for (const key in categories) {
                    const rating = categories[key].impact * categories[key].likelihood;
                    const dot = document.querySelector(`.risk-dot[data-key="${key}"]`);
                    if (dot) {
                        dot.className = 'w-4 h-4 rounded-full risk-dot shadow-sm';
                        dot.style.border = '1px solid #000';
                        if (rating >= 15) dot.style.backgroundColor = '#c00000';
                        else if (rating >= 8) dot.style.backgroundColor = '#edbd70';
                        else if (rating >= 4) dot.style.backgroundColor = '#72a488';
                        else dot.style.backgroundColor = '#4b4b4b';
                    }
                }
            }
        };

        window.updateCharts = function() {
            if (!barChart || !radarChart) return;
            barChart.data.datasets[0].data = chartData;
            barChart.data.datasets[0].backgroundColor = chartData.map(v => v >= 0 ? 'rgba(79, 124, 53, 0.7)' : 'rgba(192, 0, 0, 0.7)');
            barChart.data.datasets[0].borderColor = chartData.map(v => v >= 0 ? 'rgba(79, 124, 53, 1)' : 'rgba(192, 0, 0, 1)');
            barChart.update('none');
            radarChart.data.datasets[0].data = chartData.map(v => v + 100);
            radarChart.update('none');
        };

        // Hook for factor-specific calculation
        window.calculate = function() {
            window.updateRiskDisplays();
            if (typeof window.factorCalculate === 'function') {
                window.factorCalculate({
                    factorType, cobitMappings, importanceInputs, df3Inputs, baselineInputs,
                    itemScores, itemBaselines, itemScoreHiddens, itemBaselineHiddens,
                    itemScoreDisplays, itemBaselineDisplays, chartLabels, 
                    setChartData: (data) => { chartData = data; }
                });
            }
        };

        // Event Listeners
        importanceInputs.forEach(input => {
            input.addEventListener('input', function() {
                if (typeof window.validateMaxValue === 'function') window.validateMaxValue(this);
                window.calculate();
            });
            input.addEventListener('change', window.calculate);
        });

        df3Inputs.forEach(input => {
            input.addEventListener('input', function() {
                if (typeof window.validateMaxValue === 'function') window.validateMaxValue(this);
                window.calculate();
            });
        });

        if (typeof window.factorInitCharts === 'function') {
            const charts = window.factorInitCharts(Chart, factorType, chartLabels, chartData);
            if (charts) {
                barChart = charts.barChart;
                radarChart = charts.radarChart;
            }
        }

        window.calculate();

        // Reset All Button
        const resetAllBtn = document.getElementById('resetAllBtn');
        if (resetAllBtn) {
            resetAllBtn.addEventListener('click', function () {
                Swal.fire({
                    title: 'Reset Semua Design Factor?',
                    text: "Seluruh data DF1 hingga DF10 akan dihapus secara permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Reset Semua!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '{{ route('design-factors.reset-all') }}';
                        const csrfToken = document.createElement('input');
                        csrfToken.type = 'hidden';
                        csrfToken.name = '_token';
                        csrfToken.value = '{{ csrf_token() }}';
                        form.appendChild(csrfToken);
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });
        }
    });

    window.validateMaxValue = function(input) {
        const val = parseInt(input.value) || 0;
        const maxVal = 5;
        const minVal = 1;
        if (['DF6', 'DF8', 'DF9', 'DF10', 'DF5'].includes("{{ $type }}")) return;
        if (val > maxVal) {
            input.value = maxVal;
            window.showNotification(`Nilai maksimal adalah ${maxVal}.`, 'warning');
        } else if (val < minVal && val !== 0) {
            input.value = minVal;
            window.showNotification(`Nilai minimal adalah ${minVal}.`, 'warning');
        }
    };
</script>
@endpush

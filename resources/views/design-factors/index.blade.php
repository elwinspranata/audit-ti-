<x-app-layout>
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @include('design-factors.includes._styles')

    <div class="min-h-screen py-8 bg-gray-100">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">

            <!-- Page Header -->
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold text-gray-800">Kalkulator COBIT Relative Importance</h1>
                <p class="mt-2 text-gray-600">Tailoring Governance System based on Design Factors</p>
            </div>

            <!-- Design Factor Tabs -->
            @include('design-factors.includes._navigation')

            <!-- Success Alert -->
            @if(session('success'))
                <div class="flex items-center p-4 mb-6 bg-green-100 border border-green-300 rounded-lg shadow-sm">
                    <svg class="w-5 h-5 mr-3 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-green-800">{{ session('success') }}</span>
                </div>
            @endif

            <form id="designFactorForm" action="{{ route('design-factors.store') }}" method="POST">
                @csrf
                <input type="hidden" name="factor_type" value="{{ $type }}">

                <!-- Factor Specific Content (Separated into individual Blade files) -->
                @include('design-factors.factors.' . strtolower($type))

                <!-- Action Buttons (Save, Reset) -->
                @include('design-factors.includes._actions')
            </form>
        </div>
    </div>

    @include('design-factors.includes._scripts')
</x-app-layout>
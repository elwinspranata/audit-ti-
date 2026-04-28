<div class="flex flex-wrap justify-center gap-2 mb-8">
    @php
        $mainTabs = [
            'DF1' => 'DF1: Enterprise Strategy',
            'DF2' => 'DF2: Enterprise Goals',
            'DF3' => 'DF3: Risk Profile',
            'DF4' => 'DF4: IT-Related Issues',
        ];
    @endphp

    @foreach($mainTabs as $tabType => $tabLabel)
        @php
            $isAccessible = isset($progress[$tabType]) && $progress[$tabType]['accessible'];
            $isCompleted = isset($progress[$tabType]) && $progress[$tabType]['completed'];
        @endphp
        <a href="{{ $isAccessible ? route('design-factors.index', $tabType) : '#' }}"
            class="px-6 py-2 text-sm font-bold rounded-full transition-all inline-flex items-center gap-2
            {{ $type === $tabType ? 'bg-green-600 text-white shadow-lg' : ($isAccessible ? 'bg-white text-gray-600 hover:bg-gray-200' : 'bg-gray-300 text-gray-500 cursor-not-allowed opacity-60') }}"
            {{ !$isAccessible ? 'onclick="return false;"' : '' }}>
            {{ $tabLabel }}
            @if($isCompleted)
                <span class="text-lg">✅</span>
            @endif
        </a>
    @endforeach

    {{-- Summary Tab --}}
    @php
        $summaryAccessible = isset($progress['Summary']) && $progress['Summary']['accessible'];
        $summaryLocked = isset($progress['Summary']) && $progress['Summary']['locked'];
    @endphp
    <a href="{{ $summaryAccessible ? route('design-factors.summary') : '#' }}"
        class="px-6 py-2 text-sm font-bold rounded-full transition-all inline-flex items-center gap-2
        {{ $summaryAccessible ? 'bg-white text-gray-600 hover:bg-gray-200' : 'bg-gray-300 text-gray-500 cursor-not-allowed opacity-60' }}" {{ !$summaryAccessible ? 'onclick="return false;"' : '' }}>
        Summary
        @if($summaryLocked)
            <span class="text-lg">🔒</span>
        @endif
    </a>

    {{-- DF5 Tab --}}
    @php
        $df5Accessible = isset($progress['DF5']) && $progress['DF5']['accessible'];
        $df5Completed = isset($progress['DF5']) && $progress['DF5']['completed'];
    @endphp
    <a href="{{ $df5Accessible ? route('design-factors.index', 'DF5') : '#' }}"
        class="px-6 py-2 text-sm font-bold rounded-full transition-all inline-flex items-center gap-2
        {{ $type === 'DF5' ? 'bg-green-600 text-white shadow-lg' : ($df5Accessible ? 'bg-white text-gray-600 hover:bg-gray-200' : 'bg-gray-300 text-gray-500 cursor-not-allowed opacity-60') }}"
        {{ !$df5Accessible ? 'onclick="return false;"' : '' }}>
        DF5: Governance Obj.
        @if($df5Completed)
            <span class="text-lg">✅</span>
        @endif
    </a>

    @php
        $otherTabs = [
            'DF6' => 'DF6: Threat Landscape',
            'DF7' => 'DF7: Importance of Role of IT',
            'DF8' => 'DF8: Sourcing Model',
            'DF9' => 'DF9: IT Implementation',
            'DF10' => 'DF10: Tech Adoption',
        ];
    @endphp

    @foreach($otherTabs as $tabType => $tabLabel)
        @php
            $isAccessible = isset($progress[$tabType]) && $progress[$tabType]['accessible'];
            $isCompleted = isset($progress[$tabType]) && $progress[$tabType]['completed'];
        @endphp
        <a href="{{ $isAccessible ? route('design-factors.index', $tabType) : '#' }}"
            class="px-6 py-2 text-sm font-bold rounded-full transition-all inline-flex items-center gap-2
                {{ $type === $tabType ? 'bg-green-600 text-white shadow-lg' : ($isAccessible ? 'bg-white text-gray-600 hover:bg-gray-200' : 'bg-gray-300 text-gray-500 cursor-not-allowed opacity-60') }}"
            {{ !$isAccessible ? 'onclick="return false;"' : '' }}>
            {{ $tabLabel }}
            @if($isCompleted)
                <span class="text-lg">✅</span>
            @endif
        </a>
    @endforeach

    {{-- Summary DF5-DF10 Tab (after DF10) --}}
    @php
        $df10Completed = isset($progress['DF10']) && $progress['DF10']['completed'];
    @endphp
    <a href="{{ $df10Completed ? route('design-factors.summary-df510') : '#' }}"
        class="px-6 py-2 text-sm font-bold rounded-full transition-all inline-flex items-center gap-2
        {{ $df10Completed ? 'bg-blue-600 text-white hover:bg-blue-700 shadow-md' : 'bg-gray-300 text-gray-500 cursor-not-allowed opacity-60' }}" {{ !$df10Completed ? 'onclick="return false;"' : '' }}>
        📊 Summary
    </a>
</div>

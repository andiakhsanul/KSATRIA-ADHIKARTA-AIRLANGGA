@php
    $colors = [
        'error' => 'border-red-500 text-red-700 bg-red-50',
        'warning' => 'border-amber-500 text-amber-700 bg-amber-50',
        'success' => 'border-green-500 text-green-700 bg-green-50',
        'info' => 'border-blue-500 text-blue-700 bg-blue-50',
    ];
    $colorClass = $colors[$type] ?? $colors['error'];
    
    $icons = [
        'error' => 'alert-circle',
        'warning' => 'alert-triangle',
        'success' => 'check-circle',
        'info' => 'info',
    ];
    $icon = $icons[$type] ?? 'alert-circle';
@endphp

<div class="relative w-full rounded-lg border p-4 {{ $colorClass }}" role="alert">
    <div class="absolute left-4 top-4 flex h-5 w-5 items-center justify-center">
        @if($icon === 'alert-circle')
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-alert-circle">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" x2="12" y1="8" y2="12"></line>
                <line x1="12" x2="12.01" y1="16" y2="16"></line>
            </svg>
        @elseif($icon === 'alert-triangle')
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-alert-triangle">
                <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"></path>
                <line x1="12" x2="12" y1="9" y2="13"></line>
                <line x1="12" x2="12.01" y1="17" y2="17"></line>
            </svg>
        @elseif($icon === 'check-circle')
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-check-circle">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                <polyline points="22 4 12 14.01 9 11.01"></polyline>
            </svg>
        @elseif($icon === 'info')
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-info">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" x2="12" y1="16" y2="12"></line>
                <line x1="12" x2="12.01" y1="8" y2="8"></line>
            </svg>
        @endif
    </div>
    <div class="pl-7">
        <h5 class="mb-1 font-medium leading-none tracking-tight capitalize">{{ $type }}</h5>
        <div class="text-sm">
            <p class="leading-relaxed">{{ $message }}</p>
        </div>
    </div>
</div>
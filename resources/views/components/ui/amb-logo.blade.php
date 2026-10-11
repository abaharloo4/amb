@props([
    'size' => 'md',
    'variant' => 'flat', // 'flat' or 'gradient'
])

@php
    $sizes = [
        'sm' => 'h-7',
        'md' => 'h-10',
        'lg' => 'h-16',
        'hero' => 'h-24 sm:h-32',
    ];

    $heightClass = $sizes[$size] ?? $sizes['md'];
@endphp

<div {{ $attributes->merge(['class' => "inline-flex items-center select-none {$heightClass}"]) }}>
    <svg viewBox="0 0 460 160" class="h-full w-auto" fill="none" xmlns="http://www.w3.org/2000/svg">
        <defs>
            <!-- Teal Ribbon Gradient -->
            <linearGradient id="ambTealGrad" x1="0%" y1="100%" x2="100%" y2="0%">
                <stop offset="0%" stop-color="#18424E" />
                <stop offset="45%" stop-color="#29665F" />
                <stop offset="100%" stop-color="#79CCBB" />
            </linearGradient>

            <!-- Golden Orange Signature Triangle Accent Gradient -->
            <linearGradient id="ambOrangeGrad" x1="0%" y1="100%" x2="100%" y2="0%">
                <stop offset="0%" stop-color="#D68106" />
                <stop offset="60%" stop-color="#F49D07" />
                <stop offset="100%" stop-color="#FFC45C" />
            </linearGradient>

            <!-- Shadow for depth overlap -->
            <filter id="ambGlow" x="-20%" y="-20%" width="140%" height="140%">
                <feDropShadow dx="0" dy="4" stdDeviation="6" flood-color="#18424E" flood-opacity="0.3" />
            </filter>
        </defs>

        <!-- Triangle Accent inside A (Golden Orange Signature) -->
        <polygon points="46,132 94,54 142,132" fill="url(#ambOrangeGrad)" />

        <!-- Letter 'A' Outer Ribbon Frame -->
        <path d="M12 132 L84 22 C89 13 99 13 104 22 L176 132 C181 140 173 148 164 148 L142 148 C136 148 131 144 128 138 L94 80 L60 138 C57 144 52 148 46 148 L24 148 C15 148 7 140 12 132 Z" 
              fill="{{ $variant === 'gradient' ? 'url(#ambTealGrad)' : '#18424E' }}" 
              class="dark:fill-[#29665F] transition-colors" />

        <!-- Interconnecting Ribbon Arch from 'A' to 'M' -->
        <path d="M152 64 C168 28 200 24 220 54 L244 92 L268 54 C288 24 320 28 336 64 L336 136 C336 144 328 148 320 148 L304 148 C296 148 290 142 290 134 L290 74 C280 58 266 58 254 78 L236 106 C232 112 224 112 220 106 L202 78 C190 58 176 58 166 74 L166 134 C166 142 160 148 152 148 L136 148 C128 148 120 144 120 136 Z" 
              fill="{{ $variant === 'gradient' ? 'url(#ambTealGrad)' : '#29665F' }}" 
              class="dark:fill-[#79CCBB] transition-colors" />

        <!-- Golden Orange Connector slice under M/B junction -->
        <path d="M260 76 L284 114 C288 120 292 126 292 134 L292 148 L268 148 C260 148 256 142 252 136 Z" 
              fill="url(#ambOrangeGrad)" />

        <!-- Letter 'B' Ribbon Loop Construction -->
        <path d="M280 28 L386 28 C424 28 448 46 448 74 C448 94 434 108 412 114 C438 120 454 136 454 158 C454 190 424 204 386 204 L280 204 C272 204 266 198 266 190 L266 42 C266 34 272 28 280 28 Z M314 56 L314 96 L376 96 C394 96 406 88 406 76 C406 64 394 56 376 56 Z M314 118 L314 162 L382 162 C402 162 414 152 414 140 C414 128 402 118 382 118 Z" 
              transform="matrix(0.74 0 0 0.74 120 0)"
              fill="{{ $variant === 'gradient' ? 'url(#ambTealGrad)' : '#18424E' }}" 
              class="dark:fill-[#29665F] transition-colors" />
    </svg>
</div>

@props([
    'label' => null,
    'hint' => null,
    'error' => null,
    'required' => false,
    'id' => null,
])

<div {{ $attributes->merge(['class' => 'space-y-1.5']) }}>
    @if ($label)
        <label
            @if ($id) for="{{ $id }}" @endif
            class="block text-sm font-medium text-content-primary"
        >
            {{ $label }}
            @if ($required)
                <span class="text-status-error ms-0.5" aria-hidden="true">*</span>
            @endif
        </label>
    @endif

    <div>
        {{ $slot }}
    </div>

    @if ($error)
        <p class="text-xs text-status-error flex items-center gap-1 font-medium mt-1">
            <x-ui.icon name="alert-triangle" size="xs" />
            <span>{{ $error }}</span>
        </p>
    @elseif ($hint)
        <p class="text-xs text-content-secondary mt-1">
            {{ $hint }}
        </p>
    @endif
</div>

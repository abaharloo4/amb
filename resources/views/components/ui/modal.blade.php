@props([
    'name',
    'title' => null,
])

<div
    x-data="{ show: false }"
    x-on:open-modal.window="if ($event.detail === '{{ $name }}') show = true"
    x-on:close-modal.window="if ($event.detail === '{{ $name }}') show = false"
    x-on:keydown.escape.window="show = false"
    x-show="show"
    style="display: none;"
    class="fixed inset-0 z-[400] overflow-y-auto px-4 py-6 sm:px-0 flex items-center justify-center"
    role="dialog"
    aria-modal="true"
>
    <!-- Backdrop -->
    <div
        x-show="show"
        x-transition:enter="ease-out duration-normal"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-fast"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        x-on:click="show = false"
        class="fixed inset-0 bg-black/60 backdrop-blur-sm"
        aria-hidden="true"
    ></div>

    <!-- Modal Panel -->
    <div
        x-show="show"
        x-transition:enter="ease-out duration-normal"
        x-transition:enter-start="opacity-0 scale-95 translate-y-4"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="ease-in duration-fast"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-95 translate-y-4"
        class="relative w-full max-w-lg bg-surface border border-edge rounded-xl shadow-xl overflow-hidden z-10"
    >
        @if ($title)
            <div class="flex items-center justify-between px-6 py-4 border-b border-edge">
                <h3 class="text-base font-semibold text-content-heading">{{ $title }}</h3>
                <button
                    type="button"
                    x-on:click="show = false"
                    class="text-content-secondary hover:text-content-primary rounded-md p-1 hover:bg-action-hover transition-colors"
                    aria-label="Close"
                >
                    <x-ui.icon name="x" size="sm" />
                </button>
            </div>
        @endif

        <div class="p-6">
            {{ $slot }}
        </div>
    </div>
</div>

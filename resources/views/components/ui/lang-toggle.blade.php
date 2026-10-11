<button
    type="button"
    x-data
    x-on:click="$store.locale.toggle()"
    class="relative inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-md text-xs font-semibold text-content-secondary hover:text-content-primary hover:bg-action-hover border border-edge transition-colors duration-fast focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-accent cursor-pointer"
    :aria-label="$store.locale.lang === 'fa' ? 'Switch to English' : 'تغییر به فارسی'"
    {{ $attributes }}
>
    <x-ui.icon name="globe" size="sm" />
    <span x-text="$store.locale.lang === 'fa' ? 'EN' : 'فا'"></span>
</button>

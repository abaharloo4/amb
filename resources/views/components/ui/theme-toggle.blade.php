<button
    type="button"
    x-data
    x-on:click="$store.theme.toggle()"
    class="relative inline-flex items-center justify-center p-2 rounded-md text-content-secondary hover:text-content-primary hover:bg-action-hover transition-colors duration-fast focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-accent cursor-pointer"
    :aria-label="$store.theme.current === 'dark' ? 'تغییر به تم روشن' : 'تغییر به تم تاریک'"
    {{ $attributes }}
>
    <!-- Sun icon (shown in dark mode) -->
    <template x-if="$store.theme.current === 'dark'">
        <x-ui.icon name="sun" size="md" />
    </template>

    <!-- Moon icon (shown in light mode) -->
    <template x-if="$store.theme.current === 'light'">
        <x-ui.icon name="moon" size="md" />
    </template>
</button>

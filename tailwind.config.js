/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    darkMode: ['selector', '[data-theme="dark"]'],
    theme: {
        extend: {
            colors: {
                primary: 'var(--bg-primary)',
                surface: 'var(--bg-surface)',
                elevated: 'var(--bg-elevated)',
                brand: {
                    DEFAULT: 'var(--brand-primary)',
                    primary: 'var(--brand-primary)',
                    secondary: 'var(--brand-secondary)',
                    accent: 'var(--brand-accent)',
                },
                content: {
                    primary: 'var(--text-primary)',
                    heading: 'var(--text-heading)',
                    secondary: 'var(--text-secondary)',
                    disabled: 'var(--text-disabled)',
                    onbrand: 'var(--text-on-brand)',
                },
                edge: {
                    DEFAULT: 'var(--border-color)',
                    strong: 'var(--border-strong)',
                },
                link: 'var(--link-color)',
                status: {
                    success: 'var(--status-success)',
                    warning: 'var(--status-warning)',
                    error: 'var(--status-error)',
                    info: 'var(--status-info)',
                },
                action: {
                    hover: 'var(--bg-hover)',
                    active: 'var(--bg-active)',
                },
            },
            fontFamily: {
                sans: ['Vazirmatn', 'Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                mono: ['JetBrains Mono', 'ui-monospace', 'monospace'],
            },
            borderRadius: {
                sm: 'var(--radius-sm)',
                md: 'var(--radius-md)',
                lg: 'var(--radius-lg)',
                xl: 'var(--radius-xl)',
            },
            boxShadow: {
                sm: 'var(--shadow-sm)',
                md: 'var(--shadow-md)',
                lg: 'var(--shadow-lg)',
            },
            transitionDuration: {
                fast: 'var(--motion-duration-fast)',
                normal: 'var(--motion-duration-normal)',
                slow: 'var(--motion-duration-slow)',
            },
            transitionTimingFunction: {
                'out-expo': 'var(--motion-ease-out)',
                'in-out-smooth': 'var(--motion-ease-in-out)',
                'elastic': 'var(--motion-ease-elastic)',
            },
        },
    },
    plugins: [
        // forms plugin
    ],
};

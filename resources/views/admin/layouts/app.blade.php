<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'fa' ? 'rtl' : 'ltr' }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'داشبورد مدیریت') | {{ config('app.name', 'AMB') }}</title>

    <script>
        (function() {
            const savedTheme = localStorage.getItem('amb_theme') || 'dark';
            if (savedTheme === 'light') {
                document.documentElement.classList.remove('dark');
            } else {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-surface-canvas text-content-primary antialiased min-h-screen selection:bg-brand selection:text-white flex flex-col font-sans" x-data="{ sidebarOpen: false }">
    <x-ui.sprite />

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar Navigation -->
        <aside 
            :class="sidebarOpen ? 'translate-x-0' : 'rtl:translate-x-full ltr:-translate-x-full lg:translate-x-0'"
            class="fixed inset-y-0 start-0 z-50 w-72 bg-surface-base border-e border-border-subtle flex flex-col transition-transform duration-300 ease-in-out lg:static lg:z-auto"
        >
            <!-- Logo Header -->
            <div class="h-16 px-6 border-b border-border-subtle flex items-center justify-between">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-brand to-brand-glow p-[1px] shadow-glow">
                        <div class="w-full h-full bg-surface-base rounded-xl flex items-center justify-center">
                            <x-ui.icon name="shield" class="w-5 h-5 text-brand" />
                        </div>
                    </div>
                    <div>
                        <span class="font-bold text-base tracking-tight text-content-primary">AMB Admin</span>
                        <span class="block text-[10px] text-brand uppercase tracking-wider font-semibold">Core v1.0</span>
                    </div>
                </a>

                <button @click="sidebarOpen = false" class="lg:hidden text-content-secondary hover:text-content-primary">
                    <x-ui.icon name="x" class="w-5 h-5" />
                </button>
            </div>

            <!-- Navigation Links -->
            <div class="flex-1 overflow-y-auto p-4 space-y-6">
                <!-- Dashboard Link -->
                <div>
                    <a 
                        href="{{ route('admin.dashboard') }}" 
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-brand/10 text-brand' : 'text-content-secondary hover:text-content-primary hover:bg-surface-subtle' }}"
                    >
                        <x-ui.icon name="layout-dashboard" class="w-5 h-5" />
                        <span>میز کار (داشبورد)</span>
                    </a>
                </div>

                @inject('resourceManager', 'App\Admin\Crud\ResourceManager')
                @foreach ($resourceManager->navigationGroups() as $groupName => $resources)
                    <div>
                        <div class="px-3 mb-2 text-[11px] font-semibold text-content-tertiary uppercase tracking-wider">
                            {{ $groupName }}
                        </div>
                        <div class="space-y-1">
                            @foreach ($resources as $res)
                                @php
                                    $isActive = request()->is('admin/resources/' . $res->slug() . '*');
                                @endphp
                                <a 
                                    href="{{ route('admin.crud.index', $res->slug()) }}"
                                    class="flex items-center justify-between px-3 py-2 rounded-xl text-sm font-medium transition-colors {{ $isActive ? 'bg-brand/10 text-brand' : 'text-content-secondary hover:text-content-primary hover:bg-surface-subtle' }}"
                                >
                                    <div class="flex items-center gap-3">
                                        <x-ui.icon :name="$res->icon()" class="w-4 h-4" />
                                        <span>{{ $res->pluralLabel() }}</span>
                                    </div>
                                    <x-ui.icon name="chevron-left" class="w-3.5 h-3.5 rtl:block ltr:hidden opacity-40" />
                                    <x-ui.icon name="chevron-right" class="w-3.5 h-3.5 ltr:block rtl:hidden opacity-40" />
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <!-- System Section -->
                <div>
                    <div class="px-3 mb-2 text-[11px] font-semibold text-content-tertiary uppercase tracking-wider">
                        سیستم و دسترسی
                    </div>
                    <div class="space-y-1">
                        <a 
                            href="/_ui" target="_blank"
                            class="flex items-center justify-between px-3 py-2 rounded-xl text-sm font-medium text-content-secondary hover:text-content-primary hover:bg-surface-subtle transition-colors"
                        >
                            <div class="flex items-center gap-3">
                                <x-ui.icon name="component" class="w-4 h-4" />
                                <span>کاتالوگ UI و انیمیشن</span>
                            </div>
                            <x-ui.icon name="external-link" class="w-3.5 h-3.5 opacity-50" />
                        </a>
                        <a 
                            href="/" target="_blank"
                            class="flex items-center justify-between px-3 py-2 rounded-xl text-sm font-medium text-content-secondary hover:text-content-primary hover:bg-surface-subtle transition-colors"
                        >
                            <div class="flex items-center gap-3">
                                <x-ui.icon name="globe" class="w-4 h-4" />
                                <span>مشاهده وبسایت اصلی</span>
                            </div>
                            <x-ui.icon name="external-link" class="w-3.5 h-3.5 opacity-50" />
                        </a>
                    </div>
                </div>
            </div>

            <!-- User Footer Profile -->
            <div class="p-4 border-t border-border-subtle bg-surface-subtle/50 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-brand/20 text-brand flex items-center justify-center font-bold text-sm">
                        {{ mb_substr(Auth::user()->name ?? 'A', 0, 1) }}
                    </div>
                    <div class="overflow-hidden">
                        <div class="text-xs font-semibold text-content-primary truncate">{{ Auth::user()->name ?? 'مدیر' }}</div>
                        <div class="text-[11px] text-content-tertiary truncate">{{ Auth::user()->email ?? '' }}</div>
                    </div>
                </div>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="p-2 text-content-tertiary hover:text-danger hover:bg-danger/10 rounded-lg transition-colors" title="خروج از حساب">
                        <x-ui.icon name="log-out" class="w-4 h-4" />
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- Topbar Header -->
            <header class="h-16 px-6 border-b border-border-subtle bg-surface-base/80 backdrop-blur-md flex items-center justify-between z-10">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = true" class="lg:hidden p-2 rounded-lg text-content-secondary hover:bg-surface-subtle">
                        <x-ui.icon name="menu" class="w-5 h-5" />
                    </button>
                    <h2 class="text-base font-semibold text-content-primary hidden sm:block">
                        @yield('header_title', 'میز مدیریت امیرمحمد بحرلو')
                    </h2>
                </div>

                <div class="flex items-center gap-3">
                    <x-ui.theme-toggle />
                    <div class="h-4 w-[1px] bg-border-subtle"></div>
                    <span class="text-xs font-medium px-2.5 py-1 rounded-md bg-brand/10 text-brand border border-brand/20">
                        {{ app()->getLocale() === 'fa' ? 'زبان فارسی' : 'English' }}
                    </span>
                </div>
            </header>

            <!-- Alerts / Notifications -->
            @if (session('success'))
                <div class="mx-6 mt-4 p-4 rounded-2xl bg-success/10 border border-success/20 text-success text-sm flex items-center gap-3 shadow-sm">
                    <x-ui.icon name="check-circle" class="w-5 h-5 flex-shrink-0" />
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="mx-6 mt-4 p-4 rounded-2xl bg-danger/10 border border-danger/20 text-danger text-sm flex items-center gap-3 shadow-sm">
                    <x-ui.icon name="alert-triangle" class="w-5 h-5 flex-shrink-0" />
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- Body Content -->
            <main class="flex-1 overflow-y-auto p-6 md:p-8">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>

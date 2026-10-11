@extends('admin.layouts.app')

@section('title', $config->pluralLabel())
@section('header_title', $config->pluralLabel())

@section('content')
<div class="space-y-6 max-w-7xl mx-auto">
    <!-- Header / Actions -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-content-primary flex items-center gap-2.5">
                <x-ui.icon :name="$config->icon()" class="w-6 h-6 text-brand" />
                <span>{{ $config->pluralLabel() }}</span>
            </h1>
            <p class="text-xs text-content-secondary mt-1">
                مدیریت، ویرایش و مشاهده فهرست رکوردها
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a 
                href="{{ route('admin.crud.create', $config->slug()) }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-brand text-white font-medium text-sm hover:opacity-95 shadow-glow transition-all"
            >
                <x-ui.icon name="plus" class="w-4 h-4" />
                <span>افزودن {{ $config->singularLabel() }} جدید</span>
            </a>
        </div>
    </div>

    <!-- Search & Filters Toolbar -->
    <div class="p-4 rounded-2xl bg-surface-card border border-border-subtle flex flex-col sm:flex-row items-center justify-between gap-4">
        <form method="GET" action="{{ route('admin.crud.index', $config->slug()) }}" class="w-full sm:w-80">
            <div class="relative">
                <span class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none text-content-tertiary">
                    <x-ui.icon name="search" class="w-4 h-4" />
                </span>
                <input 
                    type="text" 
                    name="q" 
                    value="{{ $search }}"
                    placeholder="جستجو در رکوردها..."
                    class="w-full rounded-xl bg-surface-subtle border border-border-subtle focus:border-brand focus:ring-1 focus:ring-brand text-content-primary placeholder-content-tertiary text-xs ps-9 pe-3 py-2 outline-none"
                />
            </div>
        </form>

        <div class="text-xs text-content-tertiary">
            تعداد کل رکوردها: <span class="font-bold text-content-primary">{{ $items->total() }}</span>
        </div>
    </div>

    <!-- Data Table -->
    <div class="rounded-3xl bg-surface-card border border-border-subtle overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-start border-collapse text-sm">
                <thead>
                    <tr class="border-b border-border-subtle bg-surface-subtle/50 text-content-secondary text-xs">
                        @foreach ($config->columns() as $colKey => $colDef)
                            <th class="py-3.5 px-4 text-start font-semibold">
                                {{ $colDef['label'] }}
                            </th>
                        @endforeach
                        <th class="py-3.5 px-4 text-end font-semibold">عملیات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border-subtle">
                    @forelse ($items as $row)
                        <tr class="hover:bg-surface-subtle/40 transition-colors">
                            @foreach ($config->columns() as $colKey => $colDef)
                                <td class="py-3.5 px-4 text-content-primary">
                                    @if (isset($colDef['callback']))
                                        {!! $colDef['callback']($row) !!}
                                    @elseif ($colDef['type'] === 'boolean')
                                        @if ($row->{$colKey})
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium bg-success/10 text-success border border-success/20">
                                                بله
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium bg-surface-subtle text-content-tertiary">
                                                خیر
                                            </span>
                                        @endif
                                    @elseif ($colDef['type'] === 'badge')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-brand/10 text-brand">
                                            {{ $row->{$colKey} }}
                                        </span>
                                    @elseif ($colDef['type'] === 'date')
                                        <span class="text-xs text-content-tertiary">
                                            {{ $row->{$colKey} ? \App\Support\Jalali::fromDateTime($row->{$colKey}) : '-' }}
                                        </span>
                                    @else
                                        <span class="text-xs">{{ $row->{$colKey} }}</span>
                                    @endif
                                </td>
                            @endforeach

                            <td class="py-3.5 px-4 text-end">
                                <div class="inline-flex items-center gap-1.5">
                                    <a 
                                        href="{{ route('admin.crud.edit', ['resource' => $config->slug(), 'id' => $row->id]) }}"
                                        class="p-2 rounded-lg text-content-secondary hover:text-brand hover:bg-brand/10 transition-colors"
                                        title="ویرایش"
                                    >
                                        <x-ui.icon name="edit" class="w-4 h-4" />
                                    </a>

                                    <form 
                                        method="POST" 
                                        action="{{ route('admin.crud.destroy', ['resource' => $config->slug(), 'id' => $row->id]) }}"
                                        onsubmit="return confirm('آیا از حذف این مورد اطمینان دارید؟');"
                                        class="inline"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            type="submit" 
                                            class="p-2 rounded-lg text-content-secondary hover:text-danger hover:bg-danger/10 transition-colors"
                                            title="حذف"
                                        >
                                            <x-ui.icon name="trash" class="w-4 h-4" />
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ count($config->columns()) + 1 }}" class="py-12 text-center text-content-tertiary text-sm">
                                رکوردی یافت نشد.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($items->hasPages())
            <div class="p-4 border-t border-border-subtle bg-surface-subtle/30">
                {{ $items->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

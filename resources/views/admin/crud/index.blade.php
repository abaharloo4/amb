@extends('admin.layouts.app')

@section('title', $config->pluralLabel())
@section('header_title', $config->pluralLabel())

@section('content')
<div class="space-y-6 max-w-7xl mx-auto">
    <!-- Header / Actions -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-content-heading flex items-center gap-2.5">
                <x-ui.icon :name="$config->icon()" size="md" class="text-brand" />
                <span>{{ $config->pluralLabel() }}</span>
            </h1>
            <p class="text-xs text-content-secondary mt-1">
                مدیریت، ویرایش و مشاهده فهرست رکوردها
            </p>
        </div>

        <div class="flex items-center gap-3">
            <x-ui.button 
                as="a"
                href="{{ route('admin.crud.create', $config->slug()) }}"
                variant="accent"
                size="md"
                iconLeading="plus"
            >
                افزودن {{ $config->singularLabel() }} جدید
            </x-ui.button>
        </div>
    </div>

    <!-- Search & Filters Toolbar -->
    <x-ui.card class="p-4 flex flex-col sm:flex-row items-center justify-between gap-4">
        <form method="GET" action="{{ route('admin.crud.index', $config->slug()) }}" class="w-full sm:w-80">
            <x-ui.input 
                type="text" 
                name="q" 
                value="{{ $search }}"
                placeholder="جستجو در رکوردها..."
                iconLeading="search"
            />
        </form>

        <div class="text-xs text-content-secondary">
            تعداد کل رکوردها: <span class="font-bold text-content-heading font-mono">{{ $items->total() }}</span>
        </div>
    </x-ui.card>

    <!-- Data Table -->
    <x-ui.card class="overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-start border-collapse text-sm">
                <thead>
                    <tr class="border-b border-edge bg-surface-subtle/50 text-content-secondary text-xs">
                        @foreach ($config->columns() as $colKey => $colDef)
                            <th class="py-3.5 px-4 text-start font-semibold">
                                {{ $colDef['label'] }}
                            </th>
                        @endforeach
                        <th class="py-3.5 px-4 text-end font-semibold">عملیات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-edge">
                    @forelse ($items as $row)
                        <tr class="hover:bg-action-hover transition-colors">
                            @foreach ($config->columns() as $colKey => $colDef)
                                <td class="py-3.5 px-4 text-content-primary">
                                    @if (isset($colDef['callback']))
                                        {!! $colDef['callback']($row) !!}
                                    @elseif ($colDef['type'] === 'boolean')
                                        @if ($row->{$colKey})
                                            <x-ui.badge tone="success" size="sm">بله</x-ui.badge>
                                        @else
                                            <x-ui.badge tone="neutral" size="sm">خیر</x-ui.badge>
                                        @endif
                                    @elseif ($colDef['type'] === 'badge')
                                        <x-ui.badge tone="brand" size="sm">
                                            {{ $row->{$colKey} }}
                                        </x-ui.badge>
                                    @elseif ($colDef['type'] === 'date')
                                        <span class="text-xs font-mono text-content-secondary">
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
                                        class="p-2 rounded-md text-content-secondary hover:text-brand hover:bg-action-hover transition-colors"
                                        title="ویرایش"
                                    >
                                        <x-ui.icon name="pencil" size="xs" />
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
                                            class="p-2 rounded-md text-content-secondary hover:text-status-error hover:bg-status-error/10 transition-colors"
                                            title="حذف"
                                        >
                                            <x-ui.icon name="trash-2" size="xs" />
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ count($config->columns()) + 1 }}" class="py-12 text-center text-content-secondary text-sm">
                                رکوردی یافت نشد.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($items->hasPages())
            <div class="p-4 border-t border-edge bg-surface-subtle/30">
                {{ $items->links() }}
            </div>
        @endif
    </x-ui.card>
</div>
@endsection

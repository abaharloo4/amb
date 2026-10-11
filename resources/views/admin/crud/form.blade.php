@extends('admin.layouts.app')

@section('title', ($isEdit ? 'ویرایش ' : 'ایجاد ') . $config->singularLabel())
@section('header_title', ($isEdit ? 'ویرایش ' : 'افزودن ') . $config->singularLabel())

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Top Action bar -->
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a 
                href="{{ route('admin.crud.index', $config->slug()) }}"
                class="p-2 rounded-xl border border-border-subtle bg-surface-card text-content-secondary hover:text-content-primary transition-colors"
                title="بازگشت به فهرست"
            >
                <x-ui.icon name="arrow-right" class="w-4 h-4 rtl:block ltr:hidden" />
                <x-ui.icon name="arrow-left" class="w-4 h-4 ltr:block rtl:hidden" />
            </a>
            <div>
                <h1 class="text-xl font-bold text-content-primary">
                    {{ $isEdit ? 'ویرایش اطلاعات ' : 'ثبت ' }} {{ $config->singularLabel() }}
                </h1>
                <p class="text-xs text-content-secondary mt-0.5">
                    فیلدهای ستاره‌دار الزامی هستند.
                </p>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="rounded-3xl bg-surface-card border border-border-subtle p-6 md:p-8 shadow-sm">
        @if ($errors->any())
            <div class="mb-6 p-4 rounded-2xl bg-danger/10 border border-danger/20 text-danger text-sm">
                <div class="font-bold mb-1">خطا در اعتبارسنجی فرم:</div>
                <ul class="list-disc list-inside text-xs space-y-1">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form 
            method="POST" 
            action="{{ $isEdit ? route('admin.crud.update', ['resource' => $config->slug(), 'id' => $item->id]) : route('admin.crud.store', $config->slug()) }}"
            class="space-y-6"
        >
            @csrf
            @if ($isEdit)
                @method('PUT')
            @endif

            <div class="space-y-5">
                @foreach ($config->fields() as $fieldName => $fieldDef)
                    @php
                        $currentValue = old($fieldName);
                        if ($currentValue === null) {
                            if (! empty($fieldDef['is_translation'])) {
                                $currentValue = $item->translations?->firstWhere('locale', $fieldDef['locale'] ?? 'fa')?->{$fieldDef['field']} ?? '';
                            } else {
                                $currentValue = $item->{$fieldName} ?? ($fieldDef['default'] ?? '');
                            }
                        }
                    @endphp

                    <div>
                        @if ($fieldDef['type'] === 'checkbox')
                            <label class="flex items-center gap-3 cursor-pointer select-none">
                                <input 
                                    type="checkbox" 
                                    name="{{ $fieldName }}" 
                                    value="1"
                                    {{ $currentValue ? 'checked' : '' }}
                                    class="w-4 h-4 rounded border-border-subtle bg-surface-subtle text-brand focus:ring-brand"
                                />
                                <span class="text-sm font-medium text-content-primary">{{ $fieldDef['label'] }}</span>
                            </label>
                        @else
                            <label for="{{ $fieldName }}" class="block text-xs font-semibold text-content-secondary mb-1.5">
                                {{ $fieldDef['label'] }}
                                @if (str_contains($fieldDef['rules'] ?? '', 'required'))
                                    <span class="text-danger">*</span>
                                @endif
                            </label>

                            @if ($fieldDef['type'] === 'textarea' || $fieldDef['type'] === 'rich_text')
                                @if ($fieldDef['type'] === 'rich_text')
                                    <div class="border border-border-subtle rounded-xl overflow-hidden bg-surface-subtle" x-data="{
                                        format(cmd) {
                                            const textarea = $refs.editorText;
                                            const start = textarea.selectionStart;
                                            const end = textarea.selectionEnd;
                                            const text = textarea.value;
                                            const selected = text.substring(start, end);
                                            let replacement = '';
                                            if (cmd === 'b') replacement = `**${selected || 'متن برجسته'}**`;
                                            if (cmd === 'i') replacement = `*${selected || 'متن مورب'}*`;
                                            if (cmd === 'h2') replacement = `\n## ${selected || 'عنوان بخش'}\n`;
                                            if (cmd === 'quote') replacement = `\n> ${selected || 'نقل قول'}\n`;
                                            if (cmd === 'code') replacement = `\n\`\`\`\n${selected || 'کد'}\n\`\`\`\n`;
                                            textarea.setRangeText(replacement, start, end, 'end');
                                            textarea.dispatchEvent(new Event('input'));
                                        }
                                    }">
                                        <div class="flex items-center gap-1 p-2 border-b border-border-subtle bg-surface-base/60 text-xs">
                                            <button type="button" @click="format('b')" class="px-2.5 py-1 rounded bg-surface-subtle hover:bg-surface-card font-bold" title="برجسته">B</button>
                                            <button type="button" @click="format('i')" class="px-2.5 py-1 rounded bg-surface-subtle hover:bg-surface-card italic" title="مورب">I</button>
                                            <button type="button" @click="format('h2')" class="px-2.5 py-1 rounded bg-surface-subtle hover:bg-surface-card font-bold" title="سرتیتر H2">H2</button>
                                            <button type="button" @click="format('quote')" class="px-2.5 py-1 rounded bg-surface-subtle hover:bg-surface-card" title="نقل قول">”</button>
                                            <button type="button" @click="format('code')" class="px-2.5 py-1 rounded bg-surface-subtle hover:bg-surface-card font-mono" title="کد">&lt;/&gt;</button>
                                        </div>
                                        <textarea 
                                            x-ref="editorText"
                                            id="{{ $fieldName }}"
                                            name="{{ $fieldName }}"
                                            rows="8"
                                            class="w-full bg-transparent border-0 focus:ring-0 text-content-primary p-3 text-sm outline-none font-sans"
                                        >{{ $currentValue }}</textarea>
                                    </div>
                                @else
                                    <textarea 
                                        id="{{ $fieldName }}"
                                        name="{{ $fieldName }}"
                                        rows="5"
                                        class="w-full rounded-xl bg-surface-subtle border border-border-subtle focus:border-brand focus:ring-1 focus:ring-brand text-content-primary p-3 text-sm outline-none"
                                    >{{ $currentValue }}</textarea>
                                @endif

                            @elseif ($fieldDef['type'] === 'select')
                                <select 
                                    id="{{ $fieldName }}"
                                    name="{{ $fieldName }}"
                                    class="w-full rounded-xl bg-surface-subtle border border-border-subtle focus:border-brand focus:ring-1 focus:ring-brand text-content-primary p-2.5 text-sm outline-none"
                                >
                                    @foreach ($fieldDef['options'] ?? [] as $optKey => $optLabel)
                                        <option value="{{ $optKey }}" {{ (string)$currentValue === (string)$optKey ? 'selected' : '' }}>
                                            {{ $optLabel }}
                                        </option>
                                    @endforeach
                                </select>

                            @else
                                <input 
                                    type="{{ $fieldDef['type'] ?? 'text' }}"
                                    id="{{ $fieldName }}"
                                    name="{{ $fieldName }}"
                                    value="{{ $currentValue }}"
                                    class="w-full rounded-xl bg-surface-subtle border border-border-subtle focus:border-brand focus:ring-1 focus:ring-brand text-content-primary px-3.5 py-2.5 text-sm outline-none"
                                />
                            @endif
                        @endif

                        @if (! empty($fieldDef['help']))
                            <p class="text-[11px] text-content-tertiary mt-1">{{ $fieldDef['help'] }}</p>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- Submit Buttons -->
            <div class="pt-6 border-t border-border-subtle flex items-center justify-end gap-3">
                <a 
                    href="{{ route('admin.crud.index', $config->slug()) }}"
                    class="px-5 py-2.5 rounded-xl border border-border-subtle text-content-secondary hover:text-content-primary text-sm font-medium transition-colors"
                >
                    انصراف
                </a>

                <button 
                    type="submit"
                    class="px-6 py-2.5 rounded-xl bg-brand text-white font-medium text-sm shadow-glow hover:opacity-95 transition-all flex items-center gap-2"
                >
                    <x-ui.icon name="check" class="w-4 h-4" />
                    <span>{{ $isEdit ? 'ذخیره تغییرات' : 'ثبت و ایجاد' }}</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

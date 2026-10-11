<?php

namespace App\Admin\Crud\Resources;

use App\Admin\Crud\ResourceConfig;
use App\Models\Experience;

class ExperienceResource extends ResourceConfig
{
    public function slug(): string
    {
        return 'experiences';
    }

    public function model(): string
    {
        return Experience::class;
    }

    public function singularLabel(): string
    {
        return 'سابقه کاری';
    }

    public function pluralLabel(): string
    {
        return 'سوابق شغلی و تجربیات';
    }

    public function icon(): string
    {
        return 'calendar';
    }

    public function navigationGroup(): string
    {
        return 'رزومه و سوابق';
    }

    public function navigationSort(): int
    {
        return 4;
    }

    public function columns(): array
    {
        return [
            'id' => [
                'label' => '#',
                'sortable' => true,
                'type' => 'text',
            ],
            'company' => [
                'label' => 'سازمان / شرکت',
                'sortable' => false,
                'type' => 'text',
                'callback' => fn ($item) => $item->translations->firstWhere('locale', 'fa')?->company ?? $item->id,
            ],
            'role' => [
                'label' => 'عنوان موقعیت شغلی',
                'sortable' => false,
                'type' => 'text',
                'callback' => fn ($item) => $item->translations->firstWhere('locale', 'fa')?->role ?? '',
            ],
            'start_date' => [
                'label' => 'تاریخ شروع',
                'sortable' => true,
                'type' => 'date',
            ],
            'is_current' => [
                'label' => 'مشغول به کار',
                'sortable' => true,
                'type' => 'boolean',
            ],
        ];
    }

    public function fields(): array
    {
        return [
            'company_fa' => [
                'label' => 'نام سازمان / کارفرما (فارسی)',
                'type' => 'text',
                'rules' => 'required|string|max:255',
                'is_translation' => true,
                'locale' => 'fa',
                'field' => 'company',
            ],
            'role_fa' => [
                'label' => 'سمت / عنوان شغلی (فارسی)',
                'type' => 'text',
                'rules' => 'required|string|max:255',
                'is_translation' => true,
                'locale' => 'fa',
                'field' => 'role',
            ],
            'start_date' => [
                'label' => 'تاریخ شروع (YYYY-MM-DD)',
                'type' => 'text',
                'rules' => 'required|date',
                'placeholder' => '2023-01-01',
            ],
            'end_date' => [
                'label' => 'تاریخ پایان (YYYY-MM-DD)',
                'type' => 'text',
                'rules' => 'nullable|date',
                'placeholder' => '2025-01-01',
            ],
            'is_current' => [
                'label' => 'همچنان در این موقعیت مشغول به کار هستم',
                'type' => 'checkbox',
                'rules' => 'boolean',
                'default' => false,
            ],
            'order' => [
                'label' => 'ترتیب نمایش',
                'type' => 'number',
                'rules' => 'nullable|integer',
                'default' => 0,
            ],
            'description_fa' => [
                'label' => 'شرح وظایف و دستاوردها (فارسی)',
                'type' => 'textarea',
                'rules' => 'nullable|string',
                'is_translation' => true,
                'locale' => 'fa',
                'field' => 'description',
            ],
        ];
    }
}

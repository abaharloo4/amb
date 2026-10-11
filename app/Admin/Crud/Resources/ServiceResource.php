<?php

namespace App\Admin\Crud\Resources;

use App\Admin\Crud\ResourceConfig;
use App\Models\Service;

class ServiceResource extends ResourceConfig
{
    public function slug(): string
    {
        return 'services';
    }

    public function model(): string
    {
        return Service::class;
    }

    public function singularLabel(): string
    {
        return 'خدمت تخصصی';
    }

    public function pluralLabel(): string
    {
        return 'خدمات و راهکارها';
    }

    public function icon(): string
    {
        return 'layers';
    }

    public function navigationGroup(): string
    {
        return 'خدمات و قابلیت‌ها';
    }

    public function navigationSort(): int
    {
        return 2;
    }

    public function columns(): array
    {
        return [
            'id' => [
                'label' => '#',
                'sortable' => true,
                'type' => 'text',
            ],
            'title' => [
                'label' => 'عنوان خدمت',
                'sortable' => false,
                'type' => 'text',
                'callback' => fn ($item) => $item->translations->firstWhere('locale', 'fa')?->title ?? $item->id,
            ],
            'icon' => [
                'label' => 'آیکون',
                'sortable' => false,
                'type' => 'text',
            ],
            'featured' => [
                'label' => 'ویژه در صفحه اصلی',
                'sortable' => true,
                'type' => 'boolean',
            ],
            'status' => [
                'label' => 'وضعیت',
                'sortable' => true,
                'type' => 'badge',
            ],
        ];
    }

    public function fields(): array
    {
        return [
            'icon' => [
                'label' => 'شناسه آیکون SVG (مثال: cpu, sparkles, layers)',
                'type' => 'text',
                'rules' => 'required|string|max:50',
                'default' => 'layers',
            ],
            'order' => [
                'label' => 'ترتیب نمایش',
                'type' => 'number',
                'rules' => 'nullable|integer',
                'default' => 0,
            ],
            'featured' => [
                'label' => 'نمایش در صفحه اصلی',
                'type' => 'checkbox',
                'rules' => 'boolean',
                'default' => true,
            ],
            'is_demo' => [
                'label' => 'محتوای آزمایشی (Demo)',
                'type' => 'checkbox',
                'rules' => 'boolean',
                'default' => false,
            ],
            'status' => [
                'label' => 'وضعیت انتشار',
                'type' => 'select',
                'rules' => 'required|in:draft,published,archived',
                'options' => [
                    'published' => 'منتشر شده',
                    'draft' => 'پیش‌نویس',
                    'archived' => 'آرشیو شده',
                ],
                'default' => 'published',
            ],
            'title_fa' => [
                'label' => 'عنوان خدمت (فارسی)',
                'type' => 'text',
                'rules' => 'required|string|max:255',
                'is_translation' => true,
                'locale' => 'fa',
                'field' => 'title',
            ],
            'slug_fa' => [
                'label' => 'اسلاگ انگلیسی (Slug)',
                'type' => 'text',
                'rules' => 'required|string|max:255',
                'is_translation' => true,
                'locale' => 'fa',
                'field' => 'slug',
            ],
            'summary_fa' => [
                'label' => 'خلاصه کوتاه (فارسی)',
                'type' => 'textarea',
                'rules' => 'required|string|max:500',
                'is_translation' => true,
                'locale' => 'fa',
                'field' => 'summary',
            ],
            'description_fa' => [
                'label' => 'توضیحات و شرح کامل فرآیند (فارسی)',
                'type' => 'textarea',
                'rules' => 'nullable|string',
                'is_translation' => true,
                'locale' => 'fa',
                'field' => 'description',
            ],
        ];
    }
}

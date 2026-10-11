<?php

namespace App\Admin\Crud\Resources;

use App\Admin\Crud\ResourceConfig;
use App\Models\Project;

class ProjectResource extends ResourceConfig
{
    public function slug(): string
    {
        return 'projects';
    }

    public function model(): string
    {
        return Project::class;
    }

    public function singularLabel(): string
    {
        return 'پروژه';
    }

    public function pluralLabel(): string
    {
        return 'پروژه‌ها';
    }

    public function icon(): string
    {
        return 'folder';
    }

    public function navigationGroup(): string
    {
        return 'پرتفولیو و نمونه‌کار';
    }

    public function navigationSort(): int
    {
        return 1;
    }

    public function searchableColumns(): array
    {
        return ['slug'];
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
                'label' => 'عنوان پروژه',
                'sortable' => false,
                'type' => 'text',
                'callback' => fn ($item) => $item->translations->firstWhere('locale', 'fa')?->title ?? $item->slug,
            ],
            'slug' => [
                'label' => 'اسلاگ (URL)',
                'sortable' => true,
                'type' => 'text',
            ],
            'featured' => [
                'label' => 'ویژه',
                'sortable' => true,
                'type' => 'boolean',
            ],
            'is_demo' => [
                'label' => 'آزمایشی (Demo)',
                'sortable' => true,
                'type' => 'boolean',
            ],
            'published_at' => [
                'label' => 'تاریخ انتشار',
                'sortable' => true,
                'type' => 'date',
            ],
        ];
    }

    public function fields(): array
    {
        return [
            'slug' => [
                'label' => 'اسلاگ انگلیسی (Slug)',
                'type' => 'text',
                'rules' => 'required|string|max:255',
                'help' => 'شناسه یکتا برای نشانی اینترنتی (مثال: modern-fintech-app)',
            ],
            'order' => [
                'label' => 'ترتیب نمایش',
                'type' => 'number',
                'rules' => 'nullable|integer',
                'default' => 0,
            ],
            'featured' => [
                'label' => 'نمایش در پروژه‌های برگزیده (Featured)',
                'type' => 'checkbox',
                'rules' => 'boolean',
                'default' => false,
            ],
            'is_demo' => [
                'label' => 'محتوای آزمایشی (Demo Badge)',
                'type' => 'checkbox',
                'rules' => 'boolean',
                'default' => false,
            ],
            'website_url' => [
                'label' => 'آدرس وبسایت پروژه (URL)',
                'type' => 'text',
                'rules' => 'nullable|url|max:255',
            ],
            'github_url' => [
                'label' => 'ریپازیتوری سورس کد (GitHub)',
                'type' => 'text',
                'rules' => 'nullable|url|max:255',
            ],
            'title_fa' => [
                'label' => 'عنوان پروژه (فارسی)',
                'type' => 'text',
                'rules' => 'required|string|max:255',
                'is_translation' => true,
                'locale' => 'fa',
                'field' => 'title',
            ],
            'summary_fa' => [
                'label' => 'خلاصه کوتاه (فارسی)',
                'type' => 'textarea',
                'rules' => 'nullable|string|max:500',
                'is_translation' => true,
                'locale' => 'fa',
                'field' => 'summary',
            ],
            'body_fa' => [
                'label' => 'شرح کامل کیس‌استادی (فارسی)',
                'type' => 'textarea',
                'rules' => 'nullable|string',
                'is_translation' => true,
                'locale' => 'fa',
                'field' => 'body',
            ],
        ];
    }
}

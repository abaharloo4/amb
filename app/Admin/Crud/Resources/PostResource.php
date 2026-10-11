<?php

namespace App\Admin\Crud\Resources;

use App\Admin\Crud\ResourceConfig;
use App\Models\Post;

class PostResource extends ResourceConfig
{
    public function slug(): string
    {
        return 'posts';
    }

    public function model(): string
    {
        return Post::class;
    }

    public function singularLabel(): string
    {
        return 'مقاله';
    }

    public function pluralLabel(): string
    {
        return 'مقالات بلاگ';
    }

    public function icon(): string
    {
        return 'book-open';
    }

    public function navigationGroup(): string
    {
        return 'محتوا و وبلاگ';
    }

    public function navigationSort(): int
    {
        return 2;
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
                'label' => 'عنوان مقاله',
                'sortable' => false,
                'type' => 'text',
                'callback' => fn ($item) => $item->translations->firstWhere('locale', 'fa')?->title ?? $item->slug,
            ],
            'slug' => [
                'label' => 'اسلاگ',
                'sortable' => true,
                'type' => 'text',
            ],
            'status' => [
                'label' => 'وضعیت',
                'sortable' => true,
                'type' => 'badge',
            ],
            'views_count' => [
                'label' => 'بازدید',
                'sortable' => true,
                'type' => 'text',
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
                'label' => 'اسلاگ مقاله',
                'type' => 'text',
                'rules' => 'required|string|max:255',
            ],
            'status' => [
                'label' => 'وضعیت انتشار',
                'type' => 'select',
                'rules' => 'required|in:draft,published,archived',
                'options' => [
                    'draft' => 'پیش‌نویس',
                    'published' => 'منتشر شده',
                    'archived' => 'آرشیو شده',
                ],
                'default' => 'draft',
            ],
            'title_fa' => [
                'label' => 'عنوان مقاله (فارسی)',
                'type' => 'text',
                'rules' => 'required|string|max:255',
                'is_translation' => true,
                'locale' => 'fa',
                'field' => 'title',
            ],
            'summary_fa' => [
                'label' => 'خلاصه مقاله (فارسی)',
                'type' => 'textarea',
                'rules' => 'nullable|string|max:500',
                'is_translation' => true,
                'locale' => 'fa',
                'field' => 'summary',
            ],
            'body_fa' => [
                'label' => 'متن کامل مقاله (فارسی)',
                'type' => 'textarea',
                'rules' => 'nullable|string',
                'is_translation' => true,
                'locale' => 'fa',
                'field' => 'body',
            ],
        ];
    }
}

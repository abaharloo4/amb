<?php

namespace App\Admin\Crud\Resources;

use App\Admin\Crud\ResourceConfig;
use App\Models\Inquiry;

class InquiryResource extends ResourceConfig
{
    public function slug(): string
    {
        return 'inquiries';
    }

    public function model(): string
    {
        return Inquiry::class;
    }

    public function singularLabel(): string
    {
        return 'پیام / استعلام';
    }

    public function pluralLabel(): string
    {
        return 'صندوق پیام‌ها و استعلام‌ها';
    }

    public function icon(): string
    {
        return 'mail';
    }

    public function navigationGroup(): string
    {
        return 'ارتباطات و درخواست‌ها';
    }

    public function navigationSort(): int
    {
        return 3;
    }

    public function searchableColumns(): array
    {
        return ['name', 'email', 'phone', 'subject'];
    }

    public function columns(): array
    {
        return [
            'id' => [
                'label' => '#',
                'sortable' => true,
                'type' => 'text',
            ],
            'name' => [
                'label' => 'نام فرستنده',
                'sortable' => true,
                'type' => 'text',
            ],
            'email' => [
                'label' => 'ایمیل',
                'sortable' => true,
                'type' => 'text',
            ],
            'subject' => [
                'label' => 'موضوع',
                'sortable' => false,
                'type' => 'text',
            ],
            'status' => [
                'label' => 'وضعیت',
                'sortable' => true,
                'type' => 'badge',
            ],
            'created_at' => [
                'label' => 'تاریخ دریافت',
                'sortable' => true,
                'type' => 'date',
            ],
        ];
    }

    public function fields(): array
    {
        return [
            'name' => [
                'label' => 'نام فرستنده',
                'type' => 'text',
                'rules' => 'required|string|max:255',
            ],
            'email' => [
                'label' => 'ایمیل',
                'type' => 'email',
                'rules' => 'required|email|max:255',
            ],
            'phone' => [
                'label' => 'شماره تماس',
                'type' => 'text',
                'rules' => 'nullable|string|max:50',
            ],
            'subject' => [
                'label' => 'موضوع',
                'type' => 'text',
                'rules' => 'nullable|string|max:255',
            ],
            'status' => [
                'label' => 'وضعیت رسیدگی',
                'type' => 'select',
                'rules' => 'required|in:new,in_review,replied,closed,spam',
                'options' => [
                    'new' => 'جدید',
                    'in_review' => 'در حال بررسی',
                    'replied' => 'پاسخ داده شده',
                    'closed' => 'بسته شده',
                    'spam' => 'اسپم',
                ],
                'default' => 'new',
            ],
            'message' => [
                'label' => 'متن پیام فرستنده',
                'type' => 'textarea',
                'rules' => 'required|string',
            ],
        ];
    }
}

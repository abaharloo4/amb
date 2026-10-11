<?php

namespace App\Admin\Crud\Resources;

use App\Admin\Crud\ResourceConfig;
use App\Models\Appointment;

class AppointmentResource extends ResourceConfig
{
    public function slug(): string
    {
        return 'appointments';
    }

    public function model(): string
    {
        return Appointment::class;
    }

    public function singularLabel(): string
    {
        return 'جلسه رزرو شده';
    }

    public function pluralLabel(): string
    {
        return 'جلسات و مشاوره‌ها';
    }

    public function icon(): string
    {
        return 'calendar';
    }

    public function navigationGroup(): string
    {
        return 'ارتباطات و درخواست‌ها';
    }

    public function navigationSort(): int
    {
        return 4;
    }

    public function searchableColumns(): array
    {
        return ['client_name', 'client_email', 'client_phone'];
    }

    public function columns(): array
    {
        return [
            'id' => [
                'label' => '#',
                'sortable' => true,
                'type' => 'text',
            ],
            'client_name' => [
                'label' => 'نام متقاضی',
                'sortable' => true,
                'type' => 'text',
            ],
            'client_email' => [
                'label' => 'ایمیل',
                'sortable' => true,
                'type' => 'text',
            ],
            'client_phone' => [
                'label' => 'شماره تماس',
                'sortable' => false,
                'type' => 'text',
            ],
            'start_time' => [
                'label' => 'زمان شروع جلسه',
                'sortable' => true,
                'type' => 'date',
            ],
            'status' => [
                'label' => 'وضعیت جلسه',
                'sortable' => true,
                'type' => 'badge',
            ],
        ];
    }

    public function fields(): array
    {
        return [
            'client_name' => [
                'label' => 'نام متقاضی',
                'type' => 'text',
                'rules' => 'required|string|max:255',
            ],
            'client_email' => [
                'label' => 'ایمیل',
                'type' => 'email',
                'rules' => 'required|email|max:255',
            ],
            'client_phone' => [
                'label' => 'شماره تماس',
                'type' => 'text',
                'rules' => 'nullable|string|max:50',
            ],
            'start_time' => [
                'label' => 'زمان شروع جلسه',
                'type' => 'text',
                'rules' => 'required|date',
            ],
            'end_time' => [
                'label' => 'زمان پایان جلسه',
                'type' => 'text',
                'rules' => 'required|date',
            ],
            'status' => [
                'label' => 'وضعیت جلسه',
                'type' => 'select',
                'rules' => 'required|in:pending,confirmed,cancelled,completed',
                'options' => [
                    'pending' => 'در انتظار تایید',
                    'confirmed' => 'تایید شده',
                    'cancelled' => 'لغو شده',
                    'completed' => 'برگزار شده',
                ],
                'default' => 'pending',
            ],
            'notes' => [
                'label' => 'توضیحات و یادداشت جلسه',
                'type' => 'textarea',
                'rules' => 'nullable|string',
            ],
        ];
    }
}

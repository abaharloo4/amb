<?php

namespace App\Admin\Crud;

abstract class ResourceConfig
{
    /**
     * The unique resource slug (e.g. 'projects', 'posts')
     */
    abstract public function slug(): string;

    /**
     * Eloquent Model class
     */
    abstract public function model(): string;

    /**
     * Singular label for UI (Persian/English)
     */
    abstract public function singularLabel(): string;

    /**
     * Plural label for UI
     */
    abstract public function pluralLabel(): string;

    /**
     * Icon name from SVG sprite
     */
    public function icon(): string
    {
        return 'folder';
    }

    /**
     * Navigation group (e.g. 'پرتفولیو', 'محتوا', 'ارتباطات', 'سیستم')
     */
    public function navigationGroup(): string
    {
        return 'عمومی';
    }

    /**
     * Navigation display order
     */
    public function navigationSort(): int
    {
        return 10;
    }

    /**
     * Columns visible in the index table
     * Format: [ 'key' => [ 'label' => 'عنوان', 'sortable' => true, 'type' => 'text|badge|image|date|boolean', 'callback' => fn($row) => ... ] ]
     */
    abstract public function columns(): array;

    /**
     * Form fields for create/edit
     * Format: [ 'name' => [ 'label' => '...', 'type' => 'text|textarea|rich_text|select|checkbox|file', 'rules' => '...', 'options' => [...] ] ]
     */
    abstract public function fields(): array;

    /**
     * Filterable fields
     */
    public function filters(): array
    {
        return [];
    }

    /**
     * Searchable columns
     */
    public function searchableColumns(): array
    {
        return ['id'];
    }

    /**
     * Default order by column and direction
     */
    public function defaultOrder(): array
    {
        return ['column' => 'id', 'direction' => 'desc'];
    }

    /**
     * Items per page
     */
    public function perPage(): int
    {
        return 15;
    }

    /**
     * Determine if user can perform action
     */
    public function can(string $action): bool
    {
        return true;
    }
}

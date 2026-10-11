<?php

namespace App\Admin\Crud;

use Exception;
use Illuminate\Support\Collection;

class ResourceManager
{
    /**
     * @var array<string, ResourceConfig>
     */
    protected array $resources = [];

    /**
     * Register a resource config instance
     */
    public function register(ResourceConfig $resource): self
    {
        $this->resources[$resource->slug()] = $resource;
        return $this;
    }

    /**
     * Get a resource by its slug
     */
    public function get(string $slug): ResourceConfig
    {
        if (! isset($this->resources[$slug])) {
            throw new Exception("Resource '{$slug}' is not registered.");
        }

        return $this->resources[$slug];
    }

    /**
     * Check if a resource is registered
     */
    public function has(string $slug): bool
    {
        return isset($this->resources[$slug]);
    }

    /**
     * Get all registered resources
     *
     * @return Collection<string, ResourceConfig>
     */
    public function all(): Collection
    {
        return collect($this->resources)->sortBy(fn (ResourceConfig $r) => $r->navigationSort());
    }

    /**
     * Group resources by navigation group
     */
    public function navigationGroups(): Collection
    {
        return $this->all()->groupBy(fn (ResourceConfig $r) => $r->navigationGroup());
    }
}

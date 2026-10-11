<?php

namespace App\Providers;

use App\Admin\Crud\ResourceManager;
use App\Admin\Crud\Resources\ProjectResource;
use App\Admin\Crud\Resources\PostResource;
use App\Admin\Crud\Resources\InquiryResource;
use App\Admin\Crud\Resources\ServiceResource;
use App\Admin\Crud\Resources\ExperienceResource;
use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(ResourceManager::class, function ($app) {
            $manager = new ResourceManager();
            $manager->register(new ProjectResource());
            $manager->register(new ServiceResource());
            $manager->register(new PostResource());
            $manager->register(new ExperienceResource());
            $manager->register(new InquiryResource());
            return $manager;
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

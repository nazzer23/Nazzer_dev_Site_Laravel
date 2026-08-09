<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\GithubProject;
use App\Models\Project;
use App\Models\ProjectUpdate;
use App\Models\Skill;
use App\Observers\AuditObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Project::observe(AuditObserver::class);
        ProjectUpdate::observe(AuditObserver::class);
        Category::observe(AuditObserver::class);
        GithubProject::observe(AuditObserver::class);
        Skill::observe(AuditObserver::class);
    }
}

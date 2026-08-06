<?php

use App\Http\Controllers\SitemapController;
use App\Livewire\Admin\AuditLog\Index as AdminAuditLogIndex;
use App\Livewire\Admin\Categories\Index as AdminCategoriesIndex;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Admin\Projects\Create as AdminProjectsCreate;
use App\Livewire\Admin\Projects\Edit as AdminProjectsEdit;
use App\Livewire\Admin\Projects\Index as AdminProjectsIndex;
use App\Livewire\Admin\Repos\Index as AdminReposIndex;
use App\Livewire\Admin\Skills\Index as AdminSkillsIndex;
use App\Livewire\Contact;
use App\Livewire\Homepage;
use App\Livewire\ProjectShow;
use Illuminate\Support\Facades\Route;

Route::livewire('/', Homepage::class)->name('home');

Route::livewire('/projects/{project}', ProjectShow::class)->name('projects.show');

Route::livewire('/contact', Contact::class)->name('contact');

Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');

Route::get('/robots.txt', function () {
    return response()
        ->view('robots', [], 200)
        ->header('Content-Type', 'text/plain');
})->name('robots');

Route::livewire('dashboard', AdminDashboard::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::livewire('/projects', AdminProjectsIndex::class)->name('projects.index');
    Route::livewire('/projects/create', AdminProjectsCreate::class)->name('projects.create');
    Route::livewire('/projects/{project}/edit', AdminProjectsEdit::class)->name('projects.edit');
    Route::livewire('/repos', AdminReposIndex::class)->name('repos.index');
    Route::livewire('/categories', AdminCategoriesIndex::class)->name('categories.index');
    Route::livewire('/skills', AdminSkillsIndex::class)->name('skills.index');
    Route::livewire('/audit-log', AdminAuditLogIndex::class)->name('audit-log.index');
});

require __DIR__.'/auth.php';

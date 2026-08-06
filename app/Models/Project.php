<?php

namespace App\Models;

use App\Enums\ProjectStatus;
use Database\Factories\ProjectFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Project extends Model
{
    /** @use HasFactory<ProjectFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'summary',
        'body',
        'status',
        'url',
    ];

    protected $casts = [
        'status' => ProjectStatus::class,
    ];

    protected static function booted(): void
    {
        static::saving(function (Project $project): void {
            if (blank($project->slug)) {
                $project->slug = self::uniqueSlugFor($project->title, $project->id);
            }
        });
    }

    private static function uniqueSlugFor(string $title, ?int $ignoreId): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $suffix = 2;

        while (
            static::query()
                ->where('slug', $slug)
                ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = "{$base}-{$suffix}";
            $suffix++;
        }

        return $slug;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * @return HasMany<ProjectUpdate, $this>
     */
    public function updates(): HasMany
    {
        return $this->hasMany(ProjectUpdate::class)->latest();
    }

    /**
     * @return BelongsToMany<GithubProject, $this>
     */
    public function githubProjects(): BelongsToMany
    {
        return $this->belongsToMany(GithubProject::class);
    }
}

<?php

namespace App\Models;

use Database\Factories\GithubProjectFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class GithubProject extends Model
{
    /** @use HasFactory<GithubProjectFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'github_projects';

    protected $fillable = [
        "github_id",
        "name",
        "full_name",
        "language",
        "html_url",
        "description",
        "repo_pushed_at",
        "repo_created_at",
        "flag_fork",
        "stargazers_count",
        "forks_count",
        "topics",
    ];

    protected $casts = [
        "repo_pushed_at" => "datetime",
        "repo_created_at" => "datetime",
        "stargazers_count" => "integer",
        "forks_count" => "integer",
        "topics" => "array",
    ];

    /**
     * @return BelongsToMany<Category, $this>
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * @return BelongsToMany<Project, $this>
     */
    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class);
    }
}

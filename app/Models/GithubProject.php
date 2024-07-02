<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GithubProject extends Model
{
    use SoftDeletes;

    protected $table = 'github_projects';

    protected $fillable = [
        "github_id",
        "name",
        "full_name",
        "language",
        "html_url",
        "description",
        "repo_pushed_at",
        "repo_created_at"
    ];

    protected $casts = [
        "repo_pushed_at" => "datetime",
        "repo_created_at" => "datetime",
    ];
}

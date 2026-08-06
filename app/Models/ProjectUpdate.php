<?php

namespace App\Models;

use Database\Factories\ProjectUpdateFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProjectUpdate extends Model
{
    /** @use HasFactory<ProjectUpdateFactory> */
    use HasFactory;

    protected $fillable = [
        'project_id',
        'title',
        'body',
    ];

    /**
     * @return BelongsTo<Project, $this>
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * @return HasMany<ProjectUpdateImage, $this>
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProjectUpdateImage::class)->orderBy('sort_order');
    }
}

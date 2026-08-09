<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class ProjectUpdateImage extends Model
{
    protected $fillable = [
        'project_update_id',
        'path',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function url(): string
    {
        return Storage::disk('public')->url($this->path);
    }

    /**
     * @return BelongsTo<ProjectUpdate, $this>
     */
    public function projectUpdate(): BelongsTo
    {
        return $this->belongsTo(ProjectUpdate::class);
    }
}

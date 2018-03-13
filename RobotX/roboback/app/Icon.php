<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Icon extends Model
{
    protected $fillable = [
        'name',
        'type',
        'icon',
        'description'
    ];

    /**
     * Get the projects of this icon
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projects() {
        return $this->belongsToMany(Project::class);
    }
}

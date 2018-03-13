<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Behavior extends Model
{
    protected $fillable = [
        'name',
        'icon',
        'slug',
        'behaviortype',
        'description',
        'basemenu',
        'language',
        'sayanimation',
        'voicecommands'
    ];

    /**
     * Get the behaviors of this project
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projects() {
        return $this->belongsToMany(Project::class)->withPivot('order');
    }

    /**
     * Get the texts of this project
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function texts() {
        return $this->belongsToMany(Text::class)->withPivot('order');
    }

    public function robots() {
        return $this->belongsToMany(Robot::class)->withPivot('order');
    }

    public function icondata() {
        return $this->hasOne(Icon::class, 'id', 'icon');
    }

    public function createdDate() {
        $thedate = Carbon::instance($this->created_at);
        if ($thedate->year == -1)
        {
            return("00-00-0000 00:00:00");
        }
        return $thedate->formatLocalized('%d-%m-%Y %H:%M:%S');
    }

    public function updatedDate() {
        $thedate = Carbon::instance($this->updated_at);
        if ($thedate->year == -1)
        {
            return("00-00-0000 00:00:00");
        }
        return $thedate->formatLocalized('%d-%m-%Y %H:%M:%S');
    }
}

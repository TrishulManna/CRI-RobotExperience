<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Text extends Model
{
    protected $fillable = [
        'id',
        'name',
        'icon',
        'text',
        'description',
        'basemenu',
        'language',
        'voicecommands',
        'animations'
    ];

    /**
     * Get the projects of this text
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projects() {
        return $this->belongsToMany(Project::class);
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

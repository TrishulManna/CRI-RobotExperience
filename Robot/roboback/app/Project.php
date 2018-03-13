<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;

class Project extends Model
{
    protected $fillable = [
        'name',
        'start_time',
        'image',
        'picture',
        'imgtype',
        'bhv_dance_menu',
        'text_dance_menu',
        'bhv_greetings_menu',
        'text_greetings_menu',
        'bhv_interaction_menu',
        'text_interaction_menu',
        'bhv_presentation_menu',
        'text_presentation_menu'
    ];

    /**
     * Get the behaviors of this project
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function behaviors() {
        return $this->belongsToMany(Behavior::class, "behavior_project")->withPivot('order')->orderBy("order", "asc");
    }

    /**
     * Get the texts of this project
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function texts() {
        return $this->belongsToMany(Text::class, "project_text")->withPivot('order')->orderBy("order", "asc");
    }

    public function copy() {
        $data = array(
            'name'       => $this['name'].' Copy',
            'start_time' => $this['start_time'],
            'image'      => $this['image']
        );
        return $data;
    }

    public function getImage()
    {
        if (!$this->image) {
            // return 'https://placeholdit.imgix.net/~text?txtsize=33&txt=No+image&w=350&h=200&txttrack=0';
            return URL::asset('/images/no-image.png');
        }
        if (!is_null($this->picture)) {
            return 'data:image/' . $this->imgtype . ';base64,' . $this->picture;
        }
        return URL::asset('/data/' . $this->image);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Robot extends Model
{
    protected $fillable = [
        'name',
        'type',
        'version',
        'ostype',
        'osversion',
        'description'
    ];


    public $robots = [ [
            'type' => 'Pepper',
            'name' => 'Pepper T14 (MP)',
            'version' => 'T14 (MP)',
            'ostype' => 'NAOqi',
            'osversion' => '2.5.5',
        ], [
            'type' => 'Pepper',
            'name' => 'Pepper Y20 (MP)',
            'version' => 'Y20 (MP)',
            'ostype' => 'NAOqi',
            'osversion' => '2.5.5',
        ], [
            'type' => 'NAO',
            'name' => 'NAO H21 (V32)',
            'version' => 'H21 (V32)',
            'ostype' => 'NAOqi',
            'osversion' => '2.1.4.13',
        ], [
            'type' => 'NAO',
            'name' => 'NAO H21 (V33)',
            'version' => 'H21 (V33)',
            'ostype' => 'NAOqi',
            'osversion' => '2.1.4.13',
        ], [
            'type' => 'NAO',
            'name' => 'NAO H21 (V40)',
            'version' => 'H21 (V40)',
            'ostype' => 'NAOqi',
            'osversion' => '2.1.4.13',
        ], [
            'type' => 'NAO',
            'name' => 'NAO H25 (V32)',
            'version' => 'H25 (V32)',
            'ostype' => 'NAOqi',
            'osversion' => '2.1.4.13',
        ], [
            'type' => 'NAO',
            'name' => 'NAO H25 (V33)',
            'version' => 'H25 (V33)',
            'ostype' => 'NAOqi',
            'osversion' => '2.1.4.13',
        ], [
            'type' => 'NAO',
            'name' => 'NAO H25 (V40)',
            'version' => 'H25 (V40)',
            'ostype' => 'NAOqi',
            'osversion' => '2.1.4.13',
        ], [
            'type' => 'NAO',
            'name' => 'NAO H25 (V40)',
            'version' => 'H25 (V50)',
            'ostype' => 'NAOqi',
            'osversion' => '2.1.4.13',
        ], [
            'type' => 'NAO',
            'name' => 'NAO T14 (V32)',
            'version' => 'T14 (V32)',
            'ostype' => 'NAOqi',
            'osversion' => '2.1.4.13',
        ], [
            'type' => 'NAO',
            'name' => 'NAO T14 (V33)',
            'version' => 'T14 (V33)',
            'ostype' => 'NAOqi',
            'osversion' => '2.1.4.13',
        ], [
            'type' => 'NAO',
            'name' => 'NAO T14 (V40)',
            'version' => 'T14 (V40)',
            'ostype' => 'NAOqi',
            'osversion' => '2.1.4.13',
        ], [
            'type' => 'NAO',
            'name' => 'NAO T2 (V32)',
            'version' => 'T2 (V32)',
            'ostype' => 'NAOqi',
            'osversion' => '2.1.4.13',
        ], [
            'type' => 'NAO',
            'name' => 'NAO T2 (V33)',
            'version' => 'T2 (V33)',
            'ostype' => 'NAOqi',
            'osversion' => '2.1.4.13',
        ], [
            'type' => 'NAO',
            'name' => 'NAO T2 (V40)',
            'version' => 'T2 (V40)',
            'ostype' => 'NAOqi',
            'osversion' => '2.1.4.13',
        ], [
            'type' => 'Romeo',
            'name' => 'Romeo H32',
            'version' => 'H32',
            'ostype' => 'NAOqi',
            'osversion' => '2.6',
        ], [
            'type' => 'Romeo',
            'name' => 'Romeo H37',
            'version' => 'H37',
            'ostype' => 'NAOqi',
            'osversion' => '2.6',
        ]
    ];

    /**
     * Add the default robots to the database
     */
    public function robots() {
        foreach ($this->robots as $robot) {
            Log:info("Robot robot ".json_encode($robot));
            $this->create($robot);
        }
    }
}

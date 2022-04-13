<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Plank\Mediable\Media as MediableMedia;

class Media extends MediableMedia
{
    use HasFactory;
    protected $appends = [
        'url'
    ];
    protected $hidden = [
        'directory',
        'disk',
        'pivot'
    ];

    public function getUrlAttribute(){
        return $this->getUrl();
    }
}

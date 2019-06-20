<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Storage;

class Image extends Model
{
    //
    protected $table = 'images';

    
    public function pokemon()
    {
        return $this->belongsTo('App\Pokemon', 'value', 'id');
    }

    public function getUrl($id) {
        $image = $this->find($id);
        $url = '';
        if ($image) {
            $url = Storage::url($image->url);
        }
        return $url;
    }
    
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class Gallery extends Model
{

    protected $connection = 'gallery';
    protected $guarded = [];




    public function product()
    {
        return $this->belongsTo('App\Models\Products','post_id','id');
    }


}

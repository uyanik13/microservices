<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{

    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = 'mysql';
    protected $guarded = [];

    public function galleries()
    {
        return $this->hasMany('App\Models\Gallery','post_id','id');
    }


}

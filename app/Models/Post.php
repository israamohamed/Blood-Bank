<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model 
{

    protected $table = 'posts';
    public $timestamps = true;
    protected $fillable = array('title' , 'body' , 'category_id' , 'image');
    protected $appends = ['is_favourite'];

    public function getIsFavouriteAttribute()
    {
        $fav = $this->clients()->where('client_id', auth('client-web')->user()->id)->first();
        //dd($fav);
        return $fav ;
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function clients()
    {
        return $this->belongsToMany('App\Models\Client');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Client extends Authenticatable 
{

    protected $table = 'clients';
    public $timestamps = true;
    protected $guard = 'client-web';
    protected $fillable = array('phone', 'password', 'name', 'dob', 'blood_type_id', 'last_donation_date', 'city_id', 'email');
    protected $hidden = array('password', 'api_token');
    

    public function bloodType()
    {
        return $this->belongsTo('App\Models\BloodType');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }

    public function posts()
    {
        return $this->belongsToMany('App\Models\Post');
    }

    public function notifications()
    {
        return $this->belongsToMany('App\Models\Notification');
    }

    public function bloodTypes()
    {
        return $this->belongsToMany('App\Models\BloodType');
    }

    public function governorates()
    {
        return $this->belongsToMany('App\Models\Governorate');
    }

    public function donationRequests()
    {
        return $this->hasMany('App\Models\DonationRequest');
    }

    public function tokens() 
    {
        return $this->hasMany('App\Models\Token');
    }

}
<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The certificates of user
     * 
     * @return \Illuminate\Database\Eloquent\Relations\hasManay
     */
    public function certificates()
    {
        return $this->hasManay(Certificate::class);
    }
}

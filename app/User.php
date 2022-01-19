<?php


namespace App;

use System\Database\ORM\Model;

class User extends Model
{
    protected $table = 'users';
    protected $fillable = ['username'];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'id', 'user_id', 'role_id', 'id');
    }
}
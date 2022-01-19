<?php


namespace App;

use System\Database\ORM\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $fillable = ['name'];

    public function users()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'id', 'role_id', 'user_id', 'id');
    }
}
<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


/**
 * App\User
 */
class User extends Authenticatable
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    //RELATIONS
    public function posts(){
        return $this->hasMany(Post::class);
    }
    public function role(){
        return $this->belongsTo(Role::class, 'role_level', 'level');
    }
    
    // Related attributes
    public function isAdmin(){
        return $this->role_level == 9;
    }
    public function owns(Post $post){
        return $this->id == $post->created_by;
    }

    //SCOPES
    public function scopeAdmin(){
        return $this->where('role_level', '=', 9);
    }
    public function scopeNotAdmin(){
        return $this->where('role_level', '!=', 9);
    }

    //Mutators
    public function getAvatarAttribute(){
        return 'https://www.gravatar.com/avatar/'. md5($this->email);
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}

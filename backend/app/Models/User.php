<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'created_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * UserMeta
     *
     * @return UserMeta
     */
    public function meta()
    {
        return $this->hasOne(UserMeta::class);
    }

    /**
     * Role
     *
     * @return Role
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Invite
     *
     * @return Invite
     */
    public function invite()
    {
        return $this->hasOne(Invite::class);
    }

    /**
     * Invites
     *
     * @return Invites
     */
    public function invites()
    {
        return $this->hasMany(Invite::class, 'manager_id');
    }

    /**
     * Companies
     *
     * @return Company
     */
    public function companies()
    {
        return $this->belongsToMany(Company::class);
    }

    /**
     * Contests
     *
     * @return Contest
     */
    public function contests()
    {
        return $this->belongsToMany(Contest::class);
    }

}

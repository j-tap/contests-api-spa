<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'active',
        'date_from',
        'date_to',
        'landing_template_id',
        'status_id',
    ];

    /**
     * Company
     *
     * @return void
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * LandingTemplate
     *
     * @return void
     */
    public function landingTemplate()
    {
        return $this->belongsTo(LandingTemplate::class);
    }

    /**
     * Invite
     *
     * @return void
     */
    public function invites()
    {
        return $this->hasMany(Invite::class);
    }

    /**
     * Users
     *
     * @return void
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Status
     *
     * @return void
     */
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    /**
     * Settings
     *
     * @return void
     */
    public function settings()
    {
        return $this->hasMany(Setting::class);
    }

}

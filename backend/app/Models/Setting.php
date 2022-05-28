<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'value',
        'setting_type_id',
        'name',
        'description',
    ];

    /**
     * Company
     *
     * @return Company
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Contest
     *
     * @return Company
     */
    public function contest()
    {
        return $this->belongsTo(Contest::class);
    }

    /**
     * SettingType
     *
     * @return SettingType
     */
    public function settingType()
    {
        return $this->belongsTo(SettingType::class);
    }

}

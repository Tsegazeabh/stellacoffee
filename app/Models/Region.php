<?php

namespace App\Models;

use App\Traits\HasPermission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Authorizable
{
    use HasFactory, HasPermission;

    public $timestamps = true;
    protected $guarded = [
        'deleted_at', 'deleted_by'
    ];

    public static $actions = ['create', 'edit', 'delete'];
    protected $appends = ['display_name'];

    public function customerServiceCenter()
    {
        return $this->hasMany(CustomerServiceCenter::class, 'region_id');
    }
    public function contactDetail()
    {
        return $this->hasMany(ContactDetails::class, 'region_id');
    }
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
    public function city()
    {
        return $this->hasMany(City::class, 'region_id');
    }
    public function zone()
    {
        return $this->hasMany(Zone::class, 'region_id');
    }
    public function woreda()
    {
        return $this->hasMany(Woreda::class, 'region_id');
    }
//    public function locale()
//    {
//        return $this->belongsTo(Locale::class, 'locale_id');
//    }
    public function scopeOfLanguage($query, $culture_id)
    {
        return $query->where('locale_id', $culture_id);
    }
    public function getDisplayNameAttribute(){
        if(getSessionLanguageShortCode()=='en'){
            return $this->name;
        }
        else{
            return $this->name_lan;
        }
    }

}

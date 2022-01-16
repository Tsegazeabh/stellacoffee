<?php

namespace App\Models;

use App\Traits\HasPermission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Authorizable
{
    use HasFactory, HasPermission;

    public $timestamps = true;
    protected $guarded = [
        'deleted_at', 'deleted_by'
    ];
    public static $actions = ['create', 'edit', 'delete'];
    protected $appends = ['display_name'];

    public function city()
    {
        return $this->hasMany(City::class, 'country_id');
    }
    public function region()
    {
        return $this->hasMany(Region::class, 'country_id');
    }

    public function contactUsRequest()
    {
        return $this->hasMany(ContactUsRequest::class, 'country_id');
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

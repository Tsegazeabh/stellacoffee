<?php

namespace App\Models;

use App\Traits\HasPermission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceType extends Authorizable
{
    use HasFactory, HasPermission;

    public $timestamps = true;
    protected $guarded = [
        'deleted_at', 'deleted_by'
    ];
    public static $actions = ['create', 'edit', 'delete'];
    protected $appends = ['display_name'];

    public function cafe()
    {
        return $this->hasMany(Cafe::class, 'service_type_id');
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
        if(getSessionLanguageShortCode()=='am'){
            return $this->name_am;
        }
        elseif (getSessionLanguageShortCode()=='fr'){
            return $this->name_fr;
        }
        elseif (getSessionLanguageShortCode()=='it'){
            return $this->name_it;
        }
        else{
            return $this->name;
        }
    }
}

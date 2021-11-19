<?php

namespace App\Models;

use App\Traits\HasPermission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class City extends Authorizable
{
    use HasFactory, HasPermission;

    public $timestamps = true;
    protected $guarded = [
        'deleted_at', 'deleted_by'
    ];
    public static $actions = ['create', 'edit', 'delete'];
    protected $appends = ['display_name'];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

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

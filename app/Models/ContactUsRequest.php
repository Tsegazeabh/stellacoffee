<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class ContactUsRequest extends Authorizable implements Auditable
{
    use SoftDeletes, HasFactory, AuditableTrait;
    public $timestamps = true;
    protected $appends = ['trashed', 'url', 'lead_paragraph', 'cms_lead_paragraph'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $guarded = [
        'created_at', 'updated_at', 'deleted_at'
    ];
    public static $actions = ['view', 'closeUpdate', 'openUpdate', 'delete','archive'];

    protected $auditInclude = [
        'title',
        'detail',
        'first_name',
        'middle_name',
        'last_name',
        'company_name',
        'professional_area',
        'phone_number',
        'country_id',
        'receive_update',
        'status',
        'email',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at',
        'locale_id'
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->status = true;
        });
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function getLeadParagraphAttribute()
    {
        if (!empty($this->detail)) {
            return Str::words($this->detail, getLeadParagraphWordsLimit());
        }
        return 'No Comment';
    }

    public function getCmsLeadParagraphAttribute()
    {
        if (!empty($this->detail)) {
            return Str::words($this->detail, getCMSLeadParagraphWordsLimit());
        }
        return 'No Comment';
    }

    public function scopeOpen($query)
    {
        return $query->where('status', true)->where('deleted_at', null);;
    }

    public function scopeClosed($query)
    {
        return $query->where('status', false);
    }

    public function scopeArchived($query)
    {
        return $query->where('deleted_at', '!=', null);
    }

    public function getTrashedAttribute()
    {
        // Check if the content has been soft deleted or archived
        return $this->trashed();
    }

    public function getIsArchivedAttribute()
    {
        return $this->trashed();
    }

    public function getUrlAttribute()
    {
        return getContentDetailUrl($this->contact_office_name, $this->id);
    }

    public function locale()
    {
        return $this->belongsTo(Locale::class, 'locale_id');
    }

    public function scopeOfLanguage($query, $culture_id)
    {
        return $query->where('locale_id', $culture_id);
    }

    public function scopeSearch($query, $keyword)
    {
        return $query
            ->where('detail', 'like', '%' . $keyword . '%')
            ->orWhere('first_name', 'like', '%' . $keyword . '%')
            ->orWhere('middle_name', 'like', '%' . $keyword . '%')
            ->orWhere('last_name', 'like', '%' . $keyword . '%')
            ->orWhere('phone_number', 'like', '%' . $keyword . '%')
            ->orWhereHas('country', function ($country) use ($keyword) {
                return $country
                    ->where('name', 'like', '%' . $keyword . '%')
                    ->where('name_am', 'like', '%' . $keyword . '%')
                    ->where('name_fr', 'like', '%' . $keyword . '%')
                    ->where('name_it', 'like', '%' . $keyword . '%')
                    ->orWhere('description', 'like', '%' . $keyword . '%')
                    ->where('description_am', 'like', '%' . $keyword . '%')
                    ->where('description_fr', 'like', '%' . $keyword . '%')
                    ->where('description_it', 'like', '%' . $keyword . '%');
            })
            ->orWhere('email', 'like', '%' . $keyword . '%');
    }

    public function scopeSortBy($query, $sorting_column, $sorting_method)
    {
        switch ($sorting_column) {
            case 'country':
                if (getSessionLanguageShortCode() == 'en') {
                    return $query->join('countries as c', 'c.id', '=', $this->getTable() . '.country_id')->orderBy('c.name', $sorting_method)->select($this->getTable() . '*');
                } else if((getSessionLanguageShortCode() == 'am')) {
                    return $query->join('countries as c', 'c.id', '=', $this->getTable() . '.country_id')->orderBy('c.name_am', $sorting_method)->select($this->getTable() . '*');
                } else if((getSessionLanguageShortCode() == 'fr')) {
                    return $query->join('countries as c', 'c.id', '=', $this->getTable() . '.country_id')->orderBy('c.name_fr', $sorting_method)->select($this->getTable() . '*');
                } else {
                    return $query->join('countries as c', 'c.id', '=', $this->getTable() . '.country_id')->orderBy('c.name_it', $sorting_method)->select($this->getTable() . '*');
                }
                break;
            default:
                return $query->orderBy($sorting_column, $sorting_method);
        }
    }
}

<?php

namespace App\Models;

use App\Traits\HasPermission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class PrivacyPolicy extends Authorizable implements Auditable
{
    use HasFactory, HasPermission, AuditableTrait;

    public $timestamps = false;
    protected $guarded = [
        'deleted_at', 'deleted_by'
    ];

    public static $actions = ['create', 'edit', 'publish', 'unpublish', 'delete', 'archive'];

    protected $appends = ['lead_paragraph', 'cms_lead_paragraph', 'first_image'];

    protected $auditInclude = [
        'title',
        'detail',
    ];

    public function content()
    {
        return $this->morphOne(Content::class, 'contentable')->withTrashed();
    }

    public function getLeadParagraphAttribute()
    {
        // return the lead paragraph of the content to show as a summary
        if (!empty($this->detail)) {
            $first_paragraph = getFirstNonEmptyParagraph($this->detail);
            $leadParagraph = substr($first_paragraph, 0, strpos($first_paragraph, "</p>"));
            return Str::words(strip_tags($leadParagraph), getLeadParagraphWordsLimit());
        }
        return $this->title;
    }

    public function getCmsLeadParagraphAttribute()
    {
        // return the lead paragraph of the content to show as a summary
        if (!empty($this->detail)) {
            $first_paragraph = getFirstNonEmptyParagraph($this->detail);
            $leadParagraph = substr($first_paragraph, 0, strpos($first_paragraph, "</p>"));
            return Str::words(strip_tags($leadParagraph), getCMSLeadParagraphWordsLimit());
        }
        return $this->title;
    }

    public function getFirstImageAttribute()
    {
        // return the lead paragraph of the content to show as a summary
        if (!empty($this->detail)) {
            return getFirstImageSrcsets($this->detail);
        }
        return getDefaultAppImagePath();
    }

    public function scopeSortBy($query, $sorting_column, $sorting_method)
    {

        $contentsTable = getTableName(Content::class);

        switch ($sorting_column) {
            case 'created_at':
                return $query->where('contentable_type', PrivacyPolicy::class)->join($contentsTable . ' as c', 'c.contentable_id', '=', $this->getTable() . '.id')->orderBy('c.created_at', $sorting_method);
                break;
            case 'published_at':
                return $query->where('contentable_type', PrivacyPolicy::class)->join($contentsTable . ' as c', 'c.contentable_id', '=', $this->getTable() . '.id')->orderBy('c.published_at', $sorting_method);
                break;
            case 'deleted_at':
                break;
            case 'content_status':
                return $query->where('contentable_type', PrivacyPolicy::class)->join($contentsTable . ' as c', 'c.contentable_id', '=', $this->getTable() . '.id')->orderBy('c.is_published', $sorting_method)->orderBy('deleted_at', $sorting_method);
                break;
            default:
                return $query->orderBy($sorting_column, $sorting_method);
        }
    }

    public function scopeOfCurrentLanguage($query)
    {
        $langId = getSessionLanguageId();
        return $query->whereHas('content', function ($culture) use ($langId) {
            $culture->where('locale_id', $langId);
        });
    }

    public function scopeOfLanguage($query, $culture_id)
    {
        return $query->whereHas('content', function ($culture) use ($culture_id) {
            $culture->where('locale_id', $culture_id);
        });
    }
}

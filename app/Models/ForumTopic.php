<?php

namespace App\Models;

use App\Traits\HasPermission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class ForumTopic extends Authorizable implements Auditable
{
    use HasFactory, HasPermission, AuditableTrait;

    public $timestamps = false;
    protected $guarded = [];
    protected $appends = ['cms_lead_paragraph', 'lead_paragraph', 'first_image'];

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

    public function scopeSortBy($query, $sorting_column, $sorting_method)
    {
        switch ($sorting_column) {
            case 'created_at':
                return $query->where('contentable_type', ExportDestination::class)->join('Contents as c', 'c.contentable_id', '=', $this->getTable() . '.id')->orderBy('c.created_at', $sorting_method);
            case 'published_at':
                return $query->where('contentable_type', ExportDestination::class)->join('Contents as c', 'c.contentable_id', '=', $this->getTable() . '.id')->orderBy('c.published_at', $sorting_method);
            case 'author':
                return $query->where('contentable_type', ExportDestination::class)->join('Contents as c', 'c.contentable_id', '=', $this->getTable() . '.id')->orderBy('c.created_by_id', $sorting_method);
            case 'archived_date':
                return $query->where('contentable_type', ExportDestination::class)->join('Contents as c', 'c.contentable_id', '=', $this->getTable() . '.id')->orderBy('c.deleted_at', $sorting_method);
            case 'content_status':
                return $query->where('contentable_type', ExportDestination::class)->join('Contents as c', 'c.contentable_id', '=', $this->getTable() . '.id')->orderBy('c.is_published', $sorting_method)->orderBy('deleted_at', $sorting_method);
            default:
                return $query->orderBy($sorting_column, $sorting_method);
        }
    }

    public function getFirstImageAttribute()
    {
        // return the lead paragraph of the content to show as a summary
        if (!empty($this->detail)) {
            return getFirstImageSrcsets($this->detail);
        }
        return getDefaultAppImagePath();
    }
}

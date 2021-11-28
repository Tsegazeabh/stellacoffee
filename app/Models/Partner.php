<?php
namespace App\Models;

use App\Traits\HasPermission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Partner extends Authorizable implements HasMedia, Auditable
{
    use InteractsWithMedia, HasFactory, HasPermission, AuditableTrait;

    public $timestamps = false;
    protected $guarded = [
        'deleted_at', 'deleted_by'
    ];

    protected $appends = ['lead_paragraph', 'cms_lead_paragraph', 'first_image', 'first_media', 'src_sets'];

    protected $auditInclude = [
        'title',
        'detail',
        'link'
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('file-attachments')
            ->useFallbackUrl('/images/logo.jpg')
            ->useFallbackPath(public_path('/images/logo.jpg'))
            ->acceptsMimeTypes(validImageMimeTypes())
            ->withResponsiveImages();
    }

    public function getFirstMediaAttribute()
    {
        if ($this->hasMedia('file-attachments')) {
            if ($this->getFirstMedia('file-attachments')->responsive_images) {
                return $this->getFirstMedia('file-attachments')->responsive_images["media_library_original"];
            } else {
                return $this->getFirstMedia('file-attachments')->getUrl();
            }
        }
        return null;
    }

    public function getFirstImageAttribute()
    {
        // return the lead paragraph of the content to show as a summary
        if (!empty($this->detail)) {
            return getFirstImageSrcsets($this->detail);
        }
        return getDefaultAppImagePath();
    }

    public function getSrcSetsAttribute()
    {
        $srcSets = array();
        for ($i = 0; $i < $this->media()->count(); ++$i) {
            array_push($srcSets, $this->getMedia('file-attachments')[$i]->getSrcset());
        }
        return $srcSets;
    }

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
                return $query->where('contentable_type', Partner::class)->join('Contents as c', 'c.contentable_id', '=', $this->getTable() . '.id')->orderBy('c.created_at', $sorting_method);
                break;
            case 'published_at':
                return $query->where('contentable_type', Partner::class)->join('Contents as c', 'c.contentable_id', '=', $this->getTable() . '.id')->orderBy('c.published_at', $sorting_method);
                break;
            case 'author':
                return $query->where('contentable_type', Partner::class)->join('Contents as c', 'c.contentable_id', '=', $this->getTable() . '.id')->orderBy('c.created_by_id', $sorting_method);
                break;
            case 'archived_date':
                break;
            case 'content_status':
                return $query->where('contentable_type', Partner::class)->join('Contents as c', 'c.contentable_id', '=', $this->getTable() . '.id')->orderBy('c.is_published', $sorting_method)->orderBy('deleted_at', $sorting_method);
                break;
            default:
                return $query->orderBy($sorting_column, $sorting_method);
        }
    }

    public function scopeOfLanguage($query, $culture_id)
    {
        return $query->whereHas('content', function ($culture) use ($culture_id) {
            $culture->where('locale_id', $culture_id);
        });
    }
}

//
//namespace App\Models;
//
//use App\Traits\HasPermission;
//use Illuminate\Database\Eloquent\Factories\HasFactory;
//use OwenIt\Auditing\Auditable as AuditableTrait;
//use OwenIt\Auditing\Contracts\Auditable;
//
//class Partner extends Authorizable implements Auditable
//{
//    use HasFactory, HasPermission, AuditableTrait;
//
//    public $timestamps = false;
//    protected $guarded = [];
//    protected $appends = ['cms_lead_paragraph', 'lead_paragraph', 'first_image'];
//
//    public function content()
//    {
//        return $this->morphOne(Content::class, 'contentable')->withTrashed();
//    }
//
//    public function scopeSortBy($query, $sorting_column, $sorting_method)
//    {
//        switch ($sorting_column) {
//            case 'created_at':
//                return $query->where('contentable_type', ExportDestination::class)->join('Contents as c', 'c.contentable_id', '=', $this->getTable() . '.id')->orderBy('c.created_at', $sorting_method);
//            case 'published_at':
//                return $query->where('contentable_type', ExportDestination::class)->join('Contents as c', 'c.contentable_id', '=', $this->getTable() . '.id')->orderBy('c.published_at', $sorting_method);
//            case 'author':
//                return $query->where('contentable_type', ExportDestination::class)->join('Contents as c', 'c.contentable_id', '=', $this->getTable() . '.id')->orderBy('c.created_by_id', $sorting_method);
//            case 'archived_date':
//                return $query->where('contentable_type', ExportDestination::class)->join('Contents as c', 'c.contentable_id', '=', $this->getTable() . '.id')->orderBy('c.deleted_at', $sorting_method);
//            case 'content_status':
//                return $query->where('contentable_type', ExportDestination::class)->join('Contents as c', 'c.contentable_id', '=', $this->getTable() . '.id')->orderBy('c.is_published', $sorting_method)->orderBy('deleted_at', $sorting_method);
//            default:
//                return $query->orderBy($sorting_column, $sorting_method);
//        }
//    }
//
//    public function scopeOfLanguage($query, $culture_id)
//    {
//        return $query->whereHas('content', function ($culture) use ($culture_id) {
//            $culture->where('locale_id', $culture_id);
//        });
//    }
//
//    public function getFirstImageAttribute()
//    {
//        // return the lead paragraph of the content to show as a summary
//        if (!empty($this->detail)) {
//            return getFirstImageSrcsets($this->detail);
//        }
//        return getDefaultAppImagePath();
//    }
//}

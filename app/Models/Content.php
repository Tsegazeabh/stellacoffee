<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Content extends BaseModel implements Feedable, Auditable
{
    use SoftDeletes, HasFactory, AuditableTrait;

    protected $appends = ['trashed', 'url', 'content_type_name'];

    protected $auditInclude = [
        'contentable_id',
        'contentable_type',
        'is_published',
        'locale_id',
        'created_at',
        'updated_at',
        'published_at',
        'deleted_at',
        'published_by',
        'created_by',
        'updated_by',
    ];
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'published_at', 'deleted_at'];

    protected $guarded = [
        'is_published', 'published_at', 'created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_at'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime:Y-m-d',
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d',
        'deleted_at' => 'datetime:Y-m-d',
    ];

    protected $with = ['locale'];

    public function contentable()
    {
        return $this->morphTo();
    }

    public function locale()
    {
        return $this->belongsTo(Locale::class, 'locale_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, "content_tags", 'content_id', 'tag_id');
    }

    public function content_hits()
    {
        return $this->hasMany(ContentHit::class, "content_id");
    }

    public function getRelatedContentsAttribute()
    {
        // fetch all related contents and return it.
        // Note that don't forget to exclude the content it self while querying the related contents.
        return;
    }

    public function getHasImageAttribute()
    {
        // Check if the content has media which is image
        return;
    }

    public function getHasVideoAttribute()
    {
        // Check if the content has media which is video
        return;
    }

    public function getHasAudioAttribute()
    {
        // Check if the content has media which is audio
        return;
    }

    public function getTrashedAttribute()
    {
        // Check if the content has been soft deleted or archived
        return $this->trashed();
    }

    public function getIsArchivedAttribute()
    {
        return $this->content->trashed();
    }

    public function getUrlAttribute()
    {
        return getContentDetailUrl($this->contentable_type, $this->id, $this->locale->short_code);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopePublishedWithoutArchived($query)
    {
        return $query->where('is_published', true)->where('deleted_at', null);
    }

    public function scopeUnPublished($query)
    {
        return $query->where('is_published', false);
    }

    public function scopeArchived($query)
    {
        return $query->where('deleted_at', '!=', null);
    }

    public function scopeOfRelated($query, $tags, $exception_id)
    {
        return $query->whereHas('tags', function ($query) use ($tags) {
            return $query->whereIn('tags.id', $tags);
        })->where('id', '!=', $exception_id);
    }

    public function scopeOfType($query, $contentable_type)
    {
        return $query->where('contentable_type', $contentable_type);
    }

    public function scopeOfPopular($query, $limit)
    {
        return $query->withCount('content_hits')->orderBy('content_hits_count', 'desc')->take($limit);
    }

    public function scopeSearch($query, $keyword, $contentable_types)
    {
        return $query->whereHas('tags', function ($tags) use ($keyword) {
            return $tags->where('name', 'like', '%' . $keyword . '%');
        })->orWhereHasMorph('contentable', $contentable_types, function ($query) use ($keyword) {
            return $query
                ->where('title', 'like', '%' . $keyword . '%')
                ->orWhere('detail', 'like', '%' . $keyword . '%');
        });
    }

    public function scopeSearchTestimonials($query, $keyword, $contentable_types)
    {
        return $query->whereHas('tags', function ($tags) use ($keyword) {
            return $tags->where('name', 'like', '%' . $keyword . '%');
        })->orWhereHasMorph('contentable', $contentable_types, function ($query) use ($keyword) {
            return $query
                ->where('testimonial_name', 'like', '%' . $keyword . '%')
                ->where('testimonial_organization', 'like', '%' . $keyword . '%')
                ->where('testimonial_position', 'like', '%' . $keyword . '%')
                ->orWhere('testimonial_message', 'like', '%' . $keyword . '%');
        });
    }

    public function scopeSiteSearch($query, $keyword)
    {
        return $query
            ->whereHas('tags', function ($tags) use ($keyword) {
                return $tags->where('name', 'like', '%' . $keyword . '%');
            })
            ->orWhereHasMorph('contentable', getSearchableContentTypes(), function ($query) use ($keyword) {
                return $query
                    ->where('title', 'like', '%' . $keyword . '%')
                    ->orWhere('detail', 'like', '%' . $keyword . '%');
            });
    }

    public function scopeSortBy($query, $sorting_column, $sorting_method, $contentableType)
    {
        $tableName = getTableName($contentableType);
        switch ($sorting_column) {
            case 'content_status':
                return $query->orderBy('is_published', $sorting_method)->orderBy('deleted_at', $sorting_method);
            case 'detail':
                return $query->leftJoin($tableName . ' as m', 'm.id', '=', $this->getTable() . '.contentable_id')->orderBy('m.detail', $sorting_method)->select('contents.*');
            case 'title':
                return $query->leftJoin($tableName . ' as m', 'm.id', '=', $this->getTable() . '.contentable_id')->orderBy('m.title', $sorting_method)->select('contents.*');
            case 'from_date':
                return $query->leftJoin($tableName . ' as m', 'm.id', '=', $this->getTable() . '.contentable_id')->orderBy('m.from_date', $sorting_method)->select('contents.*');
            case 'to_date':
                return $query->leftJoin($tableName . ' as m', 'm.id', '=', $this->getTable() . '.contentable_id')->orderBy('m.to_date', $sorting_method)->select('contents.*');
            case 'service_type_id':
                return $query->leftJoin($tableName . ' as m', 'm.id', '=', $this->getTable() . '.contentable_id')->orderBy('m.service_type_id', $sorting_method)->select('contents.*');
            default:
                return $query->orderBy($sorting_column, $sorting_method);
        }
    }

    public function scopeOfLanguage($query, $langId)
    {
        return $query->where('locale_id', $langId);
    }

    public function scopeForRSSFeed($query)
    {
        $date_before_3_days = Carbon::today()->addDays(-3);
        return $query->whereDate('published_at', '>', $date_before_3_days);
    }

    public function toFeedItem(): FeedItem
    {
        return FeedItem::create()
            ->id($this->id)
            ->title($this->contentable->title)
            ->summary($this->contentable->detail)
            ->updated($this->updated_at)
            ->link($this->getUrlAttribute())
            ->authorName('Ethiopian Electric Utility')
            ->authorEmail('feeds@eeu.gov.et');
    }

    public static function getEnglishFeedItems()
    {
        return Content::with('contentable')
            ->withTrashed()
            ->published()
            ->whereHasMorph('contentable', getContentTypesForRSSFeeds())
            ->whereHas('locale', function ($query) {
                return $query->where('short_code', 'en');
            })
            ->forRSSFeed()
            ->orderBy('published_at', 'DESC')
            ->get();
    }

    public static function getAmharicFeedItems()
    {
        return Content::with('contentable')
            ->withTrashed()
            ->published()
            ->whereHasMorph('contentable', getContentTypesForRSSFeeds())
            ->whereHas('locale', function ($query) {
                return $query->where('short_code', 'am');
            })
            ->forRSSFeed()
            ->orderBy('published_at', 'DESC')
            ->get();
    }

    public function getContentTypeNameAttribute()
    {
        return getModelShortName($this->contentable_type);
    }

}

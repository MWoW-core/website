<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Spatie\MediaLibrary\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use BeyondCode\Comments\Traits\HasComments;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

/**
 * Class News
 * @package App
 * @mixin Builder
 * @property int $id
 * @property int $creator_id
 * @property-read Server $server
 * @property string $title
 * @property string $headline
 * @property string $body
 * @property-read string $link
 * @property-read User $creator
 * @property-read Collection $comments
 */
class News extends Model implements HasMedia
{
    use HasComments, HasMediaTrait, SoftDeletes;

    protected $fillable = [
        'creator_id',
        'category',
        'title',
        'headline',
        'body'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class);
    }

    public function getLinkAttribute()
    {
        return route('news.show', $this);
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
              ->width(368)
              ->height(232)
              ->sharpen(10)
              ->withResponsiveImages();
    }
}

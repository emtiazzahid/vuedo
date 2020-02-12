<?php

namespace App;

use Acme\Traits\HashOrSlugScope;
use Cviebrock\EloquentSluggable\Sluggable;
use Hootlex\Moderation\Moderatable;
use Hootlex\Moderation\Status;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Vinkla\Hashids\Facades\Hashids;


class Post extends Model implements HasMedia
{
    use Sluggable, HasMediaTrait, Moderatable, HashOrSlugScope;

    protected $fillable = ['title', 'slug', 'description', 'content'];

    /**
     * The user that belong to the post.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    /**
     * The categories that belong to the post.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }


    /**
     * Check if the post has specific category.
     * @param $category
     *
     * @return bool
     */
    public function hasCategory($category)
    {
        $category_id = (is_int($category)) ? $category: $category->id;
        foreach ($this->categories as $cat) {
            if ($category_id === $cat->id){
                return true;
            }
        }
        return false;
    }

    /**
     * Get post status as human readable string.
     * @return string
     */
    public function getHumanStatus()
    {
        switch ($this->status) {
            case Status::APPROVED:
                $status = 'approved';
                break;
            case Status::REJECTED:
                $status = 'rejected';
                break;
            case Status::PENDING:
                $status = 'pending';
                break;
            case Status::POSTPONED:
                $status = 'postponed';
                break;
        }
        return $status;
    }
    /**
     * MUTATORS
     */
    public function getHashidAttribute()
    {
        return Hashids::encode($this->id);
    }

    /**
     * Get the original Url to an image
     * @return string|null
     */
    public function getImageUrlAttribute()
    {
        return $this->hasMedia() ? $this->getFirstMedia('featured')->getUrl() : null;
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}

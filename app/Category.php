<?php

namespace App;

use Acme\Traits\HashOrSlugScope;
use Cviebrock\EloquentSluggable\Sluggable;
use Hashids;
use Illuminate\Database\Eloquent\Model;


class Category extends Model
{
    use Sluggable, HashOrSlugScope;

    protected $fillable = ['name', 'icon'];


    /**
     * The posts that belong to the category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }

    /**
     * MUTATORS
     */
    public function getHashidAttribute()
    {
        return Hashids::encode($this->id);
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
                'source' => 'name'
            ]
        ];
    }
}

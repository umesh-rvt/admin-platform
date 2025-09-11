<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Page extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'meta_description',
        'meta_keywords',
        'status',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the sections that belong to this page.
     */
    public function sections()
    {
        return $this->hasMany(PageSection::class)->orderBy('sort_order');
    }

    /**
     * Get the categories that belong to this page.
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * Get active sections only.
     */
    public function activeSections()
    {
        return $this->sections()->where('is_active', true);
    }

    /**
     * Scope to get published pages.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')->where('is_active', true);
    }

    /**
     * Scope to get active pages.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get pages by category.
     */
    public function scopeByCategory($query, $category)
    {
        return $query->whereHas('categories', function ($q) use ($category) {
            $q->where('categories.id', $category->id);
        });
    }

    /**
     * Boot method to automatically generate slug from title.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($page) {
            if (empty($page->slug)) {
                $page->slug = Str::slug($page->title);
            }
        });

        static::updating(function ($page) {
            if ($page->isDirty('title') && empty($page->slug)) {
                $page->slug = Str::slug($page->title);
            }
        });
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}

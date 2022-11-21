<?php

namespace App\Models;

use App\Traits\PostTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory, PostTrait;

    protected $casts = [
        'created_at' => 'datetime:F, jS, Y g:i A',
        'updated_at' => 'datetime:F, jS, Y g:i A'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'content',
        'status',
        'published_at',
        'updated_at'
    ];

    /**
     * Every post has one author
     *
     * @return HasOne
     */
    public function author(): HasOne
    {
        return $this->hasOne(User::class);
    }

    /**
     * Return Short Content (excerpt)
     *
     * @return Attribute
     */
    public function shortContent(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attrs) => Str::limit($attrs['content'], 150)
        );
    }
}

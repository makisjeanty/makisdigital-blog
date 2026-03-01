<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'description',
        'image_path',
        'level',
        'price',
        'duration',
        'status',
    ];

    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps()->withPivot('enrolled_at');
    }

    public function scopePublished($query)
    {
        return $query->where('status', '=', 'published');
    }

    public function modules(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CourseModule::class)->orderBy('order');
    }
}

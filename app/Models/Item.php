<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'category',
        'status',
        'city',
        'image',
        'user_id',

    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function oppositeStatus(): string { return $this->status === 'lost' ? 'found' : 'lost'; }

    public function scopeSearch($q, ?string $term)
    {
        $term = trim((string)$term);
        if ($term === '') return $q;
        $like = '%' . str_replace(['%','_'], ['\%','\_'], $term) . '%';
        return $q->where(fn($qq) => $qq
            ->where('title','like',$like)
            ->orWhere('description','like',$like)
            ->orWhere('city','like',$like));
    }

    public function scopeSameCityCategory($q, string $city, string $category)
    { return $q->where('city',$city)->where('category',$category); }

    public function scopeOppositeStatusOf($q, self $item)
    { return $q->where('status', $item->oppositeStatus()); }
}

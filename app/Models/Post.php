<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use HasFactory;


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeAccordingToUserRole($query)
    {
        if (Auth::user()->hasRole('super-admin')) {
            return $query->with(['user', 'category'])->orderBy('id', 'DESC')->paginate(30)->withQueryString();
        }
        return $query->with(['user', 'category'])->where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->paginate(30)->withQueryString();
    }
}

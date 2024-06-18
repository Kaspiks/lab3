<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use PharIo\Manifest\Author;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = ['body'];
    public function post() {
        return $this->belongsTo(Post::class);
    }

    public function author() {
        return $this->belongsTo(User::class);
    }

    public function scopePublished($query) {
        return $query->where('published', true);
    }
}

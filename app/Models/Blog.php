<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model {
    protected $fillable=['title','slug','category_id','operator_id','description','thumbnail','status'];

    protected static function booted(){
        static::creating(function($blog){
            if(empty($blog->slug)){
                $base=Str::slug($blog->title); $slug=$base; $i=1;
                while(static::where('slug',$slug)->exists()){ $slug="{$base}-{$i}"; $i++; }
                $blog->slug=$slug;
            }
        });
    }

    public function category(){ return $this->belongsTo(BlogCategory::class,'category_id'); }
    public function operator(){ return $this->belongsTo(User::class,'operator_id'); }
    public function scopeActive($q){ return $q->where('status',1); }
    public function likes()    { return $this->hasMany(\App\Models\BlogLike::class); }
    public function comments()
    {
        return $this->hasMany(BlogComment::class, 'blog_id');
    }

    public function approvedComments()
    {
        return $this->comments()->where('status', 1);
    }    public function favorites(){ return $this->hasMany(\App\Models\BlogFavorite::class); }

    public function likedBy($userId): bool {
        return $this->likes()->where('user_id',$userId)->exists();
    }
    public function favoritedBy($userId): bool {
        return $this->favorites()->where('user_id',$userId)->exists();
    }

}

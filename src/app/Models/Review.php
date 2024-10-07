<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_id',
        'user_id',
        'rank',
        'comment',
        'image_url'
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function deleteImage(){
        $url = $this->image_url;
        $path =  mb_substr($url, mb_strrpos($url, '/review_image'), mb_strlen($url));
        Storage::delete($path);
    }

    public function deleteWithImage(){
        $this->deleteImage();
        $this->delete();
        return;
    }

}

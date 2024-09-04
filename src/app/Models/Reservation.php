<?php

namespace App\Models;

use App\Http\Requests\ReservationRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_id',
        'user_id',
        'date',
        'number'
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getDateString()
    {
        return date('Y-m-d', strtotime($this->date));
    }

    public function getTimeString()
    {
        return date('H:i', strtotime($this->date));
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PcMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'conference_id',
    ];

    public function conference()
    {
        return $this->belongsTo(Conference::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function review(){
        return $this->hasMany(Review::class);
    }
}

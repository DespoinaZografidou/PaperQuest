<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'paper_id',
    ];

    public function paper()
    {
        return $this->belongsTo(Paper::class,'paper_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

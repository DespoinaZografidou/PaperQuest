<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paper extends Model
{
    use HasFactory;

    protected $fillable = [
        'creator_id',
        'conference_id',
        'title',
        'description',
        'keywords',
        'approved',
        'file',
    ];

    public function conference()
    {
        return $this->belongsTo(Conference::class);
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
    public function author()
    {
        return $this->hasMany(Author::class);
    }


}

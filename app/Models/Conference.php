<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conference extends Model
{
    use HasFactory;

    protected $fillable = [
        'creator_id',
        'title',
        'description',
        'created_at',
        'submission_at',
        'assigment_at',
        'review_at',
        'decision_at',
        'final_submission_at',
        'final_at'
    ];

    public $timestamps = false;
    public function pcChair()
    {
        return $this->hasMany(PcChair::class);
    }
    public function pcMember()
    {
        return $this->hasMany(PcMember::class);
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
    public function paper()
    {
        return $this->hasMany(Paper::class);
    }



}

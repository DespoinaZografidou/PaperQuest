<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $fillable = [
        'paper_id',
        'pc_member_id',
        'garde',
        'reasoning',
        'answer',
    ];

    public function paper()
    {
        return $this->belongsTo(Paper::class,'paper_id');
    }
    public function pcMember()
    {
        return $this->belongsTo(PcMember::class,'pc_member_id');
    }


}

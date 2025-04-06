<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'text',
        'type',
        'grade',
        'correct_answer',
        'answers',
        'exam_id',
    ];

    protected $casts = [
        'answers' => 'array',
    ];
}

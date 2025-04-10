<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserExam extends Model
{
    protected $table = 'user_exam';
    protected $fillable = [
        'mark',
        'start_time',
        'end_time',
        'report',
        'user_id',
        'exam_id',
    ];
}
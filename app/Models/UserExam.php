<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Exam;
use App\Models\User;

class UserExam extends Model
{
    protected $table = 'user_exam';

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    protected $fillable = [
        'mark',
        'start_time',
        'end_time',
        'report',
        'user_id',
        'exam_id',
    ];

    public function exam()
      {
          return $this->belongsTo(Exam::class);
      }

      public function user()
      {
          return $this->belongsTo(User::class);
      }
}
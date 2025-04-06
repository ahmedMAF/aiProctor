<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = ['name','description','open_time','close_time','duration','full_mark','pass_mark','is_sequential','do_mix','user_id'];
    
}

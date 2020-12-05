<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $fillable = [
        'Task',
        'Description',
        'Status',
        'Priority',
    ];


    // public function getCreatedAtAttribute($date){
    //     return Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
    // }

    // public function getUpdatedAtAttribute($date){
    //     return Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
    // }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\Hasfactory;
use Illuminate\Database\Eloquent\Model;


class Task extends Model
{
use HasFactory;

protected $fillable = [
    'title',
    'user_id',
    'category_id',
    'description',
    'status',
    'due_date'
];

public function category()
{
    return $this->belongsTo(Category::class);
}
public function user()
{
    return $this->belongsTo(User::class);
}
}
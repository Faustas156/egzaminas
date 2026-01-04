<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table = "tickets";

    protected $fillable = [
        'title',
        'body',
        'user_id',
        'status_id',
        'category_id',
    ];
    public $timestamps = true;
}

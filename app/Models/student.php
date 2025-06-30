<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class student extends Model
{
    use HasFactory;

    protected $table = 'students';
    protected $fillable = [

        'name',
        'enrollement_no',
        'gender',
        'mobile_number',
        'email_id',
        'password',
        'image'
    ];

    public $timestamps = false;
}

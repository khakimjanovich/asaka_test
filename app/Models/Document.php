<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    const DRAFT = 'draft';
    const PUBLISHED = 'published';

    protected $guarded = [];
    protected $casts = ['payload' => 'json'];
}

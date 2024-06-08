<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookRead extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'book_read';
    protected $fillable = ['username', 'title'];

    // Add any other model properties or methods here as needed
}

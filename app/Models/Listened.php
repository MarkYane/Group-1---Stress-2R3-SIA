<?php

// app/Models/Listened.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Listened extends Model
{
    protected $table = 'listened';
    protected $fillable = ['username', 'title'];
}


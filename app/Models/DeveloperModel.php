<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeveloperModel extends Model
{
    use HasFactory;
    protected $table = 'developers';
    protected $primaryKey = 'id';
}

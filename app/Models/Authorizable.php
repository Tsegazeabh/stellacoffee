<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Authorizable extends Model
{
    use HasFactory;
    public static $actions = ['create', 'edit', 'publish', 'unpublish', 'delete', 'archive', 'restore'];
}

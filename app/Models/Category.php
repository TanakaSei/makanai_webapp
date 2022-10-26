<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Menu;
class Category extends Model
{
    use HasFactory;
    public function menu()
    {
        return $this->hasMany(Menu::class);
    }
}

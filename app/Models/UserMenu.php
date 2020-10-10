<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserMenu extends Model
{
    protected $fillable = ["user_id", "menu_id"];

    public $timestamps = false;

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function menu()
    {
        return $this->hasOne(Menu::class, 'id', 'menu_id');
    }
}

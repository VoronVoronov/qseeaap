<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, mixed $menu_id)
 */
class Category extends Model
{
    protected $fillable = [
        'menu_id',
        'parent_id',
        'name',
        'slug',
        'img',
        'sort'
    ];

    protected $with = ['subcategory'];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function subcategory()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}

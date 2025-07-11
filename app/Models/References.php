<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class References extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image', 'type', 'url', 'hit', 'published', 'lang_id'];

    public function image()
    {
        if ($this->image) {
            return asset("storage/" . config('constants.references_path') . "/" . $this->image); // Resmin tam URL'sini döndürüyor
        }
        return false;
    }
}

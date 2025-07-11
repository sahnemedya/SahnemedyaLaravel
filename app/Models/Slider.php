<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = ['title','description','image','mobile_image','url','published','hit','lang_id'];

    public function image()
    {
        if ($this->image) {
            return asset("storage/" . config('constants.slide_path') . "/" . $this->image); // Resmin tam URL'sini döndürüyor
        }
        return false;
    }

    public function mobilImage()
    {
        if ($this->mobile_image) {
            return asset("storage/" . config('constants.slide_path') . "/" . $this->mobile_image); // Resmin tam URL'sini döndürüyor
        }
        return false;
    }
}

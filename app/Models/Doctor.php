<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doctor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ["name", "surname", "title", "medical_unit"];

    public function doctor()
    {
        return $this->doctor_title." ".$this->name." ".$this->surname;
    }

    public function medicalUnit()
    {
        return $this->belongsTo(Page::class, "medical_unit")->withTrashed();
    }

}

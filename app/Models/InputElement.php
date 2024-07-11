<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InputElement extends Model
{
    use HasFactory;
    public $timestamps = false;
    public function formField()
    {
        return $this->belongsTo(FormField::class, 'id', 'input_element_id');
    }
}

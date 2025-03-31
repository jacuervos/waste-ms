<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderTypeWaste extends Model {
    use HasFactory;
    
    protected $fillable = ['type_waste_id', 'order_id', 'weight', 'points'];

    public function typeWaste() {
        return $this->belongsTo(TypeWaste::class);
    }
}

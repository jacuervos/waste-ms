<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeWaste extends Model {
    use HasFactory;
    
    protected $fillable = ['name', 'points', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
        'points'    => 'integer',
    ];

    public function orderTypeWastes() {
        return $this->hasMany(OrderTypeWaste::class);
    }
}

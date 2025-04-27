<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stitch extends Model
{
    use HasFactory;

    protected $fillable = [
        'tailor_id',
        'customer_id',
        'garment_name',
        'section_name',
        'status',
        'start_time',
        'completed_time',
    ];


    public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}

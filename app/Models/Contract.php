<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_data_id',
        'contract_date',
        'end_of_contract_date',
        'price_per_month',
        'total_months',
        'notes',
        'photos',
    ];

    protected $casts = [
        'contract_date' => 'datetime',
        'end_of_contract_date' => 'datetime',
        'photos' => 'array',
        'created_at' => 'datetime: Y-m-d H:i:s',
        'updated_at' => 'datetime: Y-m-d H:i:s'
    ];

}

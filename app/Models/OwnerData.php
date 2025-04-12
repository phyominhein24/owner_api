<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OwnerData extends Model
{
    
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'owner_id',
        'corner_id',
        'city_id',
        'township_id',
        'ward_id',
        'street_id',
        'wifi_id',
        'land_no',
        'house_no',
        'property',
        'meter_no',
        'meter_bill_code',
        'wifi_user_id',
        'land_id',
        'issuance_date',
        'expired',
        'renter_id',
        'status'
        // 'contract_date',
        // 'end_of_contract_date',
        // 'price_per_month',
        // 'total_months',
        // 'notes',
        // 'photos',
    ];

    protected $casts = [
        'issuance_date' => 'datetime: Y-m-d H:i:s',
        'expired' => 'datetime: Y-m-d H:i:s',
        'created_at' => 'datetime: Y-m-d H:i:s',
        'updated_at' => 'datetime: Y-m-d H:i:s'
    ];

    protected static function boot()
    {

        parent::boot();

        static::creating(function ($model) {
            if (!$model->isDirty('created_by')) {
                $model->created_by = auth()->user()->id;
            }
            if (!$model->isDirty('updated_by')) {
                $model->updated_by = auth()->user()->id;
            }
        });

        static::updating(function ($model) {
            if (!$model->isDirty('updated_by')) {
                $model->updated_by = auth()->user()->id;
            }
        });
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }
}

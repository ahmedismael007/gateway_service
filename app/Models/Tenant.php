<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;

class Tenant extends BaseTenant implements TenantWithDatabase, HasMedia
{
    use HasDatabase, HasDomains, InteractsWithMedia;

    protected $fillable = [
        'id',
        'name',
        'commercial_number',
        'tax_number',
        'currency',
        'country',
        'is_vat_registered',
        'phone',
        'email',
        'tax_registeration_date',
        'tax_first_due_date',
        'tax_period',
        'fiscal_year_end',
        'building_number',
        'street',
        'district',
        'city',
        'postal_code',
    ];

    public static function getCustomColumns(): array
    {
        return [
            'id',
            'name',
            'commercial_number',
            'tax_number',
            'currency',
            'country',
            'is_vat_registered',
            'phone',
            'email',
            'tax_registeration_date',
            'tax_first_due_date',
            'tax_period',
            'fiscal_year_end',
            'building_number',
            'street',
            'district',
            'city',
            'postal_code',
        ];
    }

    protected $casts = [
        'name' => 'array',
        'is_vat_registered' => 'boolean',
        'tax_registeration_date' => 'date',
        'tax_first_due_date' => 'date',
    ];


    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo');
    }



    public function users()
    {
        return $this->belongsToMany(User::class, 'tenant_user', 'tenant_id', 'user_id');
     }
}

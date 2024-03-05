<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany; 

class Client extends Model
{
    public function project(): belongsTo
    {
        return $this->belongsTo(Project::class);
    }
    public function stands(): hasMany
    {
        return $this->hasMany(Stand::class);
    }

    public function payments(): hasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function agreementOfSale(): hasMany
    {
        return $this->hasMany(AgreementOfSale::class);
    }
}

<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Stand extends Model
{
    public function project(): belongsTo
    {
        return $this->belongsTo(Project::class);
    }


    public function client(): belongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function payments(): hasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function agreementOfSale(): hasOne
    {
        return $this->hasOne(AgreementOfSale::class);
    }
}

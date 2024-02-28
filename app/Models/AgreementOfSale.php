<?php

namespace App\Models;

use App\Events\AgreementCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AgreementOfSale extends Model
{

    protected $dispatchesEvents = [
        'created' => AgreementCreated::class,
    ];


    public function project(): belongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function stand() : hasMany
    {
        return $this->hasMany(Stand::class);
    }


    public function payments(): HasManyThrough
    {
         return $this->hasManyThrough(Payment::class, Stand::class);
    }

}

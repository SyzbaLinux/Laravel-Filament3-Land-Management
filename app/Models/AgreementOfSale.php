<?php

namespace App\Models;

use App\Events\AgreementCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class AgreementOfSale extends Model
{


    protected $dispatchesEvents = [
        'created' => AgreementCreated::class,
        'updated' => AgreementCreated::class,
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

//
//    public function payments(): HasManyThrough
//    {
//         return $this->hasManyThrough(Payment::class, Stand::class);
//    }

    public function installments()
    {
        return $this->hasMany(Installment::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

}

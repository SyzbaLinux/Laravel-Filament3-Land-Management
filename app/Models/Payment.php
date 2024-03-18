<?php

namespace App\Models;


use App\Events\AgreementCreated;
use App\Events\PaymentAdded;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $dispatchesEvents = [
        'created' => PaymentAdded::class,
        'updated' => PaymentAdded::class,
    ];


    public function project(): belongsTo
    {
        return $this->belongsTo(Project::class);
    }


    public function client(): belongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function stand(): belongsTo
    {
        return $this->belongsTo(Stand::class);
    }
    public function installment(): belongsTo
    {
        return $this->belongsTo(Installment::class);
    }
}

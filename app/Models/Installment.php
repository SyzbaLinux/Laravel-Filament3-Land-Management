<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Installment extends Model
{
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

    public function agreement(): belongsTo
    {
        return $this->belongsTo(AgreementOfSale::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class,'payment_id');
    }


}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VatPayment extends Model
{
    public function project(): belongsTo
    {
        return $this->belongsTo(Project::class);
    }


    public function client(): belongsTo
    {
        return $this->belongsTo(Client::class);
    }
}

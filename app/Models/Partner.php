<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Partner extends Model
{
    public function project(): belongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function agreement()
    {
        return  $this->belongsTo(AgreementOfSale::class);
    }
}

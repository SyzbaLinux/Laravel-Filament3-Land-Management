<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Penalt extends Model
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
    public function payment(): hasMany
    {
        return $this->hasMany(Payment::class);
    }
}

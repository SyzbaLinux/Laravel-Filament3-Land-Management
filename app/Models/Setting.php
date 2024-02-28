<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Setting extends Model
{
    public function project(): belongsTo
    {
        return $this->belongsTo(Project::class);
    }
}

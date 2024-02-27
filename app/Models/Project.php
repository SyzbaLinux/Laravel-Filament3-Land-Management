<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    public function members(): belongsToMany
    {
        return $this->belongsToMany(User::class);
    }


    public function clients(): hasMany
    {
        return $this->hasMany(Client::class);
    }


    public function stands(): hasMany
    {
        return $this->hasMany(Stand::class);
    }

    public function payments(): hasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function agreementOfSales(): hasMany
    {
        return $this->hasMany(AgreementOfSale::class);
    }

}

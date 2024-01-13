<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Instrument extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','img',
    ];

    public function category(): HasOne
    {
        return $this->hasOne(InstrumentCategorie::class);
    }
    public function user():BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

}

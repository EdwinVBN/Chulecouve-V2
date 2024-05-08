<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seizoen extends Model
{
    protected $table = 'seizoen';
    protected $primaryKey = 'SeizoenID';

    public function series() {
        return $this->belongsTo(Serie::class, 'serieID');
    }

    public function episodes() {
        return $this->hasMany(Aflevering::class, 'SeizID');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seizoen extends Model
{
    protected $table = 'seizoen';
    protected $primaryKey = 'SeizoenID';

    public function serie()
    {
        return $this->belongsTo(Serie::class, 'SerieID');
    }

    public function episodes() 
    {
        return $this->hasMany(Aflevering::class, 'SeizID');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    protected $table = 'serie';
    protected $primaryKey = 'SerieID';

    public function seasons() {
        return $this->hasMany(Seizoen::class, 'serieID');
    }

    public function genres() {
        return $this->belongsToMany(Genre::class, 'serie_genre', 'SerieID', 'GenreID');
    }

    public function episodes()
    {
        return $this->hasManyThrough(
            Aflevering::class, // Final child model
            Seizoen::class,  // Intermediate model
            'SerieID',     // Foreign key on the intermediate model
            'SeizID',    // Foreign key on the final child model
            'SerieID',           // Local key on the parent model (Serie)
            'SeizoenID'            // Local key on the intermediate model (Season)
        );
    }
}

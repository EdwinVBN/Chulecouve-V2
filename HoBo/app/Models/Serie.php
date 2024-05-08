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
}

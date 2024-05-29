<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aflevering extends Model
{
    protected $table = 'aflevering';
    protected $primaryKey = 'AfleveringID';

    public function season() {
        return $this->belongsTo(Seizoen::class, 'SeizoenID');
    }

    public function streams() {
        return $this->hasMany(Stream::class, 'AflID');
    }
}

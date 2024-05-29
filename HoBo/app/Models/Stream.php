<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stream extends Model
{
    protected $table = 'stream';
    protected $primaryKey = 'StreamID';

    public function episode() {
        return $this->belongsTo(Aflevering::class, 'AfleveringID');
    }
}

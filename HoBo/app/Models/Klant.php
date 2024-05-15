<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;

class Klant extends Model implements Authenticatable
{
    use HasFactory;
    protected $table = 'klant';
    protected $fillable = ['AboID', 'Username', 'Voornaam', 'Tussenvoegsel', 'Achternaam', 'Email', 'password', 'Genre', 'Iban', 'adress'];

    public function getAuthIdentifierName()
    {
        return 'KlantNr'; // Assuming your primary key column is named 'id'
    }

    public function getAuthIdentifier()
    {
        return $this->getKey(); // Assuming your primary key column is named 'id'
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }
}


<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Formation extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_formation',
        'date_formation',
        'statut',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}

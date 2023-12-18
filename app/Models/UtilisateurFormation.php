<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UtilisateurFormation extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'formation_id',
        'statut',
    ];
}

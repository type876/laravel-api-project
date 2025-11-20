<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TokenType extends Model
{
    protected $fillable = ['name', 'description'];
    public function apiService()
    {
        return $this->belongsToMany(ApiService::class, 'api_service_token_type');
    }
    public function tokens()
    {
        return $this->hasMany(Token::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Connection extends Model
{
    use HasFactory;
    protected $fillable = [
        'type',
        'value',
        'user_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function events()
    {
        return $this->belongsToMany(Connection::class, 'user_id', 'user_id');
    }
}

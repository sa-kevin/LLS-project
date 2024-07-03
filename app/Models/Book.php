<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'author', 'description', 'isbn', 'publiched_at'];
    protected $dates = ['published_at'];

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}

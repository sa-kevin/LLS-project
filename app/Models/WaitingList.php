<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaitingList extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'book_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function book(){
        return $this->belongsTo(Book::class);
    }
    public function getNextInLine($bookId)
    {
        return static::where('book_id', $bookId)
                        ->orderBy('created_at')
                        ->first();
    }
    public static function removeUserFromList($userId, $bookId)
    {
        return static::where('user_id', $userId)
                        ->where('book_id', $bookId)
                        ->delete();
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BooksTableSeeder extends Seeder
{
    public function run(): void
    {
        $books = [
            [
                'title' => 'Naruto',
                'author' => 'Masashi Kishimoto',
                'isbn' => '9781569319000',
                'published_at' => '1999-09-21',
                'description' => 'The story of Naruto Uzumaki, a young ninja who seeks recognition from his peers and dreams of becoming the Hokage, the leader of his village.'
            ],
            [
                'title' => 'One Piece',
                'author' => 'Eiichiro Oda',
                'isbn' => '9781591160571',
                'published_at' => '1997-07-22',
                'description' => 'Follow the adventures of Monkey D. Luffy and his pirate crew in order to find the greatest treasure ever left by the legendary Pirate, Gold Roger.'
            ],
            [
                'title' => 'Attack on Titan',
                'author' => 'Hajime Isayama',
                'isbn' => '9781612620244',
                'published_at' => '2009-09-09',
                'description' => 'In a world where humanity resides within enormous walled cities to protect themselves from the Titans, gigantic humanoid creatures, Eren Yeager joins the fight against them.'
            ],
            [
                'title' => 'Dragon Ball',
                'author' => 'Akira Toriyama',
                'isbn' => '9781569319208',
                'published_at' => '1984-12-03',
                'description' => 'The adventures of Goku, who seeks out the Dragon Balls to summon a wish-granting dragon, while becoming the world\'s greatest martial artist.'
            ],
            [
                'title' => 'Death Note',
                'author' => 'Tsugumi Ohba',
                'isbn' => '9781421501680',
                'published_at' => '2003-12-01',
                'description' => 'A high school student discovers a supernatural notebook that allows him to kill anyone whose name he writes in it, leading him into a moral struggle with a detective known only as L.'
            ],
        ];

        foreach ($books as $book) {
            DB::table('books')->insert([
                'title' => $book['title'],
                'author' => $book['author'],
                'isbn' => $book['isbn'],
                'published_at' => $book['published_at'],
                'description' => $book['description'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

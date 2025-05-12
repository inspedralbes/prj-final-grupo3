<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;

class CommentSeeder extends Seeder
{
    public function run()
    {
        $texts = [
            'Aquest viatge sembla increïble!',
            'El paisatge era espectacular.',
            'Algú sap si es pot fer amb nens?',
            'Ideal per una escapada de cap de setmana.',
            'Ens va encantar! Tornarem segur.',
            'Una mica massa turístic per al meu gust.',
            'Perfecte per relaxar-se i desconnectar.',
            'Els restaurants locals són genials!',
            'Recomano portar calçat còmode!',
            'L’organització va ser excel·lent.',
            'Ens va ploure tot el viatge 😅',
            'Les fotos no fan justícia al lloc.',
            'Viure aquesta experiència ha estat únic.',
            'Ens va sorprendre molt positivament.',
            'Un destí imprescindible a la vida!',
        ];

        for ($tripId = 1; $tripId <= 18; $tripId++) {
            $numComments = rand(2, 3);

            for ($i = 0; $i < $numComments; $i++) {
                Comment::create([
                    'trip_id' => $tripId,
                    'user_id' => rand(1, 15),
                    'text' => $texts[array_rand($texts)],
                ]);
            }
        }
    }
}


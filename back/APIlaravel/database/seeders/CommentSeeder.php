<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\CommentLike;

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
            'El guia era molt professional i proper.',
            'Activitats per a totes les edats!',
            'L’allotjament superava les expectatives.',
            'L’experiència gastronòmica va ser brutal.',
            'Paisatges de pel·lícula, literalment!',
            'Un viatge que repetiríem sense dubtar-ho.',
            'Tot molt ben coordinat i segur.',
        ];

        for ($tripId = 1; $tripId <= 18; $tripId++) {
            $numComments = rand(2, 3);

            for ($i = 0; $i < $numComments; $i++) {
                $userId = rand(1, 15);

                $comment = Comment::create([
                    'trip_id' => $tripId,
                    'user_id' => $userId,
                    'text' => $texts[array_rand($texts)],
                    'rating' => rand(4, 5),
                ]);

                // Afegim de 0 a 3 likes d'usuaris diferents
                $numLikes = rand(0, 3);
                $likedUserIds = collect(range(1, 15))
                    ->filter(fn($id) => $id !== $userId) // no pot fer like ell mateix
                    ->shuffle()
                    ->take($numLikes);

                foreach ($likedUserIds as $likerId) {
                    CommentLike::create([
                        'comment_id' => $comment->id,
                        'user_id' => $likerId,
                    ]);
                }
            }
        }
    }
}

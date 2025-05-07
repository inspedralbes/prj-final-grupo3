<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecommendedTripsSeeder extends Seeder
{
    public function run()
    {
        $trips = [
            [
                'title' => 'Escapada a la Toscana',
                'description' => 'Gaudeix dels paisatges vinícoles i pobles medievals italians.',
                'cover_image' => 'https://upload.wikimedia.org/wikipedia/commons/0/0b/Toscana_panorama.jpg'
            ],
            [
                'title' => 'Aventura per Islàndia',
                'description' => 'Explora volcans, glaceres i aigües termals en un viatge inoblidable.',
                'cover_image' => 'https://upload.wikimedia.org/wikipedia/commons/e/e6/Sk%C3%B3gafoss-Iceland.jpg'
            ],
            [
                'title' => 'Descobrint el Japó',
                'description' => 'De temples antics a neons de Tòquio, un contrast cultural vibrant.',
                'cover_image' => 'https://upload.wikimedia.org/wikipedia/commons/f/fc/Kiyomizu-dera_in_Kyoto.jpg'
            ],
            [
                'title' => 'Costa Oest dels EUA',
                'description' => 'California, Nevada i Arizona en un roadtrip cinematogràfic.',
                'cover_image' => 'https://upload.wikimedia.org/wikipedia/commons/5/5c/Monument_Valley_view.jpg'
            ],
            [
                'title' => 'París romàntic',
                'description' => 'La ciutat de la llum amb la Torre Eiffel i passejades pel Sena.',
                'cover_image' => 'https://upload.wikimedia.org/wikipedia/commons/a/af/Tour_Eiffel_Wikimedia_Commons.jpg'
            ],
            [
                'title' => 'Selva amazònica del Perú',
                'description' => 'Una experiència salvatge i natural única.',
                'cover_image' => 'https://upload.wikimedia.org/wikipedia/commons/6/61/Amazon_Rainforest.jpg'
            ],
            [
                'title' => 'Safari a Kenya',
                'description' => 'Viu la fauna africana a Masai Mara.',
                'cover_image' => 'https://upload.wikimedia.org/wikipedia/commons/f/f7/Kenya_Masai_Mara_Lion.jpg'
            ],
            [
                'title' => 'Aurores boreals a Noruega',
                'description' => 'Un espectacle natural de llum al cercle polar.',
                'cover_image' => 'https://upload.wikimedia.org/wikipedia/commons/e/e7/Aurora_Norway.jpg'
            ],
            [
                'title' => 'Grècia clàssica',
                'description' => 'Atenes, Delfos i Meteora, història i paisatge en estat pur.',
                'cover_image' => 'https://upload.wikimedia.org/wikipedia/commons/9/99/Parthenon_in_Athens.jpg'
            ],
            [
                'title' => 'Madeira, natura atlàntica',
                'description' => 'Camins costaners, muntanyes verdes i oceà infinit.',
                'cover_image' => 'https://upload.wikimedia.org/wikipedia/commons/7/7f/Madeira_coast.jpg'
            ],
            [
                'title' => 'Vietnam de nord a sud',
                'description' => 'Hanoi, Halong Bay i el Delta del Mekong.',
                'cover_image' => 'https://upload.wikimedia.org/wikipedia/commons/f/fc/Halong_Bay_Vietnam.jpg'
            ],
            [
                'title' => 'Alps suïssos',
                'description' => 'Senderisme entre pics nevats i llacs blaus.',
                'cover_image' => 'https://upload.wikimedia.org/wikipedia/commons/b/bf/Swiss_Alps_in_summer.jpg'
            ],
            [
                'title' => 'Costa Brava',
                'description' => 'Caletes amagades i aigües cristal·lines.',
                'cover_image' => 'https://upload.wikimedia.org/wikipedia/commons/2/2e/Costa_Brava_Cadaques.jpg'
            ],
            [
                'title' => 'Istanbul i Capadòcia',
                'description' => 'On Orient i Occident es troben.',
                'cover_image' => 'https://upload.wikimedia.org/wikipedia/commons/3/39/Cappadocia_ballons.jpg'
            ],
            [
                'title' => 'Ruta pels Balcans',
                'description' => 'Història i natura a Croàcia i Bòsnia.',
                'cover_image' => 'https://upload.wikimedia.org/wikipedia/commons/1/1b/Mostar_Old_Bridge.jpg'
            ],
            [
                'title' => 'Berlín vibrant',
                'description' => 'Història recent, art urbà i vida nocturna.',
                'cover_image' => 'https://upload.wikimedia.org/wikipedia/commons/6/6d/Berliner_Dom_%28Berliner_Cathedral%29.jpg'
            ],
            [
                'title' => 'Camí de Santiago',
                'description' => 'Espiritualitat i natura del nord peninsular.',
                'cover_image' => 'https://upload.wikimedia.org/wikipedia/commons/5/5f/Camino_de_Santiago_Galicia.jpg'
            ],
            [
                'title' => 'Cap d’any a Nova York',
                'description' => 'Times Square i un inici d’any de pel·lícula.',
                'cover_image' => 'https://upload.wikimedia.org/wikipedia/commons/7/7f/New_York_Times_Square.jpg'
            ],            
        ];

        DB::table('recommended_trips')->insert($trips);
    }
}


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
                'cover_image' => 'https://encrypted-tbn0.gstatic.com/licensed-image?q=tbn:ANd9GcQdLOPRO8HwPGJDfq0jDpRB7p4_jqIxycxbuyLQcYiTBtz6L9D-KLvhvrTctnZNT8x5yJ_kkJ7k2ZjuSQ3ZtB8yuP4rR2I8_J6Re7SOIg',
                'description2' => "Dia 1: Arribada a Florència i visita al Duomo, Galeria Uffizi i passeig pel riu Arno.\nDia 2: Excursió per la regió vinícola de Chianti amb tast de vins i dinar en vinya.\nDia 3: Trasllat a Siena i descoberta del centre històric amb la Piazza del Campo.\nDia 4: San Gimignano, poble medieval amb les seves torres i mercat local.\nDia 5: Relax entre vinyes i terme romà a Rapolano Terme. Tornada a Florència al vespre."
            ],
            [
                'title' => 'Aventura per Islàndia',
                'description' => 'Explora volcans, glaceres i aigües termals en un viatge inoblidable.',
                'cover_image' => 'https://encrypted-tbn3.gstatic.com/licensed-image?q=tbn:ANd9GcROJg2dysllZ4UIPGvQMHflx4-W2TMm_e7RhF41Sja-_8wIPhfaMUOD5-94zUZD4wLNHi4_2I6qjX6COzy7bu09yt0rQCaELmGslIWgIg',
                'description2' => "Dia 1: Reykjavik, bany a la Blue Lagoon i passeig pel port.\nDia 2: Cercle d'Or: Thingvellir (falla tectònica), Geysir i cascada Gullfoss.\nDia 3: Ruta sud amb platges de sorra negra a Vík i glaceres a Skaftafell.\nDia 4: Jökulsárlón i Diamond Beach, amb navegació entre icebergs.\nDia 5: Tornada per la costa i parada a Skógafoss i Seljalandsfoss.\nDia 6: Exploració de volcans com Hekla i zona geotèrmica de Reykjadalur."
            ],
            [
                'title' => 'Descobrint el Japó',
                'description' => 'De temples antics a neons de Tòquio, un contrast cultural vibrant.',
                'cover_image' => 'https://www.kulturalia.es/wp-content/uploads/2022/10/con-la-primavera-in-giappone.jpg',
                'description2' => "Dia 1: Tòquio - visita a Asakusa, Senso-ji i creuament de Shibuya.\nDia 2: Torre de Tòquio, museu Ghibli i parc de Ueno amb museus.\nDia 3: Excursió al Fuji, llac Kawaguchi i onsen tradicional.\nDia 4: Kyoto - Fushimi Inari, santuari de milers de torii i sopar kaiseki.\nDia 5: Arashiyama, bosc de bambú i temples zen com Tenryu-ji.\nDia 6: Excursió a Nara i parc dels cérvols sagrats.\nDia 7: Osaka: castell, carrer Dotonbori i gastronomia de carrer."
            ],
            [
                'title' => 'Costa Oest dels EUA',
                'description' => 'California, Nevada i Arizona en un roadtrip cinematogràfic.',
                'cover_image' => 'https://common.usembassy.gov/wp-content/uploads/sites/58/2023/04/iStock-1370552280-300x158.jpg',
                'description2' => "Dia 1: Arribada a Los Angeles, Hollywood Boulevard i Santa Monica Pier.\nDia 2: Ruta cap a San Diego i platges del Pacífic. Visita a La Jolla i Gaslamp.\nDia 3: Mojave Desert i nit a Las Vegas amb espectacles i llums de neó.\nDia 4: Excursió al Gran Canó, miradors Sud i vol opcional en helicòpter.\nDia 5: Route 66 cap a Death Valley, dunes i cràters volcànics.\nDia 6: Yosemite, caminades entre sequoies i El Capitán.\nDia 7: San Francisco, Golden Gate, Alcatraz i carrer Lombard."
            ],
            [
                'title' => 'París romàntic',
                'description' => 'La ciutat de la llum amb la Torre Eiffel i passejades pel Sena.',
                'cover_image' => 'https://img.static-af.com/transform/45cb9a13-b167-4842-8ea8-05d0cc7a4d04/',
                'description2' => "Dia 1: Arribada a París i ascens a la Torre Eiffel, passeig pel Sena.\nDia 2: Museu del Louvre, Notre-Dame i creuer amb sopar.\nDia 3: Montmartre, Sacré-Cœur i cafè artístic.\nDia 4: Excursió al Palau de Versalles i jardins de Le Nôtre.\nDia 5: Passeig pel barri Llatí, jardins de Luxemburg i Opera Garnier."
            ],
            [
                'title' => 'Selva amazònica del Perú',
                'description' => 'Una experiència salvatge i natural única.',
                'cover_image' => 'https://www.peru.travel/Contenido/AcercaDePeru/Imagen/es/1/0.0/Principal/Machu%20Picchu.jpg',
                'description2' => "Dia 1: Vol a Iquitos, navegació pel riu Amazones i allotjament en ecolodge.\nDia 2: Caminades guiades per la selva, observació d'aus i plantes medicinals.\nDia 3: Visita a comunitats locals i pesca tradicional de piranyes.\nDia 4: Exploració nocturna per veure fauna activa.\nDia 5: Tornada amb parades al mercat flotant de Belén."
            ],
            [
                'title' => 'Safari a Kenya',
                'description' => 'Viu la fauna africana a Masai Mara.',
                'cover_image' => 'https://media.istockphoto.com/id/697689066/es/foto/tres-jirafas-en-el-parque-nacional-de-kenia.jpg?s=612x612&w=0&k=20&c=i6zk-5Q7DCAIVOhZmf2PXwuMLM7iipO4Iz_jtXWiLMI=',
                'description2' => "Dia 1: Nairobi i centre de girafes.\nDia 2: Trasllat a Masai Mara, safari a la tarda.\nDia 3: Safari al matí i visita a una vila Masai.\nDia 4: Safari complet i observació de lleons, zebres i elefants.\nDia 5: Tornada i sopar africà amb música tribal."
            ],
            [
                'title' => 'Aurores boreals a Noruega',
                'description' => 'Un espectacle natural de llum al cercle polar.',
                'cover_image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQlfqx4orgFg0u5y8QqNoGzHePB1FmrRrx9-w&s',
                'description2' => "Dia 1: Arribada a Tromsø i visita al museu Polar.\nDia 2: Ruta amb trineu de gossos i primer intent d'aurora.\nDia 3: Safari fotogràfic nocturn amb guia expert.\nDia 4: Visita a poble Sami i alimentació de rens.\nDia 5: Relax a un lodge de fusta amb banyera d’hidromassatge exterior."
            ],
            [
                'title' => 'Grècia clàssica',
                'description' => 'Atenes, Delfos i Meteora, història i paisatge en estat pur.',
                'cover_image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRedfqo3zfMHsUtk34ZRMKTU342T8zR2XHHNw&s',
                'description2' => "Dia 1: Acròpolis d’Atenes i barri de Plaka.\nDia 2: Viatge a Delfos i el Temple d’Apol·lo.\nDia 3: Kalambaka i monestirs de Meteora.\nDia 4: Tornada a Atenes amb parada a Termòpiles.\nDia 5: Passeig pel port del Pireu i sopar amb música grega."
            ],
            [
                'title' => 'Madeira, natura atlàntica',
                'description' => 'Camins costaners, muntanyes verdes i oceà infinit.',
                'cover_image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSOA6JSKimdrfHfu1ecARJDleD4Bp4diIPRgg&s',
                'description2' => "Dia 1: Funchal i jardí botànic, mercat de fruits locals.\nDia 2: Excursió a Cabo Girão i rutes per levadas.\nDia 3: Nord de l’illa: São Vicente i boscos laurisilva.\nDia 4: Cursa d'observació de dofins i balenes.\nDia 5: Relax en piscines naturals de Porto Moniz."
            ],
            [
                'title' => 'Vietnam de nord a sud',
                'description' => 'Hanoi, Halong Bay i el Delta del Mekong.',
                'cover_image' => 'https://queverentusviajes.com/wp-content/uploads/2021/12/Que-ver-en-Vietnam-en-10-dias-1.jpg',
                'description2' => "Dia 1: Hanoi - Temple de la Literatura i teatre de titelles d’aigua.\nDia 2: Creuer de 2 dies a la badia de Halong amb nit a bord.\nDia 3: Trasllat a Hué i ciutat imperial.\nDia 4: Hoi An, mercats i llums de paper.\nDia 5: Delta del Mekong, mercats flotants i viles locals.\nDia 6: Ho Chi Minh, museu de la guerra i túnels de Cu Chi."
            ],
            [
                'title' => 'Alps suïssos',
                'description' => 'Senderisme entre pics nevats i llacs blaus.',
                'cover_image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTXlOm-nMd0CGXVTBQiiE_Z4UKOxWICY_bd8g&s',
                'description2' => "Dia 1: Lucerna i llac dels Quatre Cantons.\nDia 2: Tren panoràmic Glacier Express fins a Zermatt.\nDia 3: Ascens al Gornergrat i vistes al Cerví.\nDia 4: Caminada per Lauterbrunnen i cascades interiors.\nDia 5: Relax a Interlaken i banys termals."
            ],
            [
                'title' => 'Costa Brava',
                'description' => 'Caletes amagades i aigües cristal·lines.',
                'cover_image' => 'https://pohcdn.com/sites/default/files/styles/paragraph__live_banner__lb_image__1880bp/public/live_banner/Costa-Brava.jpg',
                'description2' => "Dia 1: Tossa de Mar i muralles medievals.\nDia 2: Caminada pel Camí de Ronda fins a Cala Pola.\nDia 3: Visita a Calella de Palafrugell i Llafranc.\nDia 4: Dalí a Cadaqués i Portlligat.\nDia 5: Banys i relax a Begur i Illes Medes."
            ],
            [
                'title' => 'Istanbul i Capadòcia',
                'description' => 'On Orient i Occident es troben.',
                'cover_image' => 'https://s3.eu-west-1.amazonaws.com/itpweb/banner/doc/39edae9064f1e64e99aa5dd6357d6520-636e07c0c06e5.webp',
                'description2' => "Dia 1: Istanbul, Santa Sofia i Cisterna Basílica.\nDia 2: Mesquita Blava, Gran Bazar i creuer pel Bòsfor.\nDia 3: Vol a Capadòcia, posta de sol des de Göreme.\nDia 4: Vol en globus i vall dels camins de fades.\nDia 5: Tornada a Istanbul i bany turc tradicional."
            ],
            [
                'title' => 'Ruta pels Balcans',
                'description' => 'Història i natura a Croàcia i Bòsnia.',
                'cover_image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQJNIsMGxAfxQmQM6sVSLL83irE6RdVwDDbyQ&s',
                'description2' => "Dia 1: Dubrovnik i muralles medievals.\nDia 2: Kotor (Montenegro), fiord i casc antic.\nDia 3: Mostar, pont otomà i cultura musulmana.\nDia 4: Sarajevo, museus de la guerra i menjars locals.\nDia 5: Parc Nacional de Plitvice i llacs turquesa."
            ],
            [
                'title' => 'Berlín vibrant',
                'description' => 'Història recent, art urbà i vida nocturna.',
                'cover_image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQDcF7mqXr5XtMUDunZjt8okqXQBnK_U3FitA&s',
                'description2' => "Dia 1: Porta de Brandenburg i Reichtag.\nDia 2: Memorial a l’Holocaust i Checkpoint Charlie.\nDia 3: Museu de Pèrgam i barri de Mitte.\nDia 4: Galeria East Side i street art a Kreuzberg.\nDia 5: Mercat de Mauerpark i ambient alternatiu."
            ],
            [
                'title' => 'Camí de Santiago',
                'description' => 'Espiritualitat i natura del nord peninsular.',
                'cover_image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS_Nl6CDYAlkP2ljU56ziD0PCwknjgTtqrqEQ&s',
                'description2' => "Dia 1: Sarria - Portomarín.\nDia 2: Portomarín - Palas de Rei.\nDia 3: Palas - Arzúa.\nDia 4: Arzúa - Monte do Gozo.\nDia 5: Santiago - Catedral i missa del pelegrí."
            ],
            [
                'title' => 'Cap d’any a Nova York',
                'description' => 'Times Square i un inici d’any de pel·lícula.',
                'cover_image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRVALvxP30ycdpAP8SvKfP9DbOr0BOJzAd1XQ&s',
                'description2' => "Dia 1: Central Park, 5a Avinguda i Rockefeller.\nDia 2: Estatua de la Llibertat i Ellis Island.\nDia 3: Metropolitan i Harlem Gospel.\nDia 4: Preparatius i sopar de Cap d’Any.\nDia 5: Ball drop a Times Square i brunch al Soho."
            ]
        ];

        DB::table('recommended_trips')->insert($trips);
    }
}

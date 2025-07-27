<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Poljoprivreda i prehrambena industrija',
                'description' => 'Proizvodnja hrane, organski proizvodi, med, voće, povrće, mlečni proizvodi, domaće delicije',
                'icon' => '🌱'
            ],
            [
                'name' => 'Zanatstvo i ručni rad',
                'description' => 'Tradicionalni zanati, ručno tkanje, keramika, drvorezbarstvo, umetničke kreacije, suveniri',
                'icon' => '🎨'
            ],
            [
                'name' => 'Usluge i servisi',
                'description' => 'Popravke, čišćenje, održavanje, transport, dostava, tehničke usluge',
                'icon' => '⚙️'
            ],
            [
                'name' => 'Trgovina na malo',
                'description' => 'Prodaja proizvoda, online trgovina, lokalni dućani, specijalizovane radnje',
                'icon' => '🏪'
            ],
            [
                'name' => 'IT i digitalne usluge',
                'description' => 'Web dizajn, programiranje, digitalni marketing, online usluge, IT podrška',
                'icon' => '💻'
            ],
            [
                'name' => 'Kreativne delatnosti',
                'description' => 'Grafički dizajn, fotografija, video produkcija, muzika, pisanje, umetnost',
                'icon' => '📸'
            ],
            [
                'name' => 'Wellness i zdravstvo',
                'description' => 'Masaža, fizioterapija, alternativna medicina, wellness usluge, nega tela',
                'icon' => '💆'
            ],
            [
                'name' => 'Edukacija i obuka',
                'description' => 'Privatni časovi, kursevi, radionice, online obuka, konsalting u obrazovanju',
                'icon' => '📚'
            ],
            [
                'name' => 'Turizam i ugostiteljstvo',
                'description' => 'Smeštaj, turističke usluge, lokalni vodiči, agroturizam, restorani',
                'icon' => '🏨'
            ],
            [
                'name' => 'Konsalting i savetovanje',
                'description' => 'Poslovni konsalting, pravni saveti, finansijske usluge, stručno savetovanje',
                'icon' => '💼'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
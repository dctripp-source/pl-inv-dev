<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Business;
use App\Models\Category;

class BusinessSeeder extends Seeder
{
    public function run()
    {
        $poljoprivreda = Category::where('name', 'like', '%Poljoprivreda%')->first();
        $zanatstvo = Category::where('name', 'like', '%Zanatstvo%')->first();
        $usluge = Category::where('name', 'like', '%Usluge%')->first();

        // Demo biznis 1 - Pčelarstvo
        $business1 = Business::create([
            'owner_first_name' => 'Marko',
            'owner_last_name' => 'Petrović',
            'business_name' => 'Pčelarstvo Zlatni Med',
            'description' => 'Proizvodimo prirodni med, pčelinji vosak i propolis. Naši proizvodi su 100% prirodni, bez ikakvih dodataka. Imamo dugogodišnje iskustvo u pčelarstvu i nudimo kvalitetne proizvode direktno od proizvođača.',
            'services' => 'Prodaja meda, pčelinjeg voska, propolisa, matičnih mleča. Edukacija o pčelarstvu.',
            'phone' => '065-123-456',
            'email' => 'marko@zlatnimed.ba',
            'address' => 'Sela bb',
            'city' => 'Banja Luka',
            'website' => 'www.zlatnimed.ba',
            'status' => 'approved',
            'approved_at' => now(),
        ]);
        
        if ($poljoprivreda) {
            $business1->categories()->attach($poljoprivreda->id);
        }

        // Demo biznis 2 - Keramika
        $business2 = Business::create([
            'owner_first_name' => 'Ana',
            'owner_last_name' => 'Mitrović',
            'business_name' => 'Keramička radionica Glina',
            'description' => 'Ručno izrađujemo keramičke proizvode: vaze, činije, ukrasne predmete. Svaki proizvod je jedinstven i izrađen s ljubavlju. Organizujemo i radionice za decu i odrasle.',
            'services' => 'Keramički proizvodi, radionice keramike, personalizovani pokloni.',
            'phone' => '066-789-123',
            'email' => 'ana@glina.ba',
            'address' => 'Krajišnika 15',
            'city' => 'Banja Luka',
            'status' => 'approved',
            'approved_at' => now(),
        ]);
        
        if ($zanatstvo) {
            $business2->categories()->attach($zanatstvo->id);
        }

        // Demo biznis 3 - Pending biznis
        $business3 = Business::create([
            'owner_first_name' => 'Stefan',
            'owner_last_name' => 'Nikolić',
            'business_name' => 'IT Podrška Stefan',
            'description' => 'Pružam IT usluge za mala preduzeća: instalacija softvera, popravka računara, održavanje mreža. Iskustvo od 10 godina u IT sektoru.',
            'services' => 'Popravka računara, instalacija softvera, IT konsalting.',
            'phone' => '067-456-789',
            'email' => 'stefan@itpodrska.ba',
            'address' => 'Bulevar cara Dušana 23',
            'city' => 'Banja Luka',
            'status' => 'pending',
        ]);
        
        if ($usluge) {
            $business3->categories()->attach($usluge->id);
        }
    }
}
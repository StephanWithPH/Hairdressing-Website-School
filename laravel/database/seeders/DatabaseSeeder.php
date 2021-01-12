<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Treatment;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $ownerRole = new Role();
        $ownerRole->name = 'Eigenaresse';
        $ownerRole->identifier = 'owner';
        $ownerRole->save();

        $employeeRole = new Role();
        $employeeRole->name = 'Medewerker';
        $employeeRole->identifier = 'employee';
        $employeeRole->save();

        \App\Models\User::factory(1)->create([
            'role_id' => 1,
        ]);

        $treatments = [
            [
                "name" => "Krullen Knippen",
                "description" => "Uw krullen worden zorgvuldig geknipt in onze salon.",
                "price" => "47.5",
                "image" => '/img/krullenknippen.jpg',
            ],
            [
                "name" => "Krullen Knippen + Healthy Hair Boost",
                "description" => "Uw krullen worden zorgvuldig geknipt en we zorgen ervoor dat uw haar er nog voller uit ziet.",
                "price" => "64",
                "image" => '/img/healthyhairboost.jpg',
            ],
            [
                "name" => "Dames Knippen",
                "description" => "De reguliere knipbeurt voor dames. Uw haar wordt zorgvuldig geknipt onder het gemak van een bakje koffie.",
                "price" => "29",
                "image" => '/img/damesknippen.jpg',
            ],
            [
                "name" => "Kids tot 12 jaar",
                "description" => "Voor kinderen tot 12 jaar geldt een speciaal tarief.",
                "price" => "23",
                "image" => '/img/kidshaircut.jpg',
            ],
            [
                "name" => "Kleuren",
                "description" => "Het kleuren van uw haar kan volledig naar wens. We bieden verschillende kleurtinten aan. Informeer naar de mogelijkheden.",
                "price" => "41",
                "image" => '/img/haircolor.jpg',
            ],
            [
                "name" => "Fohnen",
                "description" => "We fohnen uw haar met onze speciale krullenfohn. Dit zorgt ervoor dat uw krullen er weer vol en natuurlijk uit zien.",
                "price" => "19.5",
                "image" => '/img/blowdrying.jpg',
            ],
            [
                "name" => "Heren Knippen",
                "description" => "De reguliere knipbeurt voor heren. Uw haar wordt zorgvuldig geknipt onder het gemak van een bakje koffie.",
                "price" => "24.5",
                "image" => '/img/haircutmale.jpg',
            ],
            [
                "name" => "Highlights",
                "description" => "We maken gedeeltes van uw haar een iets lichtere kleur. Dit geeft een modernere uitstraling.",
                "price" => "43",
                "image" => '/img/highlights.jpg',
            ],
            [
                "name" => "Balayage Compleet",
                "description" => "Voor de ultieme verzorging van uw krullen bieden we deze alles in één behandeling aan. We knippen, krullen, kleuren en fohnen uw haar en brengen optioneel highlights aan.",
                "price" => "149",
                "image" => '/img/healthyhairboost.jpg',
            ],
            [
                "name" => "Hoofdhuid Analyse",
                "description" => "Last van een jeukende hoofdhuid? Of denkt u last te hebben van ernstige roos? Met de hoofdhuid analyse komt u erachter hoe de problemen verholpen kunnen worden.",
                "price" => "15",
                "image" => '/img/skinanalysis.jpg',
            ],
            [
                "name" => "Healthy Hair Boost",
                "description" => "We wassen uw haar met speciale shampoo om te zorgen dat uw haar er nog voller uit ziet.",
                "price" => "27",
                "image" => '/img/healthyhairboost.jpg',
            ],
        ];

        foreach($treatments as $treatment){
            $newTreatment = new Treatment();
            $newTreatment->name = $treatment['name'];
            $newTreatment->description = $treatment['description'];
            $newTreatment->price = $treatment['price'];
            $newTreatment->image = $treatment['image'];
            $newTreatment->save();

        }
    }
}

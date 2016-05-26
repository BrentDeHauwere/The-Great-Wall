<?php

use Illuminate\Database\Seeder;

class WallsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('walls')->insert([
            ['user_id' => 1, 'name' => 'Social Engineering', 'description' => 'Technische mensen kijken voornamelijk naar security vanuit een technisch standpunt. Zijn systemen gepatcht? Zijn alle SQL-injectieproblemen eruit gehaald? De waarheid is echter dat het technische aspect van beveiliging slechts een klein onderdeel is. De mens is het grootste beveiligingsprobleem. “Social Engineering” is het manipuleren van mensen zodat ze je informatie geven (of toegang tot systemen of ruimtes). In de meeste gevallen is het gemakkelijker om op die manier aan informatie te komen dan via een technische aanval. In dit praatje zal Walter Belgers ingaan op hoe social engineering in zijn werk gaat, hoe je scenario’s bedenkt en hoe je aanvallen tegenhoudt. De lezing bevat voorbeelden uit echte social engineering-opdrachten en enkele grappige filmpjes', 'open_until' => null],
            ['user_id' => 2, 'name' => 'Creative Hacking', 'description' => 'Vergeet de traditionele technieken en sla je eigen weg in. Ontdek hoe je met de simpelste dingen, zoals één teken, de veiligheid kunt doorprikken. Leer waar en hoe je naar lekken moet zoeken. Word een ethische hacker en strijk naast ervaring én eer ook een aardig zakcentje op! De inhoud is geschikt voor zowel nieuwelingen als gevorderden, met praktische voorbeelden bij o.a. Facebook en Google. Inti kennende wordt de gehele keynote zeer boeiend aan elkaar gepraat met de nodige humor en anekdotes! Na de presentatie kan je de theorie meteen omzetten in de praktijk in de hacking corners. Meet je skills binnen een testomgeving of hack meteen échte bedrijven via HackerOne. Wie weet ga je wel naar huis met een mooie beloning?', 'open_until' => null],
            ['user_id' => 5, 'name' => 'Discovering Programming Languages', 'description' => 'We vragen onszelf vaak af waarom een bepaalde constructie in een programmeertaal bestaat wanneer wij onze eigen ruiten ermee ingooien. We vervloeken de exceptions die we voorgeschoteld krijgen wanneer wij een nulverwijzing (null pointer) proberen aanspreken. Daarbij zoeken we soms uren naar een off-by-one-fout veroorzaakt door een lus. We geven de veiligheid van een typesysteem op voor snelle hacks tijdens het modelleren en beklagen het ons wanneer we op bugs jagen voor de laatste deadline. Al deze problemen vloeien voort uit het ontwerp van de meeste programmeertalen. Het garandeert optimale prestaties op de machine die ons zo nauw aan het hart ligt, maar tegen de prijs van gebruiksgemak en gemakkelijk redeneren over programma’s. Dan ligt één vraag voor de hand : hoe zouden programmeertalen eruitzien als wij ze zouden ontdekken voor mensen in plaats van ze te ontwerpen voor een machine? Wat als er geen machine was?', 'open_until' => null],
            ['user_id' => 4, 'name' => 'Toegankelijkheid web: #a11y', 'description' => 'In deze keynote gaat Mathias in op het belang van toegankelijkheid op het web. Waarom zou je erin willen investeren? Hoe begin je eraan? Sta je alleen voor, of bestaan er hulplijnen? Wat zijn goede en slechte voorbeelden van toegankelijke websites? Deze presentatie beperkt zich tot toegankelijkheid voor toetsenborden (navigeren zonder muiscursor) en screenreaders. Bij dit laatste passeren onder meer de revue: Wat is een screenreader? Hoe gebruikt een persoon met een visuele beperking dit hulpmiddel om een computer te gebruiken? Wat is ARIA? Hoe kan een website semantisch ingedeeld worden om navigeren te vereenvoudigen?', 'open_until' => null],
        ]);

        DB::table('walls')->insert([
           ['user_id' => 6, 'name' => 'The Secret Wall', 'description' => 'The password is "secret"', 'open_until' => null, 'password' => Hash::make("secret")],
        ]);

        DB::table('walls')->insert([
            ['user_id' => 7, 'name' => 'Ehb Main Wall', 'description' => null, 'open_until' => null, 'hashtag' => 'ehackb'],
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin Principal',
            'email' => 'admin@eventflow.ma',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Organisateur 1
        $org1 = User::create([
            'name' => 'Karim Benali',
            'email' => 'karim@eventflow.ma',
            'password' => Hash::make('password'),
            'role' => 'organisateur',
            'phone' => '+212 6 00 11 22 33',
            'is_active' => true,
        ]);

        // Organisateur 2
        $org2 = User::create([
            'name' => 'Fatima Zahra',
            'email' => 'fatima@eventflow.ma',
            'password' => Hash::make('password'),
            'role' => 'organisateur',
            'phone' => '+212 6 44 55 66 77',
            'is_active' => true,
        ]);

        // Agent pour org1
        $agent = User::create([
            'name' => 'Ahmed Tazi',
            'email' => 'agent@eventflow.ma',
            'password' => Hash::make('password'),
            'role' => 'agent',
            'organisateur_id' => $org1->id,
            'is_active' => true,
        ]);

        // Événements pour org1
        $event1 = Event::create([
            'organisateur_id' => $org1->id,
            'title' => 'Mariage Benali - Chraibi',
            'description' => 'La cérémonie de mariage de Karim et Sara dans un cadre exceptionnel.',
            'type' => 'mariage',
            'date_start' => now()->addDays(30),
            'date_end' => now()->addDays(30)->addHours(8),
            'venue' => 'Palais des Roses',
            'address' => 'Boulevard Mohammed V',
            'city' => 'Marrakech',
            'capacity' => 300,
            'status' => 'publie',
            'is_paid' => false,
        ]);

        Event::create([
            'organisateur_id' => $org1->id,
            'title' => 'Conférence Tech Maroc 2026',
            'description' => 'Conférence annuelle sur les nouvelles technologies au Maroc.',
            'type' => 'conference',
            'date_start' => now()->addDays(15),
            'date_end' => now()->addDays(15)->addHours(6),
            'venue' => 'Centre de Conférences Mohammed VI',
            'address' => 'Avenue Hassan II',
            'city' => 'Casablanca',
            'capacity' => 500,
            'status' => 'publie',
            'is_paid' => true,
            'price' => 250,
            'currency' => 'DJF',
        ]);

        // Événement pour org2
        Event::create([
            'organisateur_id' => $org2->id,
            'title' => 'Anniversaire 30 ans - Fatima',
            'description' => 'Fête d\'anniversaire exceptionnelle pour les 30 ans de Fatima.',
            'type' => 'anniversaire',
            'date_start' => now()->addDays(7),
            'date_end' => now()->addDays(7)->addHours(5),
            'venue' => 'Le Baroque Club',
            'address' => 'Rue Al Massira',
            'city' => 'Rabat',
            'capacity' => 80,
            'status' => 'brouillon',
            'is_paid' => false,
        ]);

        // Assigner agent à event1
        $event1->staff()->attach($agent->id, ['role' => 'agent']);

        // Créer des invités pour event1
        $guestNames = [
            ['name' => 'Mohammed Alami', 'email' => 'malami@example.com', 'phone' => '+212 6 10 20 30 40', 'status' => 'confirme'],
            ['name' => 'Aicha Benkirane', 'email' => 'aicha@example.com', 'phone' => '+212 6 20 30 40 50', 'status' => 'confirme'],
            ['name' => 'Hassan Rida', 'email' => null, 'phone' => '+212 6 30 40 50 60', 'status' => 'invite'],
            ['name' => 'Sara Chraibi', 'email' => 'sara@example.com', 'phone' => null, 'status' => 'present'],
            ['name' => 'Omar Fassi', 'email' => 'omar@example.com', 'phone' => '+212 6 40 50 60 70', 'status' => 'invite'],
        ];

        foreach ($guestNames as $guestData) {
            $guest = $event1->guests()->create($guestData);
            Ticket::create([
                'uuid' => Str::uuid()->toString(),
                'event_id' => $event1->id,
                'guest_id' => $guest->id,
                'status' => $guest->status === 'present' ? 'valide' : 'actif',
                'validated_at' => $guest->status === 'present' ? now() : null,
                'validated_by' => $guest->status === 'present' ? $agent->id : null,
            ]);
        }

        $this->command->info('Base de données initialisée avec succès !');
        $this->command->table(
            ['Rôle', 'Email', 'Mot de passe'],
            [
                ['Admin', 'admin@eventflow.ma', 'password'],
                ['Organisateur 1', 'karim@eventflow.ma', 'password'],
                ['Organisateur 2', 'fatima@eventflow.ma', 'password'],
                ['Agent', 'agent@eventflow.ma', 'password'],
            ]
        );
    }
}

<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\RegistrationCategory;
use App\Models\Room;
use App\Models\ThematicArea;
use App\Settings\EventSettings;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DemoEventSeeder extends Seeder
{
    public function run(): void
    {
        // === Event ===
        $event = Event::firstOrCreate(
            ['slug' => 'congresia-demo'],
            [
                'name' => '5es Journées Scientifiques des Sciences de la Santé',
                'tagline' => 'IA et Santé',
                'theme' => 'IA et Santé',
                'description' => "Plateforme événementielle dédiée aux Journées Scientifiques 2026 de la Faculté des Sciences de la Santé de Cotonou. Trois jours d'échanges scientifiques autour de l'intelligence artificielle au service de la santé.",
                'starts_at' => '2026-09-09 08:00:00',
                'ends_at' => '2026-09-11 18:00:00',
                'timezone' => 'Africa/Porto-Novo',
                'venue_name' => 'Auditorium Faculté des Sciences de la Santé',
                'venue_city' => 'Cotonou',
                'venue_country' => 'BJ',
                'status' => 'registration_open',
                'registration_opens_at' => '2026-04-01 00:00:00',
                'registration_closes_at' => '2026-09-08 23:59:59',
                'abstracts_open_at' => '2026-04-01 00:00:00',
                'abstracts_close_at' => '2026-07-31 23:59:59',
                'max_capacity' => 1000,
                'is_active' => true,
            ],
        );

        // === Thématiques scientifiques ===
        $themes = [
            ['Imagerie médicale & IA', '#0ea5e9'],
            ['IA en cardiologie', '#ef4444'],
            ['Oncologie & IA', '#f59e0b'],
            ['Santé publique & big data', '#10b981'],
            ['Médecine de précision', '#8b5cf6'],
            ['IA & médecine d\'urgence', '#f43f5e'],
            ['Éthique & IA en santé', '#64748b'],
            ['Pédagogie médicale numérique', '#06b6d4'],
            ['Pharmacologie & ML', '#84cc16'],
            ['e-Santé & téléconsultation', '#ec4899'],
        ];
        foreach ($themes as $i => [$name, $color]) {
            ThematicArea::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name, 'color' => $color, 'display_order' => $i, 'is_active' => true],
            );
        }

        // === Catégories tarifaires (FCFA, marché UEMOA) ===
        $categories = [
            [
                'slug' => 'member',
                'name' => 'Membre',
                'description' => 'Membre actif d\'une société savante partenaire.',
                'price_early_bird' => 30000,
                'price_standard' => 45000,
                'price_late' => 60000,
                'early_bird_until' => '2026-06-30 23:59:59',
                'standard_until' => '2026-08-31 23:59:59',
                'is_public' => true,
                'is_active' => true,
                'display_order' => 1,
            ],
            [
                'slug' => 'non-member',
                'name' => 'Non-membre',
                'description' => 'Professionnel de santé.',
                'price_early_bird' => 50000,
                'price_standard' => 75000,
                'price_late' => 100000,
                'early_bird_until' => '2026-06-30 23:59:59',
                'standard_until' => '2026-08-31 23:59:59',
                'is_public' => true,
                'is_active' => true,
                'display_order' => 2,
            ],
            [
                'slug' => 'student',
                'name' => 'Étudiant',
                'description' => 'Étudiants en médecine, pharmacie, kiné, sage-femme, infirmier (justificatif obligatoire).',
                'price_early_bird' => 10000,
                'price_standard' => 15000,
                'price_late' => 20000,
                'early_bird_until' => '2026-06-30 23:59:59',
                'standard_until' => '2026-08-31 23:59:59',
                'requires_proof' => true,
                'is_public' => true,
                'is_active' => true,
                'display_order' => 3,
            ],
            [
                'slug' => 'resident',
                'name' => 'Interne / Résident',
                'description' => 'Interne en spécialité (justificatif obligatoire).',
                'price_early_bird' => 20000,
                'price_standard' => 30000,
                'price_late' => 40000,
                'early_bird_until' => '2026-06-30 23:59:59',
                'standard_until' => '2026-08-31 23:59:59',
                'requires_proof' => true,
                'is_public' => true,
                'is_active' => true,
                'display_order' => 4,
            ],
            [
                'slug' => 'sponsor',
                'name' => 'Délégué sponsor',
                'description' => 'Délégué d\'un partenaire/sponsor (sur invitation).',
                'price_early_bird' => 0,
                'price_standard' => 0,
                'price_late' => 0,
                'is_public' => false,
                'is_active' => true,
                'display_order' => 99,
            ],
        ];
        foreach ($categories as $cat) {
            RegistrationCategory::firstOrCreate(['slug' => $cat['slug']], $cat + ['currency' => 'XOF']);
        }

        // === Salles ===
        $rooms = [
            ['Auditorium principal', 800, '#0ea5e9'],
            ['Salle A', 150, '#f59e0b'],
            ['Salle B', 150, '#10b981'],
            ['Salle C', 80, '#8b5cf6'],
            ['Espace poster', 200, '#ec4899'],
        ];
        foreach ($rooms as $i => [$name, $capacity, $color]) {
            Room::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name, 'capacity' => $capacity, 'color' => $color, 'display_order' => $i, 'is_active' => true],
            );
        }

        // === Synchroniser le settings event.* avec l'Event ===
        $settings = app(EventSettings::class);
        $settings->name = $event->name;
        $settings->tagline = $event->tagline ?? '';
        $settings->theme = $event->theme;
        $settings->start_date = $event->starts_at;
        $settings->end_date = $event->ends_at;
        $settings->timezone = $event->timezone;
        $settings->venue_name = $event->venue_name;
        $settings->venue_city = $event->venue_city;
        $settings->venue_country = $event->venue_country;
        $settings->registration_open_at = $event->registration_opens_at;
        $settings->registration_close_at = $event->registration_closes_at;
        $settings->abstracts_open_at = $event->abstracts_open_at;
        $settings->abstracts_close_at = $event->abstracts_close_at;
        $settings->save();

        $this->command->info(sprintf(
            '✓ Event "%s" créé avec %d thématiques, %d catégories tarifaires, %d salles',
            $event->name,
            ThematicArea::count(),
            RegistrationCategory::count(),
            Room::count(),
        ));
    }
}

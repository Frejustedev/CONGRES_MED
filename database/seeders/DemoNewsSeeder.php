<?php

namespace Database\Seeders;

use App\Models\NewsArticle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DemoNewsSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'category' => 'announcement',
                'title' => 'Les inscriptions Early Bird sont ouvertes !',
                'subtitle' => 'Économisez jusqu\'à 50 % en vous inscrivant avant le 30 juin',
                'excerpt' => "Profitez du tarif Early Bird jusqu'au 30 juin 2026 pour économiser sur votre inscription. Tous les détails et catégories disponibles.",
                'body' => "L'inscription au congrès est désormais ouverte ! Pendant cette première période, vous bénéficiez du **tarif Early Bird** : économisez jusqu'à 50 % par rapport au tarif Late.\n\n## Catégories disponibles\n\n- **Membre** : 30 000 FCFA (au lieu de 60 000)\n- **Non-membre** : 50 000 FCFA (au lieu de 100 000)\n- **Étudiant** : 10 000 FCFA (justificatif requis)\n- **Interne/Résident** : 20 000 FCFA\n\n## Comment s'inscrire ?\n\nL'inscription se fait en ligne en moins de 3 minutes. Paiement sécurisé par Mobile Money (MTN, Moov, Wave) ou carte bancaire.\n\n**[S'inscrire maintenant →](/inscription)**\n\n## Délais importants\n\n- Early Bird : jusqu'au **30 juin 2026**\n- Standard : du **1er juillet au 31 août 2026**\n- Late : à partir du **1er septembre 2026**",
                'is_featured' => true,
                'is_pinned' => true,
                'is_published' => true,
                'tags' => ['Early Bird', 'Inscription', 'Tarifs'],
            ],
            [
                'category' => 'scientific',
                'title' => 'Appel à communications scientifiques',
                'subtitle' => 'Soumettez votre résumé avant le 31 juillet',
                'excerpt' => "Le comité scientifique invite les chercheurs et cliniciens à soumettre leurs travaux. Date limite : 31 juillet 2026.",
                'body' => "Le **comité scientifique** invite les chercheurs, cliniciens, étudiants et praticiens à soumettre leurs travaux pour communication orale, poster ou e-poster.\n\n## Thématiques 2026\n\n- Imagerie médicale & IA\n- IA en cardiologie\n- Oncologie & IA\n- Santé publique & big data\n- Médecine de précision\n- IA & médecine d'urgence\n- Éthique & IA en santé\n- Pédagogie médicale numérique\n- Pharmacologie & ML\n- e-Santé & téléconsultation\n\n## Format imposé\n\n- Structure **IMRAD** : Introduction, Méthodes, Résultats, Discussion, Conclusion\n- Maximum **350 mots** (hors titre et auteurs)\n- **3 à 6 mots-clés** obligatoires\n- Co-auteurs : jusqu'à 15\n- Déclaration de conflits d'intérêts obligatoire\n\n## Évaluation\n\nÉvaluation en **double aveugle** par 2 relecteurs experts. Décision sous 4-6 semaines.\n\n**[Soumettre un résumé →](/abstracts/submit)**",
                'is_featured' => true,
                'is_published' => true,
                'tags' => ['Résumés', 'Comité scientifique', 'IMRAD'],
            ],
            [
                'category' => 'congress',
                'title' => 'Prof. Y. Sissoko confirmé comme keynote',
                'subtitle' => 'Une référence mondiale en IA appliquée à la cardiologie',
                'excerpt' => "Nous avons l'honneur d'accueillir le Pr Sissoko qui ouvrira la session plénière inaugurale.",
                'body' => "C'est avec un grand honneur que nous annonçons la participation du **Pr Yacouba SISSOKO** en tant que keynote speaker pour l'édition 2026.\n\n## Profil\n\nLe Pr Sissoko est :\n- Professeur de cardiologie à l'Université d'Abidjan\n- Directeur du Centre d'IA Médicale d'Afrique de l'Ouest\n- Auteur de plus de 200 publications scientifiques\n- Pionnier de l'IA appliquée au diagnostic cardiovasculaire en Afrique\n\n## Sa keynote\n\n**Sujet** : « Intelligence artificielle et cardiologie en Afrique : des défis aux opportunités »\n\n**Date** : Mercredi 9 septembre 2026, 9h00\n**Lieu** : Auditorium principal",
                'is_published' => true,
                'tags' => ['Keynote', 'Intervenants'],
            ],
            [
                'category' => 'press',
                'title' => 'Le congrès dans la presse — France 24',
                'excerpt' => "Notre congrès a fait l'objet d'un reportage sur France 24 mettant en lumière le rôle de l'IA dans la santé en Afrique.",
                'body' => "**France 24** consacre un reportage de 12 minutes à notre congrès et à la dynamique de l'IA médicale en Afrique francophone.\n\nLe reportage présente les principaux axes scientifiques et donne la parole aux chercheurs panafricains qui participeront à l'événement.\n\nÀ regarder dans la rubrique « Tech 24 » diffusée tous les samedis à 19h45.",
                'is_published' => true,
                'tags' => ['Presse', 'Médias'],
            ],
            [
                'category' => 'sponsor',
                'title' => 'Bienvenue à GlobalMed comme sponsor Platinum',
                'excerpt' => "Nous accueillons GlobalMed Africa parmi nos sponsors Platinum de l'édition 2026.",
                'body' => "Nous sommes ravis d'accueillir **GlobalMed Africa** parmi nos sponsors **Platinum**. GlobalMed soutient le déploiement de solutions d'IA médicale en Afrique de l'Ouest depuis plus de 10 ans.\n\n## Symposium satellite\n\nGlobalMed animera un symposium satellite le mercredi 9 septembre à 14h sur le thème : « Déploiement industriel de l'IA en imagerie : retours d'expérience ».\n\nL'inscription est gratuite pour tous les participants au congrès — places limitées.",
                'is_published' => true,
                'tags' => ['Sponsors', 'GlobalMed', 'Symposium'],
            ],
        ];

        foreach ($items as $i => $item) {
            NewsArticle::firstOrCreate(
                ['slug' => Str::slug($item['title'])],
                array_merge($item, [
                    'slug' => Str::slug($item['title']),
                    'author_display_name' => 'Comité d\'organisation',
                    'published_at' => now()->subDays(rand(1, 30)),
                    'reading_time' => max(1, (int) ceil(str_word_count($item['body']) / 220)),
                    'locale' => 'fr',
                ]),
            );
        }

        $this->command->info(sprintf('✓ %d articles d\'actualité créés', count($items)));
    }
}

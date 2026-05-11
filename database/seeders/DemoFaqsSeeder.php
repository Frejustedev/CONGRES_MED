<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class DemoFaqsSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['inscription', "Comment puis-je m'inscrire au congrès ?", "Rendez-vous sur la page d'inscription et créez votre compte en moins de 3 minutes. Choisissez votre catégorie tarifaire (membre, non-membre, étudiant, résident), payez par Mobile Money ou carte, et recevez immédiatement votre confirmation par e-mail."],
            ['inscription', "Quels sont les moyens de paiement acceptés ?", "Nous acceptons MTN Mobile Money, Moov Money, Wave, ainsi que les cartes Visa et Mastercard via notre partenaire Kkiapay (passerelle agréée BCEAO). Un paiement en espèces sur place est également possible."],
            ['inscription', "Puis-je obtenir un tarif réduit étudiant/résident ?", "Oui, des tarifs préférentiels sont prévus pour les étudiants en santé et les internes/résidents. Un justificatif (carte d'étudiant ou attestation hospitalière) sera demandé lors de l'inscription."],
            ['inscription', "Comment fonctionne le tarif Early Bird ?", "Le tarif Early Bird vous permet d'économiser jusqu'à 50 % en vous inscrivant avant la date limite indiquée. Les tarifs passent ensuite en Standard puis en Late à mesure que la date du congrès approche."],
            ['inscription', "Une inscription groupée est-elle possible pour mon hôpital ?", "Oui, vous pouvez inscrire plusieurs participants en une seule facture via le formulaire « Inscription groupée ». Idéal pour les institutions, services hospitaliers, ou laboratoires."],

            ['abstracts', "Comment soumettre un résumé scientifique ?", "Connectez-vous à votre espace, cliquez sur « Soumettre un résumé », remplissez le formulaire IMRAD (Introduction, Méthodes, Résultats, Discussion, Conclusion) et ajoutez vos co-auteurs. Vous pouvez modifier votre soumission jusqu'à la date limite."],
            ['abstracts', "Quelle est la structure attendue d'un résumé ?", "Format IMRAD : Introduction, Méthodes, Résultats, Discussion, Conclusion. Maximum 350 mots (hors titre, auteurs, références). Mots-clés obligatoires (3 à 5)."],
            ['abstracts', "Comment se déroule l'évaluation des résumés ?", "Chaque résumé est évalué en double aveugle par deux relecteurs experts du domaine. Critères : originalité, méthodologie, pertinence, clarté rédactionnelle. Décision (accepté / rejeté / révision) sous 4 à 6 semaines."],
            ['abstracts', "Puis-je modifier mon résumé après soumission ?", "Tant que la date limite n'est pas atteinte, vous pouvez modifier votre résumé. Après la date limite, seules les corrections demandées par les relecteurs (révision mineure/majeure) sont permises."],

            ['logistique', "Une attestation de présence est-elle délivrée ?", "Oui, une attestation numérique signée vous est remise automatiquement à l'issue de l'événement, après validation de votre présence par scan QR. Téléchargeable depuis votre espace participant."],
            ['logistique', "Le congrès donne-t-il droit à des crédits CME / DPC ?", "Oui, l'événement est éligible aux crédits CME (Continuing Medical Education) et DPC. Les crédits sont attribués par session suivie et figurent sur votre attestation finale."],
            ['logistique', "Comment obtenir une lettre d'invitation pour mon visa ?", "Après votre inscription confirmée, vous pouvez demander une lettre d'invitation officielle depuis votre tableau de bord. Elle vous est envoyée par e-mail sous 48 h ouvrées."],
            ['logistique', "Le déjeuner est-il inclus ?", "Une pause café est offerte chaque demi-journée. Le déjeuner est inclus dans certaines catégories tarifaires (voir détail). Le dîner de gala est en option payante."],

            ['pratique', "Quel est l'aéroport le plus proche ?", "L'aéroport international Cardinal Bernardin Gantin de Cotonou (COO), à environ 30 min en taxi du lieu du congrès."],
            ['pratique', "Des hôtels partenaires sont-ils proposés ?", "Oui, plusieurs hôtels partenaires proposent des tarifs préférentiels aux participants. Liste et codes promo disponibles dans la rubrique Informations pratiques."],
            ['pratique', "Comment se déplacer pendant le congrès ?", "Un service de navette est prévu entre les hôtels partenaires et le lieu du congrès aux horaires des sessions principales. VTC (Yango, Gozem) également disponibles."],
            ['pratique', "Quelle est la météo prévue ?", "À cette saison à Cotonou, températures entre 24 °C et 30 °C, climat tropical humide. Tenue professionnelle légère recommandée."],
        ];

        foreach ($items as $i => [$category, $question, $answer]) {
            Faq::firstOrCreate(
                ['question' => $question, 'locale' => 'fr'],
                ['category' => $category, 'answer' => $answer, 'display_order' => $i, 'is_published' => true],
            );
        }

        $this->command->info(sprintf('✓ %d entrées FAQ créées', count($items)));
    }
}

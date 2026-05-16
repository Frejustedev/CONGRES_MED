<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use Illuminate\Database\Seeder;

class DefaultEmailTemplatesSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            [
                'key' => 'registration.confirmed',
                'name' => 'Confirmation d\'inscription',
                'subject' => '✓ Votre inscription est enregistrée — {{event_name}}',
                'body_html' => '<p>Bonjour {{participant_name}},</p><p>Votre inscription <strong>{{reference}}</strong> est bien enregistrée. Pour la finaliser, procédez au paiement :</p><p><a href="{{payment_url}}">Procéder au paiement →</a></p><p>Montant à régler : <strong>{{amount_due}} {{currency}}</strong></p><p>À très bientôt !</p>',
            ],
            [
                'key' => 'payment.received',
                'name' => 'Paiement reçu',
                'subject' => '✓ Paiement confirmé — votre badge est prêt',
                'body_html' => '<p>Bonjour {{participant_name}},</p><p>Nous avons bien reçu votre paiement. Votre inscription <strong>{{reference}}</strong> est définitivement validée.</p><p>Vous trouverez en pièce jointe votre <strong>badge QR Code</strong> et votre <strong>facture</strong>.</p><p>Bonne préparation du congrès !</p>',
            ],
            [
                'key' => 'abstract.accepted',
                'name' => 'Résumé accepté',
                'subject' => '🎉 Votre résumé a été accepté !',
                'body_html' => '<p>Cher(e) {{author_name}},</p><p>Nous avons le plaisir de vous informer que votre résumé <strong>{{abstract_title}}</strong> ({{abstract_reference}}) a été <strong>accepté</strong> par le comité scientifique.</p>{{decision_comments}}<p>Félicitations !</p>',
            ],
            [
                'key' => 'abstract.rejected',
                'name' => 'Résumé refusé',
                'subject' => 'Décision concernant votre résumé',
                'body_html' => '<p>Cher(e) {{author_name}},</p><p>Le comité scientifique a examiné votre résumé <strong>{{abstract_title}}</strong>. Malgré sa qualité, nous regrettons de vous informer qu\'il n\'a pas été retenu pour cette édition.</p>{{decision_comments}}<p>Nous vous encourageons à soumettre vos travaux pour les prochaines éditions.</p>',
            ],
            [
                'key' => 'reviewer.assigned',
                'name' => 'Nouveau résumé à évaluer',
                'subject' => 'Nouvelle évaluation assignée — {{event_name}}',
                'body_html' => '<p>Bonjour {{reviewer_name}},</p><p>Un nouveau résumé vous a été assigné : <strong>{{abstract_title}}</strong></p><p>Date limite : <strong>{{deadline}}</strong></p><p><a href="{{review_url}}">Accéder à l\'évaluation →</a></p>',
            ],
            [
                'key' => 'visa.letter_ready',
                'name' => 'Lettre d\'invitation prête',
                'subject' => 'Votre lettre d\'invitation visa est disponible',
                'body_html' => '<p>Bonjour {{participant_name}},</p><p>Votre lettre d\'invitation officielle pour {{event_name}} est prête. Vous pouvez la télécharger :</p><p><a href="{{download_url}}">Télécharger ma lettre →</a></p>',
            ],
            [
                'key' => 'survey.invitation',
                'name' => 'Invitation au sondage',
                'subject' => 'Donnez votre avis sur {{event_name}}',
                'body_html' => '<p>Bonjour {{participant_name}},</p><p>Vous avez participé à <strong>{{event_name}}</strong> et nous aimerions connaître votre avis (5 minutes maxi).</p><p><a href="{{survey_url}}">Répondre au sondage →</a></p><p>Merci pour votre temps !</p>',
            ],
        ];

        foreach ($templates as $t) {
            EmailTemplate::firstOrCreate(
                ['key' => $t['key'], 'locale' => 'fr'],
                array_merge($t, [
                    'description' => 'Template par défaut — personnalisable depuis l\'admin',
                    'locale' => 'fr',
                    'is_active' => true,
                ]),
            );
        }

        $this->command->info(sprintf('✓ %d templates email créés', count($templates)));
    }
}

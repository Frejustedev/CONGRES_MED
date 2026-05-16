<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import PublicLayout from '@/layouts/PublicLayout.vue';

defineOptions({ layout: null });

defineProps<{ event: any; payment: any }>();
</script>

<template>
    <Head title="Conditions générales de vente" />
    <PublicLayout>
        <section class="container mx-auto max-w-3xl px-4 py-12 lg:px-6 prose prose-sm dark:prose-invert">
            <h1>Conditions générales de vente</h1>
            <p class="text-sm text-muted-foreground">En vigueur au {{ new Date().toLocaleDateString('fr-FR') }}</p>

            <h2>1. Objet</h2>
            <p>Les présentes CGV régissent la vente de places et services proposés dans le cadre de <strong>{{ event.name }}</strong> (« le Congrès »), via le site internet du congrès.</p>

            <h2>2. Inscription</h2>
            <p>L'inscription est nominative et incessible. Elle est validée à réception du paiement intégral et confirmée par e-mail avec le badge nominatif.</p>

            <h2>3. Prix & moyens de paiement</h2>
            <p>Les tarifs sont indiqués en FCFA (XOF), TTC, dans la grille publique. Trois périodes tarifaires s'appliquent : Early Bird, Standard, Late. Le tarif appliqué est celui en vigueur à la date d'inscription.</p>
            <p>Moyens de paiement acceptés : Mobile Money (MTN, Moov, Wave), cartes bancaires (Visa, Mastercard) via la passerelle Kkiapay agréée BCEAO, ou paiement à l'accueil le jour J.</p>

            <h2>4. Annulation & remboursement</h2>
            <p v-if="payment.refund_policy" class="whitespace-pre-line">{{ payment.refund_policy }}</p>
            <p v-else>Toute demande d'annulation doit être adressée par écrit à <a :href="`mailto:${event.support_email}`">{{ event.support_email }}</a>. Selon la date d'annulation par rapport au début du congrès :</p>
            <ul v-if="!payment.refund_policy">
                <li>Plus de 60 jours avant : remboursement à 80 % (frais de gestion 20 %)</li>
                <li>De 30 à 60 jours avant : remboursement à 50 %</li>
                <li>Moins de 30 jours avant : aucun remboursement</li>
            </ul>

            <h2>5. Modification du programme</h2>
            <p>L'organisation se réserve le droit de modifier le programme (intervenants, salles, horaires) pour des raisons indépendantes de sa volonté. Ces modifications ne donnent pas droit à remboursement.</p>

            <h2>6. Droit à l'image</h2>
            <p>Le participant accepte que des photos et vidéos prises pendant le congrès puissent être utilisées par l'organisation à des fins de communication, sauf opposition écrite préalable.</p>

            <h2>7. Force majeure</h2>
            <p>En cas de force majeure rendant impossible la tenue du congrès, l'organisation proposera le report à une date ultérieure ou un avoir équivalent.</p>

            <h2>8. Litige</h2>
            <p>Tout litige relève de la compétence des tribunaux de {{ event.venue_city ?? 'Cotonou' }}{{ event.venue_country === 'BJ' ? ' (Bénin)' : '' }}.</p>

            <h2>9. Contact</h2>
            <p>Pour toute question : <a :href="`mailto:${event.support_email}`">{{ event.support_email }}</a><span v-if="event.support_phone"> · {{ event.support_phone }}</span></p>
        </section>
    </PublicLayout>
</template>

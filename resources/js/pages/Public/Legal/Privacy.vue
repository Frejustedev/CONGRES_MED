<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import PublicLayout from '@/layouts/PublicLayout.vue';

defineOptions({ layout: null });

defineProps<{ event: any; payment: any }>();
</script>

<template>
    <Head title="Politique de confidentialité" />
    <PublicLayout>
        <section class="container mx-auto max-w-3xl px-4 py-12 lg:px-6 prose prose-sm dark:prose-invert">
            <h1>Politique de confidentialité</h1>
            <p class="text-sm text-muted-foreground">Conforme au RGPD (UE) et à la loi béninoise n° 2017-20 portant code du numérique</p>

            <h2>1. Responsable du traitement</h2>
            <p>Le responsable du traitement des données personnelles est l'organisation du congrès <strong>{{ event.name }}</strong>. Contact : <a :href="`mailto:${event.support_email}`">{{ event.support_email }}</a>.</p>

            <h2>2. Données collectées</h2>
            <ul>
                <li><strong>Identité</strong> : nom, prénom, civilité, e-mail, téléphone, date de naissance</li>
                <li><strong>Profil professionnel</strong> : profession, organisation, fonction, spécialité, RPPS/ADELI</li>
                <li><strong>Coordonnées</strong> : adresse, ville, pays</li>
                <li><strong>Préférences</strong> : restrictions alimentaires, besoins d'accessibilité, langue</li>
                <li><strong>Données techniques</strong> : adresse IP, user-agent, cookies de session</li>
                <li><strong>Données de paiement</strong> : montants, références de transaction (les numéros de carte ne sont jamais stockés sur nos serveurs)</li>
            </ul>

            <h2>3. Finalités</h2>
            <ul>
                <li>Gérer votre inscription au congrès</li>
                <li>Vous envoyer votre badge, attestation, facture</li>
                <li>Vous tenir informé des mises à jour du programme</li>
                <li>Émettre les crédits CME et attestations</li>
                <li>Établir des statistiques agrégées et anonymisées</li>
                <li>Vous adresser, si consentement, la newsletter du congrès</li>
            </ul>

            <h2>4. Durée de conservation</h2>
            <p>Vos données sont conservées pour la durée du congrès et 3 ans après pour les besoins administratifs et comptables. Les données comptables sont conservées 10 ans conformément à la réglementation.</p>

            <h2>5. Destinataires</h2>
            <p>Vos données ne sont communiquées qu'aux personnes habilitées de l'organisation et à nos prestataires (passerelles de paiement, hébergeur, service e-mail). Elles ne sont jamais vendues à des tiers.</p>

            <h2>6. Vos droits</h2>
            <p>Vous disposez à tout moment d'un droit d'accès, de rectification, d'effacement, de portabilité, de limitation et d'opposition. Pour les exercer : <a :href="`mailto:${event.support_email}`">{{ event.support_email }}</a>.</p>

            <h2>7. Cookies</h2>
            <p>Le site utilise uniquement des cookies strictement nécessaires (session, préférence d'apparence). Aucun cookie publicitaire ou de profilage n'est déposé sans votre consentement.</p>

            <h2>8. Sécurité</h2>
            <p>Toutes les données transitent en HTTPS chiffré. Les mots de passe sont hachés (bcrypt). Les paiements sont traités par des passerelles agréées (Kkiapay BCEAO, Stripe PCI-DSS).</p>

            <h2>9. Réclamation</h2>
            <p>En cas de difficulté concernant l'utilisation de vos données, vous pouvez introduire une réclamation auprès de l'autorité de protection compétente (CNIL en France, APDP au Bénin).</p>
        </section>
    </PublicLayout>
</template>

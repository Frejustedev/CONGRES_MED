<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import PublicLayout from '@/layouts/PublicLayout.vue';

defineOptions({ layout: null });

defineProps<{ event: any; payment: any }>();
</script>

<template>
    <Head title="Mentions légales" />
    <PublicLayout>
        <section class="container mx-auto max-w-3xl px-4 py-12 lg:px-6 prose prose-sm dark:prose-invert">
            <h1>Mentions légales</h1>

            <h2>Éditeur du site</h2>
            <p>{{ event.name }}</p>
            <p v-if="event.venue_city">{{ event.venue_city }}<span v-if="event.venue_country">, {{ event.venue_country }}</span></p>
            <p v-if="payment.invoice_vat_number">N° TVA : {{ payment.invoice_vat_number }}</p>
            <p>E-mail : <a :href="`mailto:${event.support_email}`">{{ event.support_email }}</a><span v-if="event.support_phone"> · Téléphone : {{ event.support_phone }}</span></p>

            <h2>Directeur de la publication</h2>
            <p>Le Président du comité d'organisation du congrès.</p>

            <h2>Hébergement</h2>
            <p>Le site est hébergé chez un prestataire conforme au RGPD. Les données sont stockées dans l'Union européenne.</p>

            <h2>Propriété intellectuelle</h2>
            <p>L'ensemble du contenu (textes, logos, images, vidéos, programme scientifique, résumés) est protégé par le droit d'auteur. Toute reproduction sans autorisation écrite est interdite.</p>
            <p>Les résumés scientifiques restent la propriété intellectuelle de leurs auteurs. Le congrès dispose d'un droit non exclusif de publication dans les actes.</p>

            <h2>Plateforme</h2>
            <p>Ce site est propulsé par <strong>Congresia</strong>, une plateforme de gestion de congrès médicaux développée par Dr Frejuste AGBOTON. <a href="https://github.com/Frejustedev/CONGRES_MED" target="_blank" rel="noopener">Voir la plateforme sur GitHub</a>.</p>

            <h2>Crédits</h2>
            <p>Conception et développement : Dr Frejuste AGBOTON & ANGO Cédric.</p>
        </section>
    </PublicLayout>
</template>

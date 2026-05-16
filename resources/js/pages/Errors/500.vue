<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { AlertOctagon, Home } from 'lucide-vue-next';
import PublicLayout from '@/layouts/PublicLayout.vue';

defineOptions({ layout: null });
</script>

<template>
    <Head title="Erreur serveur" />
    <PublicLayout>
        <section class="container mx-auto max-w-lg px-4 py-20 text-center">
            <AlertOctagon class="mx-auto h-16 w-16 text-red-500" />
            <h1 class="mt-6 text-6xl font-bold tracking-tight">500</h1>
            <p class="mt-3 text-lg">Erreur interne du serveur</p>
            <p class="mt-2 text-sm text-muted-foreground">Une erreur inattendue s'est produite. Nos équipes ont été notifiées. Merci de réessayer dans quelques instants.</p>
            <Link href="/" class="mt-6 inline-flex items-center gap-2 rounded-lg bg-primary px-6 py-3 text-sm font-semibold text-primary-foreground">
                <Home class="h-4 w-4" /> Retour à l'accueil
            </Link>
        </section>
    </PublicLayout>
</template>

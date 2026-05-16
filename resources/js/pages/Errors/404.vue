<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { Compass, Home } from 'lucide-vue-next';
import PublicLayout from '@/layouts/PublicLayout.vue';

defineOptions({ layout: null });
</script>

<template>
    <Head title="Page introuvable" />
    <PublicLayout>
        <section class="container mx-auto max-w-lg px-4 py-20 text-center">
            <Compass class="mx-auto h-16 w-16 text-primary" />
            <h1 class="mt-6 text-6xl font-bold tracking-tight">404</h1>
            <p class="mt-3 text-lg">Page introuvable</p>
            <p class="mt-2 text-sm text-muted-foreground">L'adresse que vous avez saisie n'existe pas ou la page a été déplacée.</p>
            <Link href="/" class="mt-6 inline-flex items-center gap-2 rounded-lg bg-primary px-6 py-3 text-sm font-semibold text-primary-foreground">
                <Home class="h-4 w-4" /> Retour à l'accueil
            </Link>
        </section>
    </PublicLayout>
</template>

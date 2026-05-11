<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { CalendarX, Home } from 'lucide-vue-next';
import PublicLayout from '@/layouts/PublicLayout.vue';

defineOptions({ layout: null });

defineProps<{ closedAt: string }>();
</script>

<template>
    <Head title="Soumissions closes" />
    <PublicLayout>
        <section class="container mx-auto max-w-2xl px-4 py-16 text-center lg:px-6">
            <CalendarX class="mx-auto h-12 w-12 text-muted-foreground" />
            <h1 class="mt-4 text-3xl font-bold tracking-tight">Soumissions closes</h1>
            <p class="mt-3 text-muted-foreground">
                La date limite de soumission ({{ new Date(closedAt).toLocaleDateString('fr-FR', { dateStyle: 'long' }) }}) est dépassée.
            </p>
            <Link href="/" class="mt-6 inline-flex items-center gap-1 rounded-lg bg-primary px-5 py-2.5 text-sm font-medium text-primary-foreground">
                <Home class="h-4 w-4" /> Retour à l'accueil
            </Link>
        </section>
    </PublicLayout>
</template>

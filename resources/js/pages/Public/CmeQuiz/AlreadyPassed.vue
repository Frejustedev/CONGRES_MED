<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { CheckCircle2, Home } from 'lucide-vue-next';
import PublicLayout from '@/layouts/PublicLayout.vue';

defineOptions({ layout: null });

defineProps<{ session: { title: string }; credits: number }>();
</script>

<template>
    <Head title="Quiz déjà validé" />
    <PublicLayout>
        <section class="container mx-auto max-w-md px-4 py-16 text-center">
            <CheckCircle2 class="mx-auto h-14 w-14 text-emerald-500" />
            <h1 class="mt-4 text-2xl font-bold">Quiz déjà validé !</h1>
            <p class="mt-2 text-sm text-muted-foreground">Vous avez déjà obtenu vos <strong>{{ credits }} crédit{{ credits > 1 ? 's' : '' }} CME</strong> pour la session <strong>{{ session.title }}</strong>.</p>
            <Link href="/" class="mt-6 inline-flex items-center gap-1 rounded-lg bg-primary px-5 py-2 text-sm font-medium text-primary-foreground"><Home class="h-4 w-4" />Accueil</Link>
        </section>
    </PublicLayout>
</template>

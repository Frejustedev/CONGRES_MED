<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { AlertCircle, Home } from 'lucide-vue-next';
import PublicLayout from '@/layouts/PublicLayout.vue';

defineOptions({ layout: null });

defineProps<{ session: { title: string } }>();
</script>

<template>
    <Head title="Présence non validée" />
    <PublicLayout>
        <section class="container mx-auto max-w-md px-4 py-16 text-center">
            <AlertCircle class="mx-auto h-12 w-12 text-amber-500" />
            <h1 class="mt-4 text-2xl font-bold">Présence non validée</h1>
            <p class="mt-2 text-sm text-muted-foreground">Vous devez d'abord scanner votre badge à l'entrée de la session <strong>{{ session.title }}</strong> avant de passer le quiz CME.</p>
            <Link href="/" class="mt-6 inline-flex items-center gap-1 rounded-lg bg-primary px-5 py-2 text-sm font-medium text-primary-foreground"><Home class="h-4 w-4" />Accueil</Link>
        </section>
    </PublicLayout>
</template>

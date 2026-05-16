<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { CheckCircle2, Home } from 'lucide-vue-next';
import PublicLayout from '@/layouts/PublicLayout.vue';

defineOptions({ layout: null });

defineProps<{ participant_name: string }>();
</script>

<template>
    <Head title="Sondage déjà rempli" />
    <PublicLayout>
        <section class="container mx-auto max-w-lg px-4 py-20 text-center">
            <CheckCircle2 class="mx-auto h-12 w-12 text-emerald-500" />
            <h1 class="mt-4 text-2xl font-bold">Sondage déjà rempli</h1>
            <p class="mt-2 text-muted-foreground">Merci {{ participant_name }}, vous avez déjà partagé votre avis. Une seule réponse par participant.</p>
            <Link href="/" class="mt-6 inline-flex items-center gap-1 rounded-lg bg-primary px-5 py-2.5 text-sm font-medium text-primary-foreground"><Home class="h-4 w-4" />Accueil</Link>
        </section>
    </PublicLayout>
</template>

<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { CheckCircle2, Home } from 'lucide-vue-next';
import PublicLayout from '@/layouts/PublicLayout.vue';

defineOptions({ layout: null });
</script>

<template>
    <Head title="Merci !" />
    <PublicLayout>
        <section class="container mx-auto max-w-lg px-4 py-20 text-center">
            <CheckCircle2 class="mx-auto h-16 w-16 text-emerald-500" />
            <h1 class="mt-6 text-3xl font-bold">Merci pour votre retour !</h1>
            <p class="mt-3 text-muted-foreground">Vos commentaires nous aideront à améliorer les prochaines éditions.</p>
            <Link href="/" class="mt-6 inline-flex items-center gap-1 rounded-lg bg-primary px-5 py-2.5 text-sm font-medium text-primary-foreground"><Home class="h-4 w-4" />Retour à l'accueil</Link>
        </section>
    </PublicLayout>
</template>

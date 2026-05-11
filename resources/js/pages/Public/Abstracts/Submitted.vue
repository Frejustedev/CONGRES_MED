<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { CheckCircle2, Home, Search } from 'lucide-vue-next';
import PublicLayout from '@/layouts/PublicLayout.vue';

defineOptions({ layout: null });

defineProps<{
    abstract: {
        reference: string;
        title: string;
        submission_type: string;
        thematic_area: string | null;
        status: string;
        word_count: number;
        submitted_at: string | null;
        authors_count: number;
        corresponding_author_email: string | null;
    };
}>();
</script>

<template>
    <Head title="Résumé soumis" />
    <PublicLayout>
        <section class="container mx-auto max-w-2xl px-4 py-12 lg:px-6">
            <div class="rounded-2xl border-2 border-emerald-500/30 bg-emerald-500/5 p-8 text-center">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-emerald-500/10">
                    <CheckCircle2 class="h-8 w-8 text-emerald-600" />
                </div>
                <h1 class="mt-6 text-3xl font-bold tracking-tight">Résumé soumis avec succès</h1>
                <p class="mt-3 text-muted-foreground">Le comité scientifique va l'évaluer prochainement.</p>
                <div class="mt-6 inline-flex items-center gap-2 rounded-full bg-muted px-4 py-1.5 text-sm font-medium">
                    Référence : <span class="font-mono font-bold">{{ abstract.reference }}</span>
                </div>
            </div>

            <div class="mt-8 rounded-xl border bg-card p-6">
                <h2 class="text-base font-semibold">Détails du résumé</h2>
                <dl class="mt-4 space-y-3 text-sm">
                    <div class="flex justify-between gap-3">
                        <dt class="text-muted-foreground">Titre</dt>
                        <dd class="text-right font-medium">{{ abstract.title }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-muted-foreground">Type</dt>
                        <dd class="font-medium">{{ abstract.submission_type }}</dd>
                    </div>
                    <div v-if="abstract.thematic_area" class="flex justify-between">
                        <dt class="text-muted-foreground">Thématique</dt>
                        <dd class="font-medium">{{ abstract.thematic_area }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-muted-foreground">Auteurs</dt>
                        <dd class="font-medium">{{ abstract.authors_count }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-muted-foreground">Mots</dt>
                        <dd class="font-medium">{{ abstract.word_count }}</dd>
                    </div>
                </dl>
            </div>

            <p v-if="abstract.corresponding_author_email" class="mt-6 rounded-lg border bg-muted/30 p-4 text-sm">
                Un e-mail de confirmation a été envoyé à <strong>{{ abstract.corresponding_author_email }}</strong>.
            </p>

            <div class="mt-8 flex justify-center gap-3">
                <Link href="/" class="inline-flex items-center gap-1 rounded-lg border px-5 py-2.5 text-sm font-medium hover:bg-accent">
                    <Home class="h-4 w-4" /> Accueil
                </Link>
                <Link href="/abstracts/lookup" class="inline-flex items-center gap-1 rounded-lg border px-5 py-2.5 text-sm font-medium hover:bg-accent">
                    <Search class="h-4 w-4" /> Consulter mon résumé
                </Link>
            </div>
        </section>
    </PublicLayout>
</template>

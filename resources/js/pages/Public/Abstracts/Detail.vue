<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import { FileText, ArrowLeft } from 'lucide-vue-next';
import PublicLayout from '@/layouts/PublicLayout.vue';

defineOptions({ layout: null });

const props = defineProps<{
    abstract: {
        reference: string;
        title: string;
        submission_type: string;
        thematic_area: string | null;
        status: string;
        language: string;
        keywords: string[];
        word_count: number;
        submitted_at: string | null;
        decision_at: string | null;
        decision_comments: string | null;
        introduction: string | null;
        methods: string | null;
        results: string | null;
        discussion: string | null;
        conclusion: string | null;
        case_description: string | null;
        authors: Array<{ name: string; email: string; affiliation: string; is_corresponding: boolean; is_presenter: boolean }>;
    };
}>();

const statusLabel: Record<string, { label: string; class: string }> = {
    draft: { label: 'Brouillon', class: 'bg-muted text-foreground' },
    submitted: { label: 'Soumis', class: 'bg-blue-500/10 text-blue-700 dark:text-blue-400' },
    under_review: { label: 'En cours d\'évaluation', class: 'bg-amber-500/10 text-amber-700 dark:text-amber-400' },
    revision_required: { label: 'Révision requise', class: 'bg-orange-500/10 text-orange-700 dark:text-orange-400' },
    accepted: { label: 'Accepté', class: 'bg-emerald-500/10 text-emerald-700 dark:text-emerald-400' },
    rejected: { label: 'Refusé', class: 'bg-red-500/10 text-red-700 dark:text-red-400' },
    withdrawn: { label: 'Retiré', class: 'bg-muted text-muted-foreground' },
};

const status = computed(() => statusLabel[props.abstract.status] ?? { label: props.abstract.status, class: 'bg-muted' });
</script>

<template>
    <Head :title="abstract.title" />
    <PublicLayout>
        <section class="container mx-auto max-w-3xl px-4 py-10 lg:px-6">
            <Link href="/abstracts/lookup" class="inline-flex items-center gap-1 text-sm text-muted-foreground hover:text-foreground">
                <ArrowLeft class="h-4 w-4" /> Retour
            </Link>

            <div class="mt-4 flex items-start gap-3 flex-wrap">
                <span :class="['rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-wider', status.class]">{{ status.label }}</span>
                <span class="font-mono text-xs text-muted-foreground">{{ abstract.reference }}</span>
            </div>

            <h1 class="mt-3 text-3xl font-bold tracking-tight">{{ abstract.title }}</h1>

            <div class="mt-4 flex flex-wrap gap-2">
                <span v-for="kw in abstract.keywords" :key="kw" class="rounded-full bg-primary/10 px-3 py-0.5 text-xs font-medium text-primary">{{ kw }}</span>
            </div>

            <!-- Auteurs -->
            <div class="mt-6 text-sm">
                <p v-for="(a, i) in abstract.authors" :key="i">
                    <strong>{{ a.name }}</strong><sup v-if="a.is_corresponding">*</sup><sup v-if="a.is_presenter">†</sup>
                    <span class="text-muted-foreground"> — {{ a.affiliation }}</span>
                </p>
                <p class="mt-1 text-xs text-muted-foreground">* Auteur correspondant — † Présentateur</p>
            </div>

            <!-- Décision si présente -->
            <div v-if="abstract.decision_at" class="mt-6 rounded-xl border-2 p-4" :class="abstract.status === 'accepted' ? 'border-emerald-500/30 bg-emerald-500/5' : abstract.status === 'rejected' ? 'border-red-500/30 bg-red-500/5' : 'border-amber-500/30 bg-amber-500/5'">
                <p class="text-sm font-semibold">Décision du comité scientifique — {{ new Date(abstract.decision_at).toLocaleDateString('fr-FR') }}</p>
                <p v-if="abstract.decision_comments" class="mt-2 text-sm whitespace-pre-line">{{ abstract.decision_comments }}</p>
            </div>

            <!-- Contenu -->
            <article class="prose prose-sm mt-8 max-w-none dark:prose-invert">
                <template v-if="abstract.case_description">
                    <h2>Description du cas</h2>
                    <p class="whitespace-pre-line">{{ abstract.case_description }}</p>
                </template>
                <template v-else>
                    <template v-for="section in [
                        { key: 'introduction', label: 'Introduction' },
                        { key: 'methods', label: 'Méthodes' },
                        { key: 'results', label: 'Résultats' },
                        { key: 'discussion', label: 'Discussion' },
                        { key: 'conclusion', label: 'Conclusion' },
                    ]" :key="section.key">
                        <template v-if="(abstract as any)[section.key]">
                            <h2>{{ section.label }}</h2>
                            <p class="whitespace-pre-line">{{ (abstract as any)[section.key] }}</p>
                        </template>
                    </template>
                </template>
            </article>

            <p class="mt-8 text-xs text-muted-foreground">
                {{ abstract.word_count }} mots · soumis le {{ abstract.submitted_at ? new Date(abstract.submitted_at).toLocaleString('fr-FR') : '—' }}
            </p>
        </section>
    </PublicLayout>
</template>

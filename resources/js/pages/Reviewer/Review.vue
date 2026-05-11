<script setup lang="ts">
import { Head, useForm, Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import { ArrowLeft, Loader2, EyeOff } from 'lucide-vue-next';
import AppLayout from '@/layouts/AppLayout.vue';

defineOptions({ layout: AppLayout as any });

const props = defineProps<{
    review: {
        id: number;
        status: string;
        assigned_at: string | null;
        due_at: string | null;
        submitted_at: string | null;
        score_originality: number | null;
        score_methodology: number | null;
        score_relevance: number | null;
        score_clarity: number | null;
        score_overall: number | null;
        recommendation: string | null;
        comments_to_authors: string | null;
        comments_to_editors: string | null;
        conflict_declared: boolean;
        conflict_description: string | null;
    };
    abstract: {
        reference: string;
        title: string;
        submission_type: string;
        thematic_area: string | null;
        language: string;
        keywords: string[];
        word_count: number;
        introduction: string | null;
        methods: string | null;
        results: string | null;
        discussion: string | null;
        conclusion: string | null;
        case_description: string | null;
        has_conflict_of_interest: boolean;
        conflict_disclosure: string | null;
        funding_disclosed: boolean;
        ethical_approval: boolean;
        anonymized_authors_count: number;
    };
}>();

const form = useForm({
    score_originality: props.review.score_originality ?? 5,
    score_methodology: props.review.score_methodology ?? 5,
    score_relevance: props.review.score_relevance ?? 5,
    score_clarity: props.review.score_clarity ?? 5,
    score_overall: props.review.score_overall ?? 5,
    recommendation: props.review.recommendation ?? '',
    comments_to_authors: props.review.comments_to_authors ?? '',
    comments_to_editors: props.review.comments_to_editors ?? '',
    conflict_declared: props.review.conflict_declared ?? false,
    conflict_description: props.review.conflict_description ?? '',
});

const isReadonly = computed(() => props.review.status === 'submitted');

function submit() {
    form.post(`/reviewer/reviews/${props.review.id}`, { preserveScroll: true });
}
</script>

<template>
    <Head :title="`Évaluer — ${abstract.reference}`" />

    <div class="container mx-auto max-w-5xl px-4 py-8 lg:px-6">
        <Link href="/reviewer" class="inline-flex items-center gap-1 text-sm text-muted-foreground hover:text-foreground">
            <ArrowLeft class="h-4 w-4" /> Retour au dashboard
        </Link>

        <div class="mt-4 grid gap-6 lg:grid-cols-[1fr_360px]">
            <!-- Abstract (anonymisé) -->
            <article class="rounded-xl border bg-card p-6">
                <div class="flex items-center gap-2 text-xs">
                    <span class="font-mono text-muted-foreground">{{ abstract.reference }}</span>
                    <span v-if="abstract.thematic_area" class="rounded-full bg-muted px-2 py-0.5">{{ abstract.thematic_area }}</span>
                    <span class="rounded-full bg-primary/10 px-2 py-0.5 text-primary">{{ abstract.submission_type }}</span>
                </div>
                <h1 class="mt-2 text-2xl font-bold">{{ abstract.title }}</h1>
                <p class="mt-2 flex items-center gap-1 text-xs text-amber-700 dark:text-amber-400">
                    <EyeOff class="h-3 w-3" />
                    Évaluation en double aveugle — identité des auteurs masquée ({{ abstract.anonymized_authors_count }} auteurs)
                </p>

                <div class="mt-3 flex flex-wrap gap-1">
                    <span v-for="kw in abstract.keywords" :key="kw" class="rounded-full bg-muted px-2 py-0.5 text-xs">{{ kw }}</span>
                </div>

                <div class="mt-6 space-y-4 text-sm">
                    <template v-if="abstract.case_description">
                        <div>
                            <h3 class="font-semibold mb-1">Description du cas</h3>
                            <p class="whitespace-pre-line">{{ abstract.case_description }}</p>
                        </div>
                    </template>
                    <template v-else>
                        <div v-for="s in [
                            { k: 'introduction', l: 'Introduction' },
                            { k: 'methods', l: 'Méthodes' },
                            { k: 'results', l: 'Résultats' },
                            { k: 'discussion', l: 'Discussion' },
                            { k: 'conclusion', l: 'Conclusion' },
                        ]" :key="s.k">
                            <template v-if="(abstract as any)[s.k]">
                                <h3 class="font-semibold mb-1">{{ s.l }}</h3>
                                <p class="whitespace-pre-line">{{ (abstract as any)[s.k] }}</p>
                            </template>
                        </div>
                    </template>
                </div>

                <div class="mt-6 rounded-lg bg-muted/30 p-3 text-xs space-y-1">
                    <p><strong>Conflits d'intérêts déclarés par l'auteur :</strong> {{ abstract.has_conflict_of_interest ? 'OUI' : 'Non' }}</p>
                    <p v-if="abstract.conflict_disclosure"><em>{{ abstract.conflict_disclosure }}</em></p>
                    <p><strong>Financement déclaré :</strong> {{ abstract.funding_disclosed ? 'OUI' : 'Non' }}</p>
                    <p><strong>Approbation éthique :</strong> {{ abstract.ethical_approval ? 'OUI' : 'Non' }}</p>
                </div>
            </article>

            <!-- Formulaire évaluation -->
            <form @submit.prevent="submit" class="rounded-xl border bg-card p-6 space-y-5">
                <h2 class="text-lg font-bold">Évaluation</h2>

                <div v-for="score in [
                    { key: 'score_originality', label: 'Originalité', weight: '25%' },
                    { key: 'score_methodology', label: 'Méthodologie', weight: '30%' },
                    { key: 'score_relevance', label: 'Pertinence', weight: '20%' },
                    { key: 'score_clarity', label: 'Clarté rédactionnelle', weight: '10%' },
                    { key: 'score_overall', label: 'Note globale', weight: '15%' },
                ]" :key="score.key">
                    <label class="flex items-center justify-between text-sm font-medium mb-1">
                        <span>{{ score.label }}</span>
                        <span class="text-xs text-muted-foreground">{{ score.weight }} — <strong>{{ (form as any)[score.key] }}/10</strong></span>
                    </label>
                    <input type="range" min="1" max="10" :disabled="isReadonly" v-model.number="(form as any)[score.key]" class="w-full accent-primary" />
                </div>

                <div>
                    <label class="mb-1.5 block text-xs font-medium">Recommandation *</label>
                    <select v-model="form.recommendation" :disabled="isReadonly" required class="w-full rounded-md border bg-background px-3 py-2 text-sm">
                        <option value="">—</option>
                        <option value="accept">Accepter tel quel</option>
                        <option value="accept_minor">Accepter avec révisions mineures</option>
                        <option value="accept_major">Accepter avec révisions majeures</option>
                        <option value="reject">Refuser</option>
                        <option value="undecided">Indécis</option>
                    </select>
                </div>

                <div>
                    <label class="mb-1.5 block text-xs font-medium">Commentaires aux auteurs * (≥ 30 caractères)</label>
                    <textarea v-model="form.comments_to_authors" :disabled="isReadonly" rows="5" required class="w-full resize-y rounded-md border bg-background px-3 py-2 text-sm"></textarea>
                </div>

                <div>
                    <label class="mb-1.5 block text-xs font-medium">Commentaires confidentiels au comité</label>
                    <textarea v-model="form.comments_to_editors" :disabled="isReadonly" rows="3" class="w-full resize-y rounded-md border bg-background px-3 py-2 text-sm"></textarea>
                </div>

                <label class="flex items-start gap-2 text-sm">
                    <input type="checkbox" v-model="form.conflict_declared" :disabled="isReadonly" class="mt-1 accent-primary" />
                    <span>Je déclare un conflit d'intérêts personnel avec ce travail.</span>
                </label>

                <textarea v-if="form.conflict_declared" v-model="form.conflict_description" :disabled="isReadonly" rows="2" placeholder="Précisez" class="w-full resize-y rounded-md border bg-background px-3 py-2 text-sm"></textarea>

                <button v-if="!isReadonly" type="submit" :disabled="form.processing" class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-primary px-5 py-2.5 text-sm font-semibold text-primary-foreground hover:bg-primary/90 disabled:opacity-50">
                    <Loader2 v-if="form.processing" class="h-4 w-4 animate-spin" />
                    Soumettre mon évaluation
                </button>
                <p v-else class="rounded-lg bg-emerald-500/10 p-3 text-center text-xs font-semibold text-emerald-700 dark:text-emerald-400">
                    Évaluation déjà soumise le {{ review.submitted_at ? new Date(review.submitted_at).toLocaleDateString('fr-FR') : '—' }}
                </p>
            </form>
        </div>
    </div>
</template>

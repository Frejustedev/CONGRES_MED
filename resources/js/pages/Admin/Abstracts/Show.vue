<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { ArrowLeft, UserPlus, CheckCircle2, XCircle, AlertCircle } from 'lucide-vue-next';
import AppLayout from '@/layouts/AppLayout.vue';

defineOptions({ layout: AppLayout as any });

const props = defineProps<{
    abstract: any;
    reviewers: Array<{ id: number; name: string; email: string; already_assigned: boolean }>;
}>();

const assignForm = useForm({ reviewer_user_id: null as number | null, due_at: '' });
const decideForm = useForm({ status: '', decision_comments: '' });

function assign() {
    assignForm.post(`/admin/abstracts/${props.abstract.id}/assign-reviewer`, { preserveScroll: true, onSuccess: () => assignForm.reset() });
}
function decide(status: string) {
    decideForm.status = status;
    decideForm.post(`/admin/abstracts/${props.abstract.id}/decide`, { preserveScroll: true });
}
</script>

<template>
    <Head :title="abstract.reference" />
    <div class="container mx-auto max-w-5xl px-4 py-6 lg:px-6">
        <Link href="/admin/abstracts" class="inline-flex items-center gap-1 text-sm text-muted-foreground hover:text-foreground">
            <ArrowLeft class="h-4 w-4" /> Retour aux résumés
        </Link>

        <div class="mt-4 flex flex-wrap items-start gap-3">
            <span class="rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-wider"
                :class="abstract.status === 'accepted' ? 'bg-emerald-500/10 text-emerald-700 dark:text-emerald-400' :
                       abstract.status === 'rejected' ? 'bg-red-500/10 text-red-700' :
                       'bg-amber-500/10 text-amber-700 dark:text-amber-400'">
                {{ abstract.status }}
            </span>
            <span class="font-mono text-xs text-muted-foreground">{{ abstract.reference }}</span>
            <span class="rounded-full bg-primary/10 px-2 py-0.5 text-xs text-primary">{{ abstract.submission_type }}</span>
            <span v-if="abstract.thematic_area" class="rounded-full bg-muted px-2 py-0.5 text-xs">{{ abstract.thematic_area }}</span>
        </div>

        <h1 class="mt-3 text-2xl font-bold">{{ abstract.title }}</h1>

        <div class="mt-2 flex flex-wrap gap-1">
            <span v-for="kw in abstract.keywords" :key="kw" class="rounded-full bg-muted px-2 py-0.5 text-xs">{{ kw }}</span>
        </div>

        <!-- Auteurs -->
        <div class="mt-6 rounded-xl border bg-card p-5">
            <h2 class="text-sm font-bold uppercase text-muted-foreground">Auteurs</h2>
            <ul class="mt-3 space-y-2 text-sm">
                <li v-for="a in abstract.authors" :key="a.email">
                    <strong>{{ a.name }}</strong><sup v-if="a.is_corresponding">*</sup> — {{ a.affiliation }} <span class="text-muted-foreground">({{ a.email }})</span>
                </li>
            </ul>
        </div>

        <!-- Contenu -->
        <article class="prose prose-sm mt-6 max-w-none dark:prose-invert">
            <template v-for="s in [
                { k: 'introduction', l: 'Introduction' },
                { k: 'methods', l: 'Méthodes' },
                { k: 'results', l: 'Résultats' },
                { k: 'discussion', l: 'Discussion' },
                { k: 'conclusion', l: 'Conclusion' },
            ]" :key="s.k">
                <template v-if="abstract[s.k]">
                    <h3>{{ s.l }}</h3>
                    <p class="whitespace-pre-line">{{ abstract[s.k] }}</p>
                </template>
            </template>
            <template v-if="abstract.case_description">
                <h3>Description du cas</h3>
                <p class="whitespace-pre-line">{{ abstract.case_description }}</p>
            </template>
        </article>

        <!-- Reviewers -->
        <div class="mt-6 grid gap-4 md:grid-cols-2">
            <div class="rounded-xl border bg-card p-5">
                <h2 class="text-sm font-bold uppercase text-muted-foreground">Reviewers assignés ({{ abstract.reviews.length }})</h2>
                <div v-if="!abstract.reviews.length" class="mt-3 text-xs text-muted-foreground">Aucun reviewer assigné.</div>
                <ul v-else class="mt-3 space-y-2 text-sm">
                    <li v-for="r in abstract.reviews" :key="r.id" class="flex items-center justify-between rounded border p-2">
                        <div>
                            <p class="font-medium">{{ r.reviewer_name }}</p>
                            <p class="text-xs text-muted-foreground">{{ r.status }} — {{ r.recommendation ?? 'en attente' }}</p>
                        </div>
                        <span v-if="r.weighted_score" class="font-bold tabular-nums">{{ r.weighted_score.toFixed(1) }}/10</span>
                    </li>
                </ul>
                <p v-if="abstract.average_score" class="mt-3 text-sm">Note moyenne pondérée : <strong>{{ abstract.average_score.toFixed(2) }}/10</strong></p>
            </div>

            <div class="rounded-xl border bg-card p-5">
                <h2 class="text-sm font-bold uppercase text-muted-foreground">Assigner un reviewer</h2>
                <form @submit.prevent="assign" class="mt-3 space-y-3">
                    <select v-model="assignForm.reviewer_user_id" required class="w-full rounded-md border bg-background px-3 py-2 text-sm">
                        <option :value="null">—</option>
                        <option v-for="r in reviewers" :key="r.id" :value="r.id" :disabled="r.already_assigned">
                            {{ r.name }} — {{ r.email }}{{ r.already_assigned ? ' (déjà assigné)' : '' }}
                        </option>
                    </select>
                    <input v-model="assignForm.due_at" type="date" class="w-full rounded-md border bg-background px-3 py-2 text-sm" />
                    <button type="submit" :disabled="assignForm.processing" class="inline-flex w-full items-center justify-center gap-1 rounded-md bg-primary px-4 py-2 text-sm font-semibold text-primary-foreground hover:bg-primary/90 disabled:opacity-50">
                        <UserPlus class="h-4 w-4" /> Assigner
                    </button>
                </form>
            </div>
        </div>

        <!-- Décision -->
        <div class="mt-6 rounded-xl border bg-card p-5">
            <h2 class="text-sm font-bold uppercase text-muted-foreground">Décision finale</h2>
            <p v-if="abstract.decision_at" class="mt-2 text-xs text-muted-foreground">Décidé le {{ new Date(abstract.decision_at).toLocaleDateString('fr-FR') }}</p>
            <textarea v-model="decideForm.decision_comments" rows="3" placeholder="Commentaires du comité (envoyés aux auteurs)..." class="mt-3 w-full rounded-md border bg-background px-3 py-2 text-sm"></textarea>
            <div class="mt-3 flex gap-2">
                <button @click="decide('accepted')" :disabled="decideForm.processing" class="inline-flex items-center gap-1 rounded-md bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700 disabled:opacity-50">
                    <CheckCircle2 class="h-4 w-4" /> Accepter
                </button>
                <button @click="decide('revision_required')" :disabled="decideForm.processing" class="inline-flex items-center gap-1 rounded-md bg-amber-600 px-4 py-2 text-sm font-semibold text-white hover:bg-amber-700 disabled:opacity-50">
                    <AlertCircle class="h-4 w-4" /> Demander révision
                </button>
                <button @click="decide('rejected')" :disabled="decideForm.processing" class="inline-flex items-center gap-1 rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700 disabled:opacity-50">
                    <XCircle class="h-4 w-4" /> Refuser
                </button>
            </div>
        </div>
    </div>
</template>

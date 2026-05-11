<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import { Microscope, Clock, CheckCircle2, AlertTriangle } from 'lucide-vue-next';
import AppLayout from '@/layouts/AppLayout.vue';

defineOptions({ layout: AppLayout as any });

defineProps<{
    reviews: Array<{
        id: number;
        abstract_reference: string;
        abstract_title: string;
        thematic_area: string | null;
        submission_type: string;
        status: string;
        assigned_at: string | null;
        due_at: string | null;
        submitted_at: string | null;
        recommendation: string | null;
    }>;
    stats: { assigned: number; in_progress: number; submitted: number };
}>();
</script>

<template>
    <Head title="Espace évaluateur" />

    <div class="container mx-auto px-4 py-8 lg:px-6">
        <div class="flex items-center gap-3">
            <div class="rounded-lg bg-primary/10 p-2"><Microscope class="h-6 w-6 text-primary" /></div>
            <div>
                <h1 class="text-2xl font-bold">Espace évaluateur</h1>
                <p class="text-sm text-muted-foreground">Vos abstracts assignés pour évaluation en double aveugle</p>
            </div>
        </div>

        <!-- Stats -->
        <div class="mt-6 grid gap-3 sm:grid-cols-3">
            <div class="rounded-xl border bg-card p-4">
                <Clock class="h-5 w-5 text-amber-500" />
                <p class="mt-3 text-2xl font-bold">{{ stats.assigned }}</p>
                <p class="text-xs uppercase tracking-wider text-muted-foreground">À démarrer</p>
            </div>
            <div class="rounded-xl border bg-card p-4">
                <AlertTriangle class="h-5 w-5 text-blue-500" />
                <p class="mt-3 text-2xl font-bold">{{ stats.in_progress }}</p>
                <p class="text-xs uppercase tracking-wider text-muted-foreground">En cours</p>
            </div>
            <div class="rounded-xl border bg-card p-4">
                <CheckCircle2 class="h-5 w-5 text-emerald-500" />
                <p class="mt-3 text-2xl font-bold">{{ stats.submitted }}</p>
                <p class="text-xs uppercase tracking-wider text-muted-foreground">Soumis</p>
            </div>
        </div>

        <!-- Reviews -->
        <h2 class="mt-8 text-lg font-semibold">Mes assignations</h2>
        <div v-if="!reviews.length" class="mt-4 rounded-xl border border-dashed bg-muted/30 py-12 text-center">
            <p class="text-sm text-muted-foreground">Aucun résumé ne vous est encore assigné.</p>
        </div>
        <div v-else class="mt-4 space-y-2">
            <Link
                v-for="r in reviews"
                :key="r.id"
                :href="`/reviewer/reviews/${r.id}`"
                class="flex items-center gap-4 rounded-xl border bg-card p-4 transition hover:shadow-md"
            >
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 text-xs">
                        <span class="font-mono text-muted-foreground">{{ r.abstract_reference }}</span>
                        <span v-if="r.thematic_area" class="rounded-full bg-muted px-2 py-0.5">{{ r.thematic_area }}</span>
                    </div>
                    <h3 class="mt-1 truncate text-sm font-semibold">{{ r.abstract_title }}</h3>
                    <p v-if="r.due_at" class="mt-1 text-xs text-muted-foreground">
                        Deadline : {{ new Date(r.due_at).toLocaleDateString('fr-FR') }}
                    </p>
                </div>
                <span
                    :class="[
                        'rounded-full px-3 py-1 text-xs font-semibold',
                        r.status === 'submitted' ? 'bg-emerald-500/10 text-emerald-700 dark:text-emerald-400' :
                        r.status === 'in_progress' ? 'bg-blue-500/10 text-blue-700 dark:text-blue-400' :
                        'bg-amber-500/10 text-amber-700 dark:text-amber-400',
                    ]"
                >
                    {{ r.status === 'submitted' ? 'Soumis' : r.status === 'in_progress' ? 'En cours' : 'À démarrer' }}
                </span>
            </Link>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { Star, TrendingUp, ThumbsUp, RotateCcw, Users } from 'lucide-vue-next';
import AppLayout from '@/layouts/AppLayout.vue';

defineOptions({ layout: AppLayout as any });

defineProps<{
    stats: { total: number; nps: number | null; promoters: number; detractors: number; averages: Record<string, number>; recommend_pct: number; return_pct: number };
    topTopics: Record<string, number>;
    recentComments: Array<any>;
}>();
</script>

<template>
    <Head title="Sondage satisfaction" />
    <div class="container mx-auto px-4 py-6 lg:px-6">
        <h1 class="text-2xl font-bold">Sondage de satisfaction</h1>
        <p class="text-sm text-muted-foreground">{{ stats.total }} réponse{{ stats.total > 1 ? 's' : '' }}</p>

        <div class="mt-6 grid gap-3 sm:grid-cols-3 lg:grid-cols-5">
            <div class="rounded-xl border bg-card p-4"><TrendingUp class="h-5 w-5 text-primary" /><p class="mt-2 text-3xl font-bold">{{ stats.nps ?? '—' }}</p><p class="text-xs uppercase text-muted-foreground">Score NPS</p><p class="text-[10px] text-muted-foreground">{{ stats.promoters }} promoteurs · {{ stats.detractors }} détracteurs</p></div>
            <div class="rounded-xl border bg-card p-4"><Star class="h-5 w-5 fill-amber-400 text-amber-400" /><p class="mt-2 text-3xl font-bold">{{ stats.averages.overall }}</p><p class="text-xs uppercase text-muted-foreground">Satisfaction globale</p></div>
            <div class="rounded-xl border bg-card p-4"><ThumbsUp class="h-5 w-5 text-emerald-500" /><p class="mt-2 text-3xl font-bold">{{ stats.recommend_pct }}%</p><p class="text-xs uppercase text-muted-foreground">Recommanderaient</p></div>
            <div class="rounded-xl border bg-card p-4"><RotateCcw class="h-5 w-5 text-blue-500" /><p class="mt-2 text-3xl font-bold">{{ stats.return_pct }}%</p><p class="text-xs uppercase text-muted-foreground">Reviendraient</p></div>
            <div class="rounded-xl border bg-card p-4"><Users class="h-5 w-5 text-primary" /><p class="mt-2 text-3xl font-bold">{{ stats.total }}</p><p class="text-xs uppercase text-muted-foreground">Réponses total</p></div>
        </div>

        <div class="mt-6 grid gap-4 lg:grid-cols-2">
            <div class="rounded-xl border bg-card p-5">
                <h2 class="text-sm font-bold uppercase text-muted-foreground">Notes moyennes par critère</h2>
                <div class="mt-4 space-y-3">
                    <div v-for="(value, key) in stats.averages" :key="key" class="flex items-center justify-between text-sm">
                        <span class="capitalize">{{ key === 'overall' ? 'Globale' : key === 'content' ? 'Contenu' : key === 'venue' ? 'Lieu' : key === 'organization' ? 'Organisation' : 'Networking' }}</span>
                        <span class="flex items-center gap-1 font-bold">
                            <Star v-for="i in 5" :key="i" :class="['h-4 w-4', i <= value ? 'fill-amber-400 text-amber-400' : 'text-muted-foreground/30']" />
                            <span class="ml-2">{{ value }}/5</span>
                        </span>
                    </div>
                </div>
            </div>

            <div class="rounded-xl border bg-card p-5">
                <h2 class="text-sm font-bold uppercase text-muted-foreground">Top thématiques souhaitées</h2>
                <div class="mt-4 space-y-2">
                    <div v-for="(count, topic) in topTopics" :key="topic" class="flex items-center justify-between text-sm">
                        <span>{{ topic }}</span><span class="font-bold tabular-nums">{{ count }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 rounded-xl border bg-card p-5">
            <h2 class="text-sm font-bold uppercase text-muted-foreground">Commentaires récents</h2>
            <div v-if="!recentComments.length" class="mt-3 text-xs text-muted-foreground">Aucun commentaire pour l'instant.</div>
            <div v-else class="mt-4 space-y-3 max-h-96 overflow-y-auto">
                <div v-for="(c, i) in recentComments" :key="i" class="rounded-lg border p-3 text-sm">
                    <div class="flex items-center gap-2 text-xs text-muted-foreground">
                        <span>Note {{ c.overall_rating }}/5</span>
                        <span v-if="c.nps_score !== null">· NPS {{ c.nps_score }}</span>
                        <span v-if="c.submitted_at">· {{ new Date(c.submitted_at).toLocaleDateString('fr-FR') }}</span>
                    </div>
                    <p v-if="c.positive_feedback" class="mt-2 text-emerald-700 dark:text-emerald-400">+ {{ c.positive_feedback }}</p>
                    <p v-if="c.improvement_feedback" class="mt-1 text-amber-700 dark:text-amber-400">! {{ c.improvement_feedback }}</p>
                    <p v-if="c.comments" class="mt-1 italic text-muted-foreground">{{ c.comments }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

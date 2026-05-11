<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';

defineOptions({ layout: AppLayout as any });

const props = defineProps<{
    abstracts: { data: Array<any>; links: Array<any>; meta: any };
    filters: { status?: string };
    statuses: string[];
}>();

const status = ref(props.filters.status ?? '');
watch(status, (v) => router.get('/admin/abstracts', { status: v || undefined }, { preserveState: true, replace: true }));
</script>

<template>
    <Head title="Résumés" />
    <div class="container mx-auto px-4 py-6 lg:px-6">
        <h1 class="text-2xl font-bold">Résumés scientifiques</h1>

        <select v-model="status" class="mt-4 rounded-md border bg-background px-3 py-2 text-sm">
            <option value="">Tous statuts</option>
            <option v-for="s in statuses" :key="s" :value="s">{{ s }}</option>
        </select>

        <div class="mt-4 overflow-x-auto rounded-xl border bg-card">
            <table class="w-full text-sm">
                <thead class="text-left text-xs uppercase text-muted-foreground">
                    <tr class="border-b">
                        <th class="px-4 py-2">Réf.</th><th>Titre</th><th>Thème</th><th>Type</th><th>Auteurs</th><th>Reviewers</th><th>Note</th><th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="a in abstracts.data" :key="a.id" class="border-t hover:bg-muted/30">
                        <td class="px-4 py-2 font-mono text-xs">
                            <Link :href="`/admin/abstracts/${a.id}`" class="text-primary hover:underline">{{ a.reference }}</Link>
                        </td>
                        <td class="max-w-md">
                            <p class="line-clamp-2 font-medium">{{ a.title }}</p>
                        </td>
                        <td class="text-xs">{{ a.thematic_area ?? '—' }}</td>
                        <td class="text-xs capitalize">{{ a.submission_type }}</td>
                        <td class="text-xs">{{ a.authors_count }}</td>
                        <td class="text-xs">{{ a.reviewer_count }}</td>
                        <td class="text-xs font-bold">{{ a.average_score ? a.average_score.toFixed(1) : '—' }}/10</td>
                        <td>
                            <span :class="['rounded-full px-2 py-0.5 text-[10px] font-semibold',
                                a.status === 'accepted' ? 'bg-emerald-500/10 text-emerald-700 dark:text-emerald-400' :
                                a.status === 'rejected' ? 'bg-red-500/10 text-red-700' :
                                a.status === 'under_review' ? 'bg-blue-500/10 text-blue-700 dark:text-blue-400' :
                                'bg-amber-500/10 text-amber-700 dark:text-amber-400']">
                                {{ a.status }}
                            </span>
                        </td>
                    </tr>
                    <tr v-if="!abstracts.data.length"><td colspan="8" class="px-4 py-12 text-center text-sm text-muted-foreground">Aucun résumé.</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

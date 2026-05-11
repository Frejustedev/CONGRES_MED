<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import { FileText, Plane, Download, CheckCircle2 } from 'lucide-vue-next';
import AppLayout from '@/layouts/AppLayout.vue';

defineOptions({ layout: AppLayout as any });

defineProps<{
    requests: { data: Array<any>; links: Array<any> };
}>();

function generate(id: number) {
    router.post(`/admin/visa-letters/${id}/generate`, {}, { preserveScroll: true });
}
</script>

<template>
    <Head title="Lettres d'invitation visa" />
    <div class="container mx-auto px-4 py-6 lg:px-6">
        <div class="flex items-center gap-2">
            <Plane class="h-6 w-6 text-primary" />
            <h1 class="text-2xl font-bold">Lettres d'invitation visa</h1>
        </div>
        <p class="mt-1 text-sm text-muted-foreground">Demandes des participants pour leurs démarches consulaires</p>

        <div class="mt-6 overflow-x-auto rounded-xl border bg-card">
            <table class="w-full text-sm">
                <thead class="text-left text-xs uppercase text-muted-foreground">
                    <tr class="border-b">
                        <th class="px-4 py-2">Réf. inscription</th><th>Participant</th><th>Pays</th><th>Organisation</th><th>Statut inscription</th><th>Lettre</th><th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="r in requests.data" :key="r.id" class="border-t hover:bg-muted/30">
                        <td class="px-4 py-2 font-mono text-xs">{{ r.reference }}</td>
                        <td>
                            <p class="font-medium">{{ r.participant }}</p>
                            <p class="text-xs text-muted-foreground">{{ r.email }}</p>
                        </td>
                        <td class="text-xs">{{ r.country ?? '—' }}</td>
                        <td class="text-xs">{{ r.organization ?? '—' }}</td>
                        <td><span :class="['rounded-full px-2 py-0.5 text-[10px]', r.status === 'confirmed' ? 'bg-emerald-500/10 text-emerald-700 dark:text-emerald-400' : 'bg-amber-500/10 text-amber-700']">{{ r.status }}</span></td>
                        <td>
                            <CheckCircle2 v-if="r.issued" class="h-4 w-4 text-emerald-600" />
                            <span v-else class="text-xs text-muted-foreground">À générer</span>
                        </td>
                        <td>
                            <button v-if="r.status === 'confirmed'" @click="generate(r.id)" class="inline-flex items-center gap-1 rounded-md bg-primary px-3 py-1 text-xs text-primary-foreground hover:bg-primary/90">
                                <FileText class="h-3 w-3" /> {{ r.issued ? 'Régénérer' : 'Générer' }}
                            </button>
                            <span v-else class="text-xs text-muted-foreground">Paiement requis</span>
                        </td>
                    </tr>
                    <tr v-if="!requests.data.length"><td colspan="7" class="px-4 py-12 text-center text-sm text-muted-foreground">Aucune demande.</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import { Search, Download, RefreshCw, FileText, Ban } from 'lucide-vue-next';
import AppLayout from '@/layouts/AppLayout.vue';

defineOptions({ layout: AppLayout as any });

const props = defineProps<{
    registrations: { data: Array<any>; links: Array<any>; meta: any };
    filters: { status?: string; q?: string };
    statuses: string[];
}>();

const search = ref(props.filters.q ?? '');
const status = ref(props.filters.status ?? '');

let t: ReturnType<typeof setTimeout>;
watch([search, status], () => {
    clearTimeout(t);
    t = setTimeout(() => {
        router.get('/admin/registrations', { q: search.value || undefined, status: status.value || undefined }, { preserveState: true, replace: true });
    }, 300);
});

const csrf = () => document.querySelector<HTMLMetaElement>('meta[name="csrf-token"]')?.content ?? '';

async function regenerateBadge(id: number) {
    await router.post(`/admin/registrations/${id}/badge`, {}, { preserveScroll: true });
}
async function regenerateInvoice(id: number) {
    await router.post(`/admin/registrations/${id}/invoice`, {}, { preserveScroll: true });
}
async function cancelReg(id: number) {
    if (!confirm('Annuler cette inscription ?')) return;
    await router.post(`/admin/registrations/${id}/cancel`, {}, { preserveScroll: true });
}

const fmtMoney = (n: number, c: string) => new Intl.NumberFormat('fr-FR', { style: 'currency', currency: c, maximumFractionDigits: 0 }).format(n);
</script>

<template>
    <Head title="Inscriptions" />
    <div class="container mx-auto px-4 py-6 lg:px-6">
        <div class="flex items-center justify-between gap-3 flex-wrap">
            <h1 class="text-2xl font-bold">Inscriptions</h1>
            <a href="/admin/registrations/export" class="inline-flex items-center gap-1 rounded-md border px-4 py-2 text-sm hover:bg-accent">
                <Download class="h-4 w-4" /> Export CSV
            </a>
        </div>

        <div class="mt-4 flex gap-2 flex-wrap">
            <div class="relative flex-1 min-w-[240px]">
                <Search class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-muted-foreground" />
                <input v-model="search" type="search" placeholder="Référence, nom, e-mail..." class="w-full rounded-md border bg-background py-2 pl-10 pr-4 text-sm" />
            </div>
            <select v-model="status" class="rounded-md border bg-background px-3 py-2 text-sm">
                <option value="">Tous statuts</option>
                <option v-for="s in statuses" :key="s" :value="s">{{ s }}</option>
            </select>
        </div>

        <div class="mt-4 overflow-x-auto rounded-xl border bg-card">
            <table class="w-full text-sm">
                <thead class="text-left text-xs uppercase text-muted-foreground">
                    <tr class="border-b">
                        <th class="px-4 py-2">Réf.</th><th>Participant</th><th>Catégorie</th><th>Pays</th><th>Statut</th><th class="text-right">Montant</th><th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="r in registrations.data" :key="r.id" class="border-t hover:bg-muted/30">
                        <td class="px-4 py-2 font-mono text-xs">{{ r.reference }}</td>
                        <td>
                            <p class="font-medium">{{ r.participant }}</p>
                            <p class="text-xs text-muted-foreground">{{ r.email }}</p>
                        </td>
                        <td class="text-xs">{{ r.category }}</td>
                        <td class="text-xs">{{ r.country ?? '—' }}</td>
                        <td>
                            <span :class="['rounded-full px-2 py-0.5 text-[10px] font-semibold',
                                r.status === 'confirmed' ? 'bg-emerald-500/10 text-emerald-700 dark:text-emerald-400' :
                                r.status === 'cancelled' ? 'bg-red-500/10 text-red-700' :
                                'bg-amber-500/10 text-amber-700 dark:text-amber-400']">
                                {{ r.status }}
                            </span>
                            <span v-if="r.checked_in" class="ml-1 text-[10px] text-emerald-600">✓ check-in</span>
                        </td>
                        <td class="text-right tabular-nums">
                            <span class="font-semibold">{{ fmtMoney(r.amount_paid, r.currency) }}</span>
                            <span v-if="r.amount_paid < r.amount_due" class="block text-[10px] text-amber-600">/ {{ fmtMoney(r.amount_due, r.currency) }}</span>
                        </td>
                        <td>
                            <div class="flex gap-1">
                                <button @click="regenerateBadge(r.id)" title="Régénérer badge" class="rounded p-1 hover:bg-muted"><RefreshCw class="h-3.5 w-3.5" /></button>
                                <button @click="regenerateInvoice(r.id)" title="Régénérer facture" class="rounded p-1 hover:bg-muted"><FileText class="h-3.5 w-3.5" /></button>
                                <button v-if="r.status !== 'cancelled'" @click="cancelReg(r.id)" title="Annuler" class="rounded p-1 text-red-600 hover:bg-red-500/10"><Ban class="h-3.5 w-3.5" /></button>
                            </div>
                        </td>
                    </tr>
                    <tr v-if="!registrations.data.length"><td colspan="7" class="px-4 py-12 text-center text-sm text-muted-foreground">Aucune inscription.</td></tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div v-if="registrations.links?.length > 3" class="mt-4 flex flex-wrap gap-1 justify-center">
            <Link v-for="(link, i) in registrations.links" :key="i" :href="link.url ?? '#'" :class="['rounded-md border px-3 py-1 text-xs', link.active ? 'bg-primary text-primary-foreground' : 'hover:bg-accent', !link.url ? 'opacity-50 pointer-events-none' : '']" v-html="link.label" />
        </div>
    </div>
</template>

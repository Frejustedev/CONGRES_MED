<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { Users, CreditCard, FileText, ScanLine, Award, TrendingUp, Globe2 } from 'lucide-vue-next';
import AppLayout from '@/layouts/AppLayout.vue';

defineOptions({ layout: AppLayout as any });

defineProps<{
    kpis: {
        total_registrations: number;
        confirmed_registrations: number;
        pending_registrations: number;
        revenue: number;
        currency: string;
        checked_in: number;
        check_in_rate: number;
        scans_today: number;
        abstracts_total: number;
        abstracts_submitted: number;
        abstracts_under_review: number;
        abstracts_accepted: number;
        abstracts_rejected: number;
    };
    charts: {
        registrations_by_day: Array<{ day: string; total: number }>;
        registrations_by_category: Array<{ category: string; total: number }>;
        registrations_by_country: Array<{ country: string; total: number }>;
        payments_by_gateway: Array<{ gateway: string; total: number; count: number }>;
    };
    recent_registrations: Array<any>;
}>();

const fmt = (n: number) => new Intl.NumberFormat('fr-FR').format(n);
const fmtMoney = (n: number, c: string) => new Intl.NumberFormat('fr-FR', { style: 'currency', currency: c, maximumFractionDigits: 0 }).format(n);
</script>

<template>
    <Head title="Admin — Tableau de bord" />

    <div class="container mx-auto px-4 py-6 lg:px-6">
        <h1 class="text-2xl font-bold">Tableau de bord</h1>
        <p class="text-sm text-muted-foreground">Vue d'ensemble du congrès en temps réel</p>

        <!-- KPIs -->
        <div class="mt-6 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
            <div class="rounded-xl border bg-card p-4">
                <Users class="h-5 w-5 text-primary" />
                <p class="mt-3 text-2xl font-bold">{{ fmt(kpis.total_registrations) }}</p>
                <p class="text-xs uppercase tracking-wider text-muted-foreground">Inscriptions totales</p>
                <p class="mt-1 text-xs text-emerald-600">{{ fmt(kpis.confirmed_registrations) }} confirmées</p>
            </div>
            <div class="rounded-xl border bg-card p-4">
                <CreditCard class="h-5 w-5 text-primary" />
                <p class="mt-3 text-2xl font-bold">{{ fmtMoney(kpis.revenue, kpis.currency) }}</p>
                <p class="text-xs uppercase tracking-wider text-muted-foreground">Recettes encaissées</p>
            </div>
            <div class="rounded-xl border bg-card p-4">
                <ScanLine class="h-5 w-5 text-primary" />
                <p class="mt-3 text-2xl font-bold">{{ fmt(kpis.checked_in) }}</p>
                <p class="text-xs uppercase tracking-wider text-muted-foreground">Check-in ({{ kpis.check_in_rate }}%)</p>
                <p class="mt-1 text-xs text-emerald-600">{{ fmt(kpis.scans_today) }} scans aujourd'hui</p>
            </div>
            <div class="rounded-xl border bg-card p-4">
                <FileText class="h-5 w-5 text-primary" />
                <p class="mt-3 text-2xl font-bold">{{ fmt(kpis.abstracts_total) }}</p>
                <p class="text-xs uppercase tracking-wider text-muted-foreground">Résumés soumis</p>
                <p class="mt-1 text-xs">
                    <span class="text-emerald-600">{{ fmt(kpis.abstracts_accepted) }} acceptés</span> ·
                    <span class="text-amber-600">{{ fmt(kpis.abstracts_under_review) }} en cours</span>
                </p>
            </div>
        </div>

        <!-- Sections -->
        <div class="mt-6 grid gap-4 lg:grid-cols-2">
            <!-- Par catégorie -->
            <div class="rounded-xl border bg-card p-5">
                <h2 class="text-sm font-bold uppercase tracking-wider text-muted-foreground">Par catégorie tarifaire</h2>
                <div class="mt-4 space-y-2">
                    <div v-for="c in charts.registrations_by_category" :key="c.category" class="flex items-center justify-between">
                        <span class="text-sm">{{ c.category }}</span>
                        <span class="font-bold tabular-nums">{{ fmt(c.total) }}</span>
                    </div>
                </div>
            </div>
            <!-- Par pays -->
            <div class="rounded-xl border bg-card p-5">
                <h2 class="flex items-center gap-2 text-sm font-bold uppercase tracking-wider text-muted-foreground">
                    <Globe2 class="h-4 w-4" /> Top 10 pays
                </h2>
                <div class="mt-4 space-y-2">
                    <div v-for="c in charts.registrations_by_country" :key="c.country" class="flex items-center justify-between">
                        <span class="text-sm">{{ c.country }}</span>
                        <span class="font-bold tabular-nums">{{ fmt(c.total) }}</span>
                    </div>
                </div>
            </div>
            <!-- Paiements par gateway -->
            <div class="rounded-xl border bg-card p-5">
                <h2 class="text-sm font-bold uppercase tracking-wider text-muted-foreground">Paiements par moyen</h2>
                <div class="mt-4 space-y-2">
                    <div v-for="p in charts.payments_by_gateway" :key="p.gateway" class="flex items-center justify-between">
                        <span class="text-sm capitalize">{{ p.gateway }}</span>
                        <span class="font-bold tabular-nums">{{ fmtMoney(Number(p.total), kpis.currency) }} <span class="text-xs text-muted-foreground">({{ p.count }})</span></span>
                    </div>
                </div>
            </div>
            <!-- Inscriptions par jour -->
            <div class="rounded-xl border bg-card p-5">
                <h2 class="flex items-center gap-2 text-sm font-bold uppercase tracking-wider text-muted-foreground">
                    <TrendingUp class="h-4 w-4" /> 30 derniers jours
                </h2>
                <div class="mt-4 max-h-48 overflow-y-auto text-xs space-y-1">
                    <div v-for="d in charts.registrations_by_day" :key="d.day" class="flex justify-between">
                        <span>{{ new Date(d.day).toLocaleDateString('fr-FR') }}</span>
                        <span class="font-medium">{{ d.total }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent -->
        <div class="mt-6 rounded-xl border bg-card p-5">
            <div class="flex items-center justify-between">
                <h2 class="text-sm font-bold uppercase tracking-wider text-muted-foreground">Dernières inscriptions</h2>
                <Link href="/admin/registrations" class="text-xs font-medium text-primary hover:underline">Voir tout →</Link>
            </div>
            <div class="mt-3 overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="text-left text-xs uppercase tracking-wider text-muted-foreground">
                        <tr><th class="py-2">Référence</th><th>Participant</th><th>Catégorie</th><th>Statut</th><th class="text-right">Montant</th></tr>
                    </thead>
                    <tbody>
                        <tr v-for="r in recent_registrations" :key="r.reference" class="border-t">
                            <td class="py-2 font-mono text-xs">{{ r.reference }}</td>
                            <td>{{ r.participant }}</td>
                            <td class="text-xs">{{ r.category }}</td>
                            <td>
                                <span :class="['rounded-full px-2 py-0.5 text-[10px] font-semibold', r.status === 'confirmed' ? 'bg-emerald-500/10 text-emerald-700 dark:text-emerald-400' : 'bg-amber-500/10 text-amber-700 dark:text-amber-400']">
                                    {{ r.status }}
                                </span>
                            </td>
                            <td class="text-right tabular-nums">{{ fmtMoney(r.amount_due, r.currency) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

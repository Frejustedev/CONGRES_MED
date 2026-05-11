<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import { CheckCircle2, Download, Home, FileText, AlertCircle } from 'lucide-vue-next';
import PublicLayout from '@/layouts/PublicLayout.vue';

defineOptions({ layout: null });

const props = defineProps<{
    registration: {
        reference: string;
        status: string;
        amount_paid: number;
        amount_due: number;
        amount_discount: number;
        remaining: number;
        currency: string;
        participant_name: string;
        participant_email: string;
        category_name: string;
        qr_token: string;
        confirmed_at: string | null;
    };
}>();

const formatPrice = (v: number, c: string) =>
    new Intl.NumberFormat('fr-FR', { style: 'currency', currency: c, maximumFractionDigits: 0 }).format(v);

const isConfirmed = computed(() => props.registration.status === 'confirmed' && props.registration.remaining === 0);
const isPending = computed(() => props.registration.remaining > 0);
</script>

<template>
    <Head :title="isConfirmed ? 'Paiement confirmé' : 'Statut paiement'" />
    <PublicLayout>
        <section class="container mx-auto max-w-2xl px-4 py-12 lg:px-6">
            <div v-if="isConfirmed" class="rounded-2xl border-2 border-emerald-500/30 bg-emerald-500/5 p-8 text-center">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-emerald-500/10">
                    <CheckCircle2 class="h-8 w-8 text-emerald-600" />
                </div>
                <h1 class="mt-6 text-3xl font-bold tracking-tight">Paiement confirmé !</h1>
                <p class="mt-3 text-muted-foreground">
                    Bienvenue {{ registration.participant_name }}. Votre inscription est définitivement validée.
                </p>
            </div>

            <div v-else-if="isPending" class="rounded-2xl border-2 border-amber-500/30 bg-amber-500/5 p-8 text-center">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-amber-500/10">
                    <AlertCircle class="h-8 w-8 text-amber-600" />
                </div>
                <h1 class="mt-6 text-3xl font-bold tracking-tight">Paiement en attente</h1>
                <p class="mt-3 text-muted-foreground">
                    Reste à régler : <strong>{{ formatPrice(registration.remaining, registration.currency) }}</strong>
                </p>
                <Link
                    :href="`/inscription/${registration.reference}/payment`"
                    class="mt-6 inline-flex items-center gap-2 rounded-lg bg-primary px-6 py-3 text-base font-semibold text-primary-foreground"
                >
                    Reprendre le paiement
                </Link>
            </div>

            <!-- Récap -->
            <div class="mt-8 rounded-xl border bg-card p-6">
                <h2 class="text-base font-semibold">Récapitulatif</h2>
                <dl class="mt-4 space-y-3 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-muted-foreground">Référence</dt>
                        <dd class="font-mono font-medium">{{ registration.reference }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-muted-foreground">Participant</dt>
                        <dd class="font-medium">{{ registration.participant_name }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-muted-foreground">Catégorie</dt>
                        <dd class="font-medium">{{ registration.category_name }}</dd>
                    </div>
                    <div v-if="registration.confirmed_at" class="flex justify-between">
                        <dt class="text-muted-foreground">Confirmé le</dt>
                        <dd class="font-medium">{{ new Date(registration.confirmed_at).toLocaleString('fr-FR') }}</dd>
                    </div>
                </dl>
                <hr class="my-4" />
                <dl class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <dt>Montant payé</dt>
                        <dd class="font-medium">{{ formatPrice(registration.amount_paid, registration.currency) }}</dd>
                    </div>
                    <div v-if="registration.remaining > 0" class="flex justify-between text-amber-600">
                        <dt>Reste à payer</dt>
                        <dd class="font-medium">{{ formatPrice(registration.remaining, registration.currency) }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Prochaines etapes -->
            <div v-if="isConfirmed" class="mt-8 grid gap-3 sm:grid-cols-2">
                <button
                    type="button"
                    disabled
                    class="flex items-center gap-3 rounded-xl border bg-card p-4 text-left opacity-50"
                >
                    <Download class="h-5 w-5 text-primary" />
                    <div>
                        <p class="text-sm font-semibold">Télécharger ma facture</p>
                        <p class="text-xs text-muted-foreground">Bientôt disponible</p>
                    </div>
                </button>
                <button
                    type="button"
                    disabled
                    class="flex items-center gap-3 rounded-xl border bg-card p-4 text-left opacity-50"
                >
                    <FileText class="h-5 w-5 text-primary" />
                    <div>
                        <p class="text-sm font-semibold">Télécharger mon badge</p>
                        <p class="text-xs text-muted-foreground">Bientôt disponible</p>
                    </div>
                </button>
            </div>

            <div v-if="isConfirmed" class="mt-8 rounded-lg border bg-muted/30 p-4 text-sm">
                <p>Un e-mail de confirmation a été envoyé à <strong>{{ registration.participant_email }}</strong>. Pensez à vérifier vos spams.</p>
            </div>

            <div class="mt-8 text-center">
                <Link href="/" class="inline-flex items-center gap-1 rounded-lg border px-5 py-2.5 text-sm font-medium hover:bg-accent">
                    <Home class="h-4 w-4" />
                    Retour à l'accueil
                </Link>
            </div>
        </section>
    </PublicLayout>
</template>

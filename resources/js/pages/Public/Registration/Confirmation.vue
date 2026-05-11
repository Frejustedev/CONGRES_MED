<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { CheckCircle2, Mail, CreditCard, FileText, Home } from 'lucide-vue-next';
import PublicLayout from '@/layouts/PublicLayout.vue';

defineOptions({ layout: null });

const props = defineProps<{
    registration: {
        reference: string;
        status: string;
        amount_due: number;
        amount_discount: number;
        amount_paid: number;
        remaining: number;
        currency: string;
        pricing_tier: string;
        submitted_at: string | null;
    };
    participant: { full_name: string; email: string };
    category: { name: string };
    promoCode: { code: string; label: string | null } | null;
}>();

const formatPrice = (value: number, currency: string) =>
    new Intl.NumberFormat('fr-FR', { style: 'currency', currency, maximumFractionDigits: 0 }).format(value);

const isPaid = props.registration.status === 'confirmed' && props.registration.remaining === 0;
const requiresPayment = props.registration.remaining > 0;
</script>

<template>
    <Head title="Inscription enregistrée" />
    <PublicLayout>
        <section class="container mx-auto max-w-3xl px-4 py-12 lg:px-6">
            <!-- Confirmation -->
            <div class="rounded-2xl border bg-card p-8 text-center lg:p-12">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-emerald-500/10">
                    <CheckCircle2 class="h-8 w-8 text-emerald-600" />
                </div>
                <h1 class="mt-6 text-3xl font-bold tracking-tight sm:text-4xl">Inscription enregistrée !</h1>
                <p class="mt-3 text-muted-foreground">
                    Merci {{ participant.full_name }}, votre demande d'inscription a bien été reçue.
                </p>
                <div class="mt-6 inline-flex items-center gap-2 rounded-full bg-muted px-4 py-1.5 text-sm font-medium">
                    Référence : <span class="font-mono font-bold">{{ registration.reference }}</span>
                </div>
            </div>

            <!-- Récap -->
            <div class="mt-8 rounded-xl border bg-card p-6">
                <h2 class="text-lg font-bold">Récapitulatif</h2>
                <dl class="mt-4 space-y-3 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-muted-foreground">Participant</dt>
                        <dd class="font-medium">{{ participant.full_name }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-muted-foreground">E-mail</dt>
                        <dd class="font-medium">{{ participant.email }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-muted-foreground">Catégorie</dt>
                        <dd class="font-medium">{{ category.name }}</dd>
                    </div>
                    <div v-if="promoCode" class="flex justify-between">
                        <dt class="text-muted-foreground">Code promo</dt>
                        <dd class="font-mono text-xs font-medium uppercase">{{ promoCode.code }}</dd>
                    </div>
                </dl>
                <hr class="my-4" />
                <dl class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <dt>Sous-total</dt>
                        <dd>{{ formatPrice(registration.amount_due, registration.currency) }}</dd>
                    </div>
                    <div v-if="registration.amount_discount > 0" class="flex justify-between text-emerald-600">
                        <dt>Remise</dt>
                        <dd>-{{ formatPrice(registration.amount_discount, registration.currency) }}</dd>
                    </div>
                    <div v-if="registration.amount_paid > 0" class="flex justify-between">
                        <dt>Déjà payé</dt>
                        <dd>-{{ formatPrice(registration.amount_paid, registration.currency) }}</dd>
                    </div>
                    <div class="flex justify-between border-t pt-3 text-lg font-bold">
                        <dt>{{ requiresPayment ? 'Reste à payer' : 'Total' }}</dt>
                        <dd>{{ formatPrice(requiresPayment ? registration.remaining : registration.amount_due - registration.amount_discount, registration.currency) }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Prochaines étapes -->
            <div v-if="requiresPayment" class="mt-8 rounded-xl border-2 border-primary/30 bg-primary/5 p-6">
                <div class="flex items-start gap-3">
                    <CreditCard class="mt-0.5 h-6 w-6 shrink-0 text-primary" />
                    <div class="flex-1">
                        <h3 class="text-base font-bold">Finalisez le paiement</h3>
                        <p class="mt-1 text-sm text-muted-foreground">
                            Votre place est réservée. Pour confirmer définitivement votre inscription, procédez au paiement par Mobile Money ou carte bancaire.
                        </p>
                        <Link
                            :href="`/inscription/${registration.reference}/payment`"
                            class="mt-4 inline-flex items-center gap-2 rounded-lg bg-primary px-5 py-2.5 text-sm font-semibold text-primary-foreground hover:bg-primary/90"
                        >
                            <CreditCard class="h-4 w-4" />
                            Procéder au paiement
                        </Link>
                    </div>
                </div>
            </div>

            <div v-else class="mt-8 rounded-xl border border-emerald-500/30 bg-emerald-500/5 p-6">
                <div class="flex items-start gap-3">
                    <CheckCircle2 class="mt-0.5 h-6 w-6 shrink-0 text-emerald-600" />
                    <div class="flex-1">
                        <h3 class="text-base font-bold">Inscription confirmée</h3>
                        <p class="mt-1 text-sm text-muted-foreground">
                            Votre badge avec QR code vous sera envoyé par e-mail prochainement. Conservez précieusement votre référence.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Email confirmation note -->
            <div class="mt-8 flex items-start gap-3 rounded-xl border bg-muted/30 p-5">
                <Mail class="mt-0.5 h-5 w-5 shrink-0 text-muted-foreground" />
                <div class="flex-1 text-sm">
                    <p class="font-medium">Un e-mail de confirmation sera envoyé à <strong>{{ participant.email }}</strong>.</p>
                    <p class="mt-1 text-muted-foreground">Pensez à vérifier vos spams si vous ne le recevez pas dans les 5 minutes.</p>
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-8 flex flex-col items-center justify-center gap-3 sm:flex-row">
                <Link href="/" class="inline-flex items-center gap-1 rounded-lg border px-5 py-2.5 text-sm font-medium hover:bg-accent">
                    <Home class="h-4 w-4" />
                    Retour à l'accueil
                </Link>
                <Link href="/programme" class="inline-flex items-center gap-1 rounded-lg border px-5 py-2.5 text-sm font-medium hover:bg-accent">
                    <FileText class="h-4 w-4" />
                    Découvrir le programme
                </Link>
            </div>
        </section>
    </PublicLayout>
</template>

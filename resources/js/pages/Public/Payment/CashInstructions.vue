<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { Wallet, Home, Mail } from 'lucide-vue-next';
import PublicLayout from '@/layouts/PublicLayout.vue';

defineOptions({ layout: null });

defineProps<{
    registration: {
        reference: string;
        remaining: number;
        currency: string;
        participant_name: string;
        category_name: string;
    };
}>();

const formatPrice = (v: number, c: string) =>
    new Intl.NumberFormat('fr-FR', { style: 'currency', currency: c, maximumFractionDigits: 0 }).format(v);
</script>

<template>
    <Head title="Paiement sur place" />
    <PublicLayout>
        <section class="container mx-auto max-w-2xl px-4 py-12 lg:px-6">
            <div class="rounded-2xl border bg-card p-8 text-center">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-primary/10">
                    <Wallet class="h-8 w-8 text-primary" />
                </div>
                <h1 class="mt-6 text-3xl font-bold tracking-tight">Paiement sur place</h1>
                <p class="mt-3 text-muted-foreground">
                    Votre place est pré-réservée. Présentez-vous à l'accueil le jour J avec votre référence pour finaliser le paiement.
                </p>
            </div>

            <div class="mt-8 rounded-xl border bg-card p-6">
                <h2 class="text-base font-semibold">Instructions</h2>
                <ol class="mt-4 space-y-3 text-sm">
                    <li class="flex gap-3">
                        <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-primary text-xs font-bold text-primary-foreground">1</span>
                        <p>Conservez votre <strong>référence d'inscription</strong> : <span class="font-mono font-bold">{{ registration.reference }}</span></p>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-primary text-xs font-bold text-primary-foreground">2</span>
                        <p>Présentez-vous à l'accueil du congrès avec une pièce d'identité.</p>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-primary text-xs font-bold text-primary-foreground">3</span>
                        <p>Réglez le montant en espèces, par chèque ou Mobile Money sur place.</p>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-primary text-xs font-bold text-primary-foreground">4</span>
                        <p>Votre badge avec QR code vous sera remis immédiatement après encaissement.</p>
                    </li>
                </ol>

                <hr class="my-6" />
                <dl class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-muted-foreground">Participant</dt>
                        <dd class="font-medium">{{ registration.participant_name }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-muted-foreground">Catégorie</dt>
                        <dd class="font-medium">{{ registration.category_name }}</dd>
                    </div>
                    <div class="flex justify-between border-t pt-2 text-base font-bold">
                        <dt>Montant à régler</dt>
                        <dd>{{ formatPrice(registration.remaining, registration.currency) }}</dd>
                    </div>
                </dl>
            </div>

            <div class="mt-6 flex items-start gap-3 rounded-lg border bg-muted/30 p-4 text-sm">
                <Mail class="mt-0.5 h-4 w-4 shrink-0 text-muted-foreground" />
                <p class="text-muted-foreground">Un e-mail récapitulatif avec ces instructions vous a été envoyé.</p>
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

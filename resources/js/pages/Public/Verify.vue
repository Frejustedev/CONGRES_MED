<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { ShieldCheck, ShieldAlert } from 'lucide-vue-next';
import PublicLayout from '@/layouts/PublicLayout.vue';

defineOptions({ layout: null });

defineProps<{
    attestation: {
        reference: string;
        recipient_name: string;
        type: string;
        total_credits: number;
        issued_at: string;
        event_name: string;
    } | null;
    verified: boolean;
}>();
</script>

<template>
    <Head title="Vérification d'attestation" />
    <PublicLayout>
        <section class="container mx-auto max-w-xl px-4 py-16 lg:px-6">
            <div v-if="verified && attestation" class="rounded-2xl border-2 border-emerald-500/30 bg-emerald-500/5 p-8 text-center">
                <ShieldCheck class="mx-auto h-12 w-12 text-emerald-600" />
                <h1 class="mt-4 text-2xl font-bold">Attestation authentique</h1>
                <p class="mt-2 text-sm text-muted-foreground">Document délivré officiellement.</p>

                <div class="mt-6 rounded-xl border bg-card p-5 text-left">
                    <dl class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <dt class="text-muted-foreground">Bénéficiaire</dt>
                            <dd class="font-bold">{{ attestation.recipient_name }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-muted-foreground">Type</dt>
                            <dd class="font-medium uppercase">{{ attestation.type }}</dd>
                        </div>
                        <div v-if="attestation.total_credits > 0" class="flex justify-between">
                            <dt class="text-muted-foreground">Crédits</dt>
                            <dd class="font-bold">{{ attestation.total_credits }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-muted-foreground">Référence</dt>
                            <dd class="font-mono text-xs">{{ attestation.reference }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-muted-foreground">Date émission</dt>
                            <dd>{{ new Date(attestation.issued_at).toLocaleDateString('fr-FR') }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-muted-foreground">Événement</dt>
                            <dd>{{ attestation.event_name }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <div v-else class="rounded-2xl border-2 border-red-500/30 bg-red-500/5 p-8 text-center">
                <ShieldAlert class="mx-auto h-12 w-12 text-red-600" />
                <h1 class="mt-4 text-2xl font-bold">Attestation introuvable ou révoquée</h1>
                <p class="mt-2 text-sm text-muted-foreground">Ce code de vérification ne correspond à aucune attestation active. Contactez l'organisation si vous pensez qu'il s'agit d'une erreur.</p>
            </div>
        </section>
    </PublicLayout>
</template>

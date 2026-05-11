<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Smartphone, CreditCard, Wallet, Lock, Loader2, AlertCircle } from 'lucide-vue-next';
import PublicLayout from '@/layouts/PublicLayout.vue';

defineOptions({ layout: null });

const props = defineProps<{
    registration: {
        reference: string;
        remaining: number;
        currency: string;
        participant_name: string;
        participant_email: string;
        category_name: string;
    };
    gateways: Record<string, {
        label: string;
        description: string;
        icon: string;
        enabled: boolean;
        currencies: string[];
        fee_estimate: string;
        requires_validation?: boolean;
    }>;
    mockMode: boolean;
}>();

const selectedGateway = ref<string | null>(null);
const processing = ref(false);

const iconMap: Record<string, any> = {
    smartphone: Smartphone,
    'credit-card': CreditCard,
    wallet: Wallet,
};

const formatPrice = (value: number, currency: string) =>
    new Intl.NumberFormat('fr-FR', { style: 'currency', currency, maximumFractionDigits: 0 }).format(value);

function pay() {
    if (!selectedGateway.value) return;
    processing.value = true;
    router.post(`/inscription/${props.registration.reference}/payment`, {
        gateway: selectedGateway.value,
    }, {
        onFinish: () => (processing.value = false),
    });
}
</script>

<template>
    <Head title="Paiement" />
    <PublicLayout>
        <section class="container mx-auto max-w-2xl px-4 py-10 lg:px-6">
            <h1 class="text-3xl font-bold tracking-tight">Régler votre inscription</h1>
            <p class="mt-2 text-muted-foreground">
                Référence <span class="font-mono font-bold">{{ registration.reference }}</span>
            </p>

            <!-- Mode mock alert -->
            <div v-if="mockMode" class="mt-6 flex items-start gap-3 rounded-lg border border-amber-500/30 bg-amber-500/10 p-4 text-sm">
                <AlertCircle class="mt-0.5 h-5 w-5 shrink-0 text-amber-600" />
                <div class="flex-1">
                    <p class="font-semibold text-amber-900 dark:text-amber-300">Mode démonstration</p>
                    <p class="text-amber-800 dark:text-amber-400">
                        Le paiement est simulé en local. Aucun débit réel.
                        Configurez vos clés Kkiapay / Stripe en production.
                    </p>
                </div>
            </div>

            <!-- Récap -->
            <div class="mt-6 rounded-xl border bg-card p-5">
                <div class="flex items-baseline justify-between">
                    <div>
                        <p class="text-sm text-muted-foreground">{{ registration.category_name }}</p>
                        <p class="font-medium">{{ registration.participant_name }}</p>
                    </div>
                    <p class="text-3xl font-bold">{{ formatPrice(registration.remaining, registration.currency) }}</p>
                </div>
            </div>

            <!-- Choix mode -->
            <h2 class="mt-8 text-lg font-bold">Choisissez votre mode de paiement</h2>
            <div class="mt-4 space-y-3">
                <label
                    v-for="(gw, key) in gateways"
                    :key="key"
                    :class="[
                        'flex cursor-pointer items-start gap-4 rounded-xl border-2 p-4 transition hover:shadow-sm',
                        selectedGateway === key ? 'border-primary bg-primary/5' : 'border-border',
                    ]"
                >
                    <input
                        type="radio"
                        :value="key"
                        v-model="selectedGateway"
                        class="mt-1 h-5 w-5 accent-primary"
                    />
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-primary/10">
                        <component :is="iconMap[gw.icon]" class="h-5 w-5 text-primary" />
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-baseline justify-between gap-2">
                            <h3 class="font-semibold">{{ gw.label }}</h3>
                            <span class="text-xs text-muted-foreground">{{ gw.fee_estimate }}</span>
                        </div>
                        <p class="mt-0.5 text-sm text-muted-foreground">{{ gw.description }}</p>
                    </div>
                </label>
            </div>

            <!-- Securite -->
            <div class="mt-6 flex items-start gap-2 rounded-lg bg-muted/50 p-3 text-xs text-muted-foreground">
                <Lock class="mt-0.5 h-4 w-4 shrink-0" />
                <p>Tous les paiements sont chiffrés en HTTPS et traités par des passerelles agréées BCEAO / PCI-DSS. Aucune donnée bancaire n'est stockée sur nos serveurs.</p>
            </div>

            <!-- CTA -->
            <button
                type="button"
                @click="pay"
                :disabled="!selectedGateway || processing"
                class="mt-6 inline-flex w-full items-center justify-center gap-2 rounded-lg bg-primary px-6 py-3 text-base font-semibold text-primary-foreground shadow-md transition hover:bg-primary/90 disabled:opacity-50"
            >
                <Loader2 v-if="processing" class="h-4 w-4 animate-spin" />
                {{ processing ? 'Redirection…' : 'Procéder au paiement' }}
            </button>
        </section>
    </PublicLayout>
</template>

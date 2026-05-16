<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';

defineOptions({ layout: AppLayout as any });

const props = defineProps<{ settings: Record<string, any> }>();

const form = useForm({ ...props.settings });

function toggleCurrency(code: string) {
    const arr = [...(form.accepted_currencies ?? [])];
    const i = arr.indexOf(code);
    if (i === -1) arr.push(code); else arr.splice(i, 1);
    form.accepted_currencies = arr;
}

function submit() {
    form.put('/admin/settings/payment', { preserveScroll: true });
}
</script>

<template>
    <Head title="Paiements" />
    <div class="container mx-auto max-w-3xl px-4 py-6 lg:px-6">
        <h1 class="text-2xl font-bold">Configuration paiements</h1>
        <p class="text-sm text-muted-foreground">Les clés API Kkiapay/Stripe se configurent dans le fichier <code>.env</code>.</p>

        <form @submit.prevent="submit" class="mt-6 space-y-6">
            <fieldset class="space-y-3 rounded-xl border bg-card p-5">
                <legend class="px-2 text-sm font-semibold">Devises</legend>
                <div class="grid gap-2 sm:grid-cols-2">
                    <div>
                        <label class="block text-xs font-medium">Devise par défaut *</label>
                        <select v-model="form.default_currency" required class="w-full rounded-md border bg-background px-3 py-2 text-sm">
                            <option value="XOF">XOF — Franc CFA</option>
                            <option value="EUR">EUR — Euro</option>
                            <option value="USD">USD — Dollar</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium">Devises acceptées</label>
                        <div class="flex gap-2 mt-2">
                            <label v-for="c in ['XOF', 'EUR', 'USD']" :key="c" class="flex items-center gap-1 text-sm cursor-pointer">
                                <input type="checkbox" :checked="form.accepted_currencies?.includes(c)" @change="toggleCurrency(c)" class="accent-primary" />
                                {{ c }}
                            </label>
                        </div>
                    </div>
                </div>
            </fieldset>

            <fieldset class="space-y-3 rounded-xl border bg-card p-5">
                <legend class="px-2 text-sm font-semibold">Modes de paiement</legend>
                <label class="flex items-center gap-2 text-sm cursor-pointer">
                    <input type="checkbox" v-model="form.kkiapay_enabled" class="accent-primary" />
                    Kkiapay (Mobile Money UEMOA + cartes)
                </label>
                <label class="flex items-center gap-2 text-sm cursor-pointer">
                    <input type="checkbox" v-model="form.stripe_enabled" class="accent-primary" />
                    Stripe (cartes internationales)
                </label>
                <label class="flex items-center gap-2 text-sm cursor-pointer">
                    <input type="checkbox" v-model="form.bank_transfer_enabled" class="accent-primary" />
                    Virement bancaire
                </label>
                <label class="flex items-center gap-2 text-sm cursor-pointer">
                    <input type="checkbox" v-model="form.cash_on_site_enabled" class="accent-primary" />
                    Paiement sur place
                </label>
            </fieldset>

            <fieldset class="space-y-3 rounded-xl border bg-card p-5">
                <legend class="px-2 text-sm font-semibold">Facturation</legend>
                <div class="grid gap-3 sm:grid-cols-2">
                    <input v-model="form.invoice_prefix" type="text" placeholder="Préfixe facture *" required maxlength="16" class="rounded-md border bg-background px-3 py-2 text-sm" />
                    <input v-model.number="form.invoice_next_number" type="number" min="1" placeholder="Prochain n° *" required class="rounded-md border bg-background px-3 py-2 text-sm" />
                    <input v-model="form.invoice_vat_number" type="text" placeholder="N° TVA émetteur" class="rounded-md border bg-background px-3 py-2 text-sm" />
                    <input v-model.number="form.vat_rate" type="number" step="0.01" placeholder="Taux TVA (%)" class="rounded-md border bg-background px-3 py-2 text-sm" />
                </div>
                <textarea v-model="form.invoice_legal_mentions" rows="3" placeholder="Mentions légales (apparaissent en bas des factures)" class="w-full rounded-md border bg-background px-3 py-2 text-sm"></textarea>
            </fieldset>

            <fieldset class="space-y-3 rounded-xl border bg-card p-5">
                <legend class="px-2 text-sm font-semibold">Coordonnées bancaires (pour virements)</legend>
                <input v-model="form.bank_account_holder" type="text" placeholder="Titulaire" class="w-full rounded-md border bg-background px-3 py-2 text-sm" />
                <input v-model="form.bank_name" type="text" placeholder="Banque" class="w-full rounded-md border bg-background px-3 py-2 text-sm" />
                <input v-model="form.bank_iban" type="text" placeholder="IBAN" class="w-full rounded-md border bg-background px-3 py-2 text-sm font-mono" />
                <input v-model="form.bank_bic" type="text" placeholder="BIC / SWIFT" class="w-full rounded-md border bg-background px-3 py-2 text-sm font-mono" />
            </fieldset>

            <fieldset class="rounded-xl border bg-card p-5">
                <legend class="px-2 text-sm font-semibold">Politique de remboursement</legend>
                <textarea v-model="form.refund_policy" rows="4" class="w-full rounded-md border bg-background px-3 py-2 text-sm"></textarea>
            </fieldset>

            <button type="submit" :disabled="form.processing" class="inline-flex rounded-md bg-primary px-6 py-2.5 text-sm font-semibold text-primary-foreground hover:bg-primary/90 disabled:opacity-50">
                {{ form.processing ? 'Enregistrement…' : 'Enregistrer' }}
            </button>
        </form>
    </div>
</template>

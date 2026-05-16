<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';

defineOptions({ layout: AppLayout as any });

const props = defineProps<{ settings: Record<string, any> }>();

const form = useForm({ ...props.settings });

function submit() {
    form.put('/admin/settings/mail', { preserveScroll: true });
}
</script>

<template>
    <Head title="Emails" />
    <div class="container mx-auto max-w-3xl px-4 py-6 lg:px-6">
        <h1 class="text-2xl font-bold">Configuration emails</h1>
        <p class="text-sm text-muted-foreground">Si vous laissez « Utiliser le SMTP de l'application », c'est <code>MAIL_*</code> dans <code>.env</code> qui est utilisé.</p>

        <form @submit.prevent="submit" class="mt-6 space-y-6">
            <fieldset class="space-y-3 rounded-xl border bg-card p-5">
                <legend class="px-2 text-sm font-semibold">Expéditeur</legend>
                <input v-model="form.from_address" type="email" placeholder="noreply@congres.com" class="w-full rounded-md border bg-background px-3 py-2 text-sm" />
                <input v-model="form.from_name" type="text" placeholder="Nom expéditeur" class="w-full rounded-md border bg-background px-3 py-2 text-sm" />
                <input v-model="form.reply_to_address" type="email" placeholder="Reply-to (optionnel)" class="w-full rounded-md border bg-background px-3 py-2 text-sm" />
            </fieldset>

            <fieldset class="rounded-xl border bg-card p-5">
                <legend class="px-2 text-sm font-semibold">Signature HTML</legend>
                <textarea v-model="form.signature_html" rows="4" placeholder="<p>Cordialement,<br>Le comité d'organisation</p>" class="w-full rounded-md border bg-background px-3 py-2 text-sm font-mono"></textarea>
            </fieldset>

            <fieldset class="space-y-3 rounded-xl border bg-card p-5">
                <legend class="px-2 text-sm font-semibold">SMTP personnalisé</legend>
                <label class="flex items-center gap-2 text-sm cursor-pointer">
                    <input type="checkbox" v-model="form.use_app_smtp" class="accent-primary" />
                    Utiliser le SMTP de l'application (.env MAIL_*) — recommandé
                </label>
                <div v-if="!form.use_app_smtp" class="grid gap-3 sm:grid-cols-2">
                    <input v-model="form.smtp_host" type="text" placeholder="Hôte SMTP" class="rounded-md border bg-background px-3 py-2 text-sm" />
                    <input v-model.number="form.smtp_port" type="number" placeholder="Port (465/587)" class="rounded-md border bg-background px-3 py-2 text-sm" />
                    <input v-model="form.smtp_username" type="text" placeholder="Utilisateur" class="rounded-md border bg-background px-3 py-2 text-sm" />
                    <input v-model="form.smtp_password" type="password" placeholder="Mot de passe" class="rounded-md border bg-background px-3 py-2 text-sm" />
                    <select v-model="form.smtp_encryption" class="rounded-md border bg-background px-3 py-2 text-sm sm:col-span-2">
                        <option value="tls">TLS</option>
                        <option value="ssl">SSL</option>
                        <option value="none">Aucun</option>
                    </select>
                </div>
            </fieldset>

            <button type="submit" :disabled="form.processing" class="inline-flex rounded-md bg-primary px-6 py-2.5 text-sm font-semibold text-primary-foreground hover:bg-primary/90 disabled:opacity-50">
                {{ form.processing ? 'Enregistrement…' : 'Enregistrer' }}
            </button>
        </form>
    </div>
</template>

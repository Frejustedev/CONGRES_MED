<script setup lang="ts">
import { Head, useForm, Link } from '@inertiajs/vue3';
import { ArrowLeft, Save, Eye } from 'lucide-vue-next';
import AppLayout from '@/layouts/AppLayout.vue';

defineOptions({ layout: AppLayout as any });

const props = defineProps<{ template: any; availableVariables: string[] }>();

const form = useForm({
    key: props.template.key,
    name: props.template.name,
    description: props.template.description ?? '',
    locale: props.template.locale,
    subject: props.template.subject,
    body_html: props.template.body_html,
    body_text: props.template.body_text ?? '',
    is_active: !!props.template.is_active,
});

function save() {
    form.put(`/admin/email-templates/${props.template.id}`, { preserveScroll: true });
}

function insertVariable(v: string) {
    form.body_html += ' ' + v;
}
</script>

<template>
    <Head :title="`Email — ${template.name}`" />
    <div class="container mx-auto max-w-4xl px-4 py-6 lg:px-6">
        <Link href="/admin/email-templates" class="inline-flex items-center gap-1 text-sm text-muted-foreground"><ArrowLeft class="h-4 w-4" />Tous les templates</Link>

        <form @submit.prevent="save" class="mt-4 grid gap-6 lg:grid-cols-[1fr_280px]">
            <div class="space-y-4">
                <fieldset class="rounded-xl border bg-card p-5 space-y-3">
                    <p class="text-xs font-mono text-muted-foreground">{{ template.key }}</p>
                    <input v-model="form.name" type="text" placeholder="Nom interne *" required class="w-full rounded-md border bg-background px-3 py-2 text-sm" />
                    <input v-model="form.subject" type="text" placeholder="Sujet email *" required class="w-full rounded-md border bg-background px-3 py-2 text-sm" />
                    <textarea v-model="form.description" rows="2" placeholder="Description interne" class="w-full rounded-md border bg-background px-3 py-2 text-sm"></textarea>
                </fieldset>

                <fieldset class="rounded-xl border bg-card p-5">
                    <legend class="px-2 text-sm font-semibold">Corps HTML</legend>
                    <textarea v-model="form.body_html" rows="20" required class="w-full rounded-md border bg-background px-3 py-2 text-sm font-mono"></textarea>
                </fieldset>

                <fieldset class="rounded-xl border bg-card p-5">
                    <legend class="px-2 text-sm font-semibold">Version texte (fallback)</legend>
                    <textarea v-model="form.body_text" rows="6" class="w-full rounded-md border bg-background px-3 py-2 text-sm"></textarea>
                </fieldset>

                <button type="submit" :disabled="form.processing" class="inline-flex items-center gap-1 rounded-md bg-primary px-6 py-2.5 text-sm font-semibold text-primary-foreground hover:bg-primary/90 disabled:opacity-50"><Save class="h-4 w-4" />Enregistrer</button>
            </div>

            <aside class="space-y-4">
                <fieldset class="rounded-xl border bg-card p-4">
                    <legend class="px-2 text-sm font-semibold">Statut</legend>
                    <label class="flex items-center gap-2 text-sm cursor-pointer"><input type="checkbox" v-model="form.is_active" class="accent-primary" />Actif</label>
                    <select v-model="form.locale" class="mt-2 w-full rounded-md border bg-background px-3 py-2 text-sm">
                        <option value="fr">Français</option>
                        <option value="en">English</option>
                    </select>
                </fieldset>

                <fieldset class="rounded-xl border bg-card p-4">
                    <legend class="px-2 text-sm font-semibold">Variables disponibles</legend>
                    <p class="text-xs text-muted-foreground mb-2">Cliquez pour insérer :</p>
                    <div class="space-y-1">
                        <button v-for="v in availableVariables" :key="v" type="button" @click="insertVariable(v)" class="block w-full rounded border bg-muted/30 px-2 py-1 text-left text-xs font-mono hover:bg-muted">{{ v }}</button>
                    </div>
                </fieldset>
            </aside>
        </form>
    </div>
</template>

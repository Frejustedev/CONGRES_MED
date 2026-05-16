<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';

defineOptions({ layout: AppLayout as any });

const props = defineProps<{ settings: Record<string, any> }>();

const form = useForm({ ...props.settings });

function submit() {
    form.put('/admin/settings/event', { preserveScroll: true });
}
</script>

<template>
    <Head title="Paramètres événement" />
    <div class="container mx-auto max-w-3xl px-4 py-6 lg:px-6">
        <h1 class="text-2xl font-bold">Paramètres de l'événement</h1>
        <p class="text-sm text-muted-foreground">Ces informations apparaissent sur le portail public et dans les emails / PDF.</p>

        <form @submit.prevent="submit" class="mt-6 space-y-6">
            <fieldset class="space-y-3 rounded-xl border bg-card p-5">
                <legend class="px-2 text-sm font-semibold">Identité</legend>
                <label class="block text-xs font-medium">Nom du congrès *</label>
                <input v-model="form.name" type="text" required class="w-full rounded-md border bg-background px-3 py-2 text-sm" />
                <label class="block text-xs font-medium">Tagline / sous-titre</label>
                <input v-model="form.tagline" type="text" class="w-full rounded-md border bg-background px-3 py-2 text-sm" />
                <label class="block text-xs font-medium">Thème central</label>
                <input v-model="form.theme" type="text" class="w-full rounded-md border bg-background px-3 py-2 text-sm" />
            </fieldset>

            <fieldset class="space-y-3 rounded-xl border bg-card p-5">
                <legend class="px-2 text-sm font-semibold">Président / mot d'accueil</legend>
                <label class="block text-xs font-medium">Nom du président</label>
                <input v-model="form.president_name" type="text" class="w-full rounded-md border bg-background px-3 py-2 text-sm" />
                <label class="block text-xs font-medium">Titre / fonction</label>
                <input v-model="form.president_title" type="text" class="w-full rounded-md border bg-background px-3 py-2 text-sm" />
                <label class="block text-xs font-medium">Mot du président</label>
                <textarea v-model="form.president_message" rows="5" class="w-full rounded-md border bg-background px-3 py-2 text-sm"></textarea>
            </fieldset>

            <fieldset class="space-y-3 rounded-xl border bg-card p-5">
                <legend class="px-2 text-sm font-semibold">Dates</legend>
                <div class="grid gap-3 sm:grid-cols-2">
                    <div>
                        <label class="block text-xs font-medium">Début</label>
                        <input v-model="form.start_date" type="datetime-local" class="w-full rounded-md border bg-background px-3 py-2 text-sm" />
                    </div>
                    <div>
                        <label class="block text-xs font-medium">Fin</label>
                        <input v-model="form.end_date" type="datetime-local" class="w-full rounded-md border bg-background px-3 py-2 text-sm" />
                    </div>
                    <div>
                        <label class="block text-xs font-medium">Inscriptions ouvrent</label>
                        <input v-model="form.registration_open_at" type="datetime-local" class="w-full rounded-md border bg-background px-3 py-2 text-sm" />
                    </div>
                    <div>
                        <label class="block text-xs font-medium">Inscriptions ferment</label>
                        <input v-model="form.registration_close_at" type="datetime-local" class="w-full rounded-md border bg-background px-3 py-2 text-sm" />
                    </div>
                    <div>
                        <label class="block text-xs font-medium">Abstracts ouvrent</label>
                        <input v-model="form.abstracts_open_at" type="datetime-local" class="w-full rounded-md border bg-background px-3 py-2 text-sm" />
                    </div>
                    <div>
                        <label class="block text-xs font-medium">Abstracts ferment</label>
                        <input v-model="form.abstracts_close_at" type="datetime-local" class="w-full rounded-md border bg-background px-3 py-2 text-sm" />
                    </div>
                </div>
                <label class="block text-xs font-medium">Fuseau horaire</label>
                <input v-model="form.timezone" type="text" class="w-full rounded-md border bg-background px-3 py-2 text-sm" />
            </fieldset>

            <fieldset class="space-y-3 rounded-xl border bg-card p-5">
                <legend class="px-2 text-sm font-semibold">Lieu</legend>
                <label class="block text-xs font-medium">Nom du lieu</label>
                <input v-model="form.venue_name" type="text" class="w-full rounded-md border bg-background px-3 py-2 text-sm" />
                <label class="block text-xs font-medium">Adresse</label>
                <input v-model="form.venue_address" type="text" class="w-full rounded-md border bg-background px-3 py-2 text-sm" />
                <div class="grid gap-3 sm:grid-cols-3">
                    <input v-model="form.venue_city" type="text" placeholder="Ville" class="rounded-md border bg-background px-3 py-2 text-sm" />
                    <input v-model="form.venue_country" type="text" placeholder="Pays (BJ)" maxlength="2" class="rounded-md border bg-background px-3 py-2 text-sm uppercase" />
                </div>
                <div class="grid gap-3 sm:grid-cols-2">
                    <input v-model.number="form.venue_latitude" type="number" step="0.0000001" placeholder="Latitude" class="rounded-md border bg-background px-3 py-2 text-sm" />
                    <input v-model.number="form.venue_longitude" type="number" step="0.0000001" placeholder="Longitude" class="rounded-md border bg-background px-3 py-2 text-sm" />
                </div>
            </fieldset>

            <fieldset class="space-y-3 rounded-xl border bg-card p-5">
                <legend class="px-2 text-sm font-semibold">Support / contact</legend>
                <input v-model="form.support_email" type="email" placeholder="E-mail support *" required class="w-full rounded-md border bg-background px-3 py-2 text-sm" />
                <input v-model="form.support_phone" type="tel" placeholder="Téléphone" class="w-full rounded-md border bg-background px-3 py-2 text-sm" />
                <input v-model="form.support_whatsapp" type="tel" placeholder="WhatsApp" class="w-full rounded-md border bg-background px-3 py-2 text-sm" />
            </fieldset>

            <button type="submit" :disabled="form.processing" class="inline-flex rounded-md bg-primary px-6 py-2.5 text-sm font-semibold text-primary-foreground hover:bg-primary/90 disabled:opacity-50">
                {{ form.processing ? 'Enregistrement…' : 'Enregistrer' }}
            </button>
        </form>
    </div>
</template>

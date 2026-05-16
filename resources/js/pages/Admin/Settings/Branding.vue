<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';

defineOptions({ layout: AppLayout as any });

const props = defineProps<{ settings: Record<string, any> }>();

const form = useForm({ ...props.settings });

function submit() {
    form.put('/admin/settings/branding', { preserveScroll: true });
}

const colorFields = [
    { key: 'color_primary', label: 'Couleur primaire' },
    { key: 'color_primary_foreground', label: 'Texte sur primaire' },
    { key: 'color_secondary', label: 'Couleur secondaire' },
    { key: 'color_secondary_foreground', label: 'Texte sur secondaire' },
    { key: 'color_accent', label: 'Couleur accent' },
    { key: 'color_accent_foreground', label: 'Texte sur accent' },
    { key: 'color_background', label: 'Fond' },
    { key: 'color_foreground', label: 'Texte principal' },
    { key: 'color_muted', label: 'Fond atténué' },
    { key: 'color_muted_foreground', label: 'Texte atténué' },
    { key: 'color_destructive', label: 'Destructif (rouge)' },
];
</script>

<template>
    <Head title="Branding" />
    <div class="container mx-auto max-w-3xl px-4 py-6 lg:px-6">
        <h1 class="text-2xl font-bold">Branding & apparence</h1>
        <p class="text-sm text-muted-foreground">Logo, couleurs, polices. Appliqué automatiquement à toutes les pages publiques.</p>

        <form @submit.prevent="submit" class="mt-6 space-y-6">
            <fieldset class="space-y-3 rounded-xl border bg-card p-5">
                <legend class="px-2 text-sm font-semibold">Logo & images</legend>
                <input v-model="form.logo_path" type="text" placeholder="Chemin logo clair (ex: branding/logo.png)" class="w-full rounded-md border bg-background px-3 py-2 text-sm" />
                <input v-model="form.logo_dark_path" type="text" placeholder="Chemin logo mode sombre" class="w-full rounded-md border bg-background px-3 py-2 text-sm" />
                <input v-model="form.favicon_path" type="text" placeholder="Chemin favicon" class="w-full rounded-md border bg-background px-3 py-2 text-sm" />
                <input v-model="form.hero_image_path" type="text" placeholder="Image hero accueil" class="w-full rounded-md border bg-background px-3 py-2 text-sm" />
            </fieldset>

            <fieldset class="space-y-3 rounded-xl border bg-card p-5">
                <legend class="px-2 text-sm font-semibold">Couleurs</legend>
                <div class="grid gap-3 sm:grid-cols-2">
                    <label v-for="f in colorFields" :key="f.key" class="block">
                        <span class="block text-xs font-medium">{{ f.label }}</span>
                        <div class="mt-1 flex items-center gap-2">
                            <input type="color" :value="(form as any)[f.key]" @input="(form as any)[f.key] = ($event.target as HTMLInputElement).value" class="h-9 w-12 rounded border" />
                            <input :value="(form as any)[f.key]" @input="(form as any)[f.key] = ($event.target as HTMLInputElement).value" type="text" pattern="^#[0-9A-Fa-f]{6}$" class="flex-1 rounded-md border bg-background px-3 py-2 text-sm font-mono uppercase" />
                        </div>
                    </label>
                </div>
            </fieldset>

            <fieldset class="space-y-3 rounded-xl border bg-card p-5">
                <legend class="px-2 text-sm font-semibold">Typographie & thème</legend>
                <div class="grid gap-3 sm:grid-cols-2">
                    <input v-model="form.font_heading" type="text" placeholder="Police titres (ex: Inter)" class="rounded-md border bg-background px-3 py-2 text-sm" />
                    <input v-model="form.font_body" type="text" placeholder="Police texte" class="rounded-md border bg-background px-3 py-2 text-sm" />
                </div>
                <label class="flex items-center gap-2 text-sm">
                    <input type="checkbox" v-model="form.dark_mode_enabled" class="accent-primary" />
                    Activer le mode sombre
                </label>
                <select v-model="form.default_theme" class="rounded-md border bg-background px-3 py-2 text-sm">
                    <option value="system">Thème système</option>
                    <option value="light">Toujours clair</option>
                    <option value="dark">Toujours sombre</option>
                </select>
            </fieldset>

            <button type="submit" :disabled="form.processing" class="inline-flex rounded-md bg-primary px-6 py-2.5 text-sm font-semibold text-primary-foreground hover:bg-primary/90 disabled:opacity-50">
                {{ form.processing ? 'Enregistrement…' : 'Enregistrer' }}
            </button>
        </form>
    </div>
</template>

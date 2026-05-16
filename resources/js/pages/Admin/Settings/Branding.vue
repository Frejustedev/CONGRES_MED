<script setup lang="ts">
import { Head, useForm, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Sparkles, CheckCircle2 } from 'lucide-vue-next';
import AppLayout from '@/layouts/AppLayout.vue';

defineOptions({ layout: AppLayout as any });

const props = defineProps<{
    settings: Record<string, any>;
    presets: Record<string, { name: string; description: string; preview_gradient: string; colors: Record<string, string>; fonts: Record<string, string> }>;
}>();

const form = useForm({ ...props.settings });
const applyingPreset = ref<string | null>(null);

function submit() {
    form.put('/admin/settings/branding', { preserveScroll: true });
}

function applyPreset(key: string) {
    if (!confirm(`Appliquer le thème « ${props.presets[key].name} » ? Cela remplacera les couleurs et polices actuelles.`)) return;
    applyingPreset.value = key;
    router.post('/admin/settings/branding/apply-preset', { preset: key }, {
        preserveScroll: true,
        onFinish: () => (applyingPreset.value = null),
    });
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

function isCurrentPreset(presetKey: string): boolean {
    const preset = props.presets[presetKey];
    return preset.colors.color_primary === form.color_primary && preset.fonts.font_heading === form.font_heading;
}
</script>

<template>
    <Head title="Branding" />
    <div class="container mx-auto max-w-4xl px-4 py-6 lg:px-6">
        <h1 class="text-2xl font-bold">Branding & apparence</h1>
        <p class="text-sm text-muted-foreground">Choisissez un thème prédéfini ou personnalisez chaque détail manuellement.</p>

        <!-- Presets thèmes -->
        <section class="mt-6">
            <div class="mb-4 flex items-center gap-2">
                <Sparkles class="h-5 w-5 text-primary" />
                <h2 class="text-lg font-bold">Thèmes prédéfinis</h2>
                <span class="rounded-full bg-primary/10 px-2 py-0.5 text-xs text-primary">{{ Object.keys(presets).length }} disponibles</span>
            </div>
            <p class="mb-4 text-xs text-muted-foreground">Idéal pour différencier visuellement chaque congrès installé. Vous pouvez ensuite personnaliser les détails.</p>

            <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                <button
                    v-for="(preset, key) in presets"
                    :key="key"
                    type="button"
                    @click="applyPreset(key)"
                    :disabled="applyingPreset !== null"
                    :class="['group relative overflow-hidden rounded-xl border-2 text-left transition hover:shadow-lg disabled:opacity-50', isCurrentPreset(key) ? 'border-primary ring-2 ring-primary/20' : 'border-border']"
                >
                    <div class="h-20" :style="{ background: preset.preview_gradient }"></div>
                    <div class="p-3">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-bold">{{ preset.name }}</p>
                            <CheckCircle2 v-if="isCurrentPreset(key)" class="h-4 w-4 text-primary" />
                        </div>
                        <p class="mt-1 text-xs text-muted-foreground line-clamp-2">{{ preset.description }}</p>
                        <div class="mt-2 flex items-center gap-1">
                            <span v-for="color in Object.values(preset.colors).slice(0, 5)" :key="color" class="h-3 w-3 rounded-full border" :style="{ backgroundColor: color }"></span>
                        </div>
                        <p class="mt-2 text-[10px] text-muted-foreground">{{ preset.fonts.font_heading }} · {{ preset.fonts.font_body }}</p>
                    </div>
                </button>
            </div>
        </section>

        <!-- Customisation manuelle -->
        <form @submit.prevent="submit" class="mt-10 space-y-6">
            <h2 class="text-lg font-bold">Personnalisation manuelle</h2>

            <fieldset class="space-y-3 rounded-xl border bg-card p-5">
                <legend class="px-2 text-sm font-semibold">Logo & images</legend>
                <input v-model="form.logo_path" type="text" placeholder="Chemin logo clair" class="w-full rounded-md border bg-background px-3 py-2 text-sm" />
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
                <legend class="px-2 text-sm font-semibold">Typographie</legend>
                <div class="grid gap-3 sm:grid-cols-2">
                    <input v-model="form.font_heading" type="text" placeholder="Police titres (ex: Inter)" class="rounded-md border bg-background px-3 py-2 text-sm" />
                    <input v-model="form.font_body" type="text" placeholder="Police texte" class="rounded-md border bg-background px-3 py-2 text-sm" />
                </div>
                <p class="text-xs text-muted-foreground">N'importe quelle police Google Fonts. Ajoute le <code>@import</code> correspondant dans <code>app.css</code> si police custom.</p>
            </fieldset>

            <fieldset class="space-y-3 rounded-xl border bg-card p-5">
                <legend class="px-2 text-sm font-semibold">Mode sombre</legend>
                <label class="flex items-center gap-2 text-sm cursor-pointer">
                    <input type="checkbox" v-model="form.dark_mode_enabled" class="accent-primary" />
                    Activer le mode sombre
                </label>
                <select v-model="form.default_theme" class="w-full rounded-md border bg-background px-3 py-2 text-sm">
                    <option value="system">Thème système (auto)</option>
                    <option value="light">Toujours clair</option>
                    <option value="dark">Toujours sombre</option>
                </select>
            </fieldset>

            <button type="submit" :disabled="form.processing" class="inline-flex rounded-md bg-primary px-6 py-2.5 text-sm font-semibold text-primary-foreground hover:bg-primary/90 disabled:opacity-50">
                {{ form.processing ? 'Enregistrement…' : 'Enregistrer les modifications' }}
            </button>
        </form>
    </div>
</template>

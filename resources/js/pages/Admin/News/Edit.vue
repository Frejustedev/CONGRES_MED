<script setup lang="ts">
import { Head, useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { ArrowLeft, Save, Trash2, X } from 'lucide-vue-next';
import AppLayout from '@/layouts/AppLayout.vue';

defineOptions({ layout: AppLayout as any });

const props = defineProps<{ article: Record<string, any> }>();

const form = useForm({ ...props.article });

const tagInput = ref('');
function addTag() {
    const t = tagInput.value.trim();
    if (t && !form.tags.includes(t)) {
        form.tags.push(t);
        tagInput.value = '';
    }
}
function removeTag(t: string) {
    form.tags = form.tags.filter((x: string) => x !== t);
}

function submit() {
    if (props.article.id) {
        form.put(`/admin/news/${props.article.id}`, { preserveScroll: true });
    } else {
        form.post('/admin/news', { preserveScroll: true });
    }
}

const categories = [
    { value: 'announcement', label: 'Annonce' },
    { value: 'congress', label: 'Vie du congrès' },
    { value: 'scientific', label: 'Actualité scientifique' },
    { value: 'press', label: 'Presse' },
    { value: 'social', label: 'Réseaux sociaux' },
    { value: 'sponsor', label: 'Partenaire' },
];
</script>

<template>
    <Head :title="article.id ? 'Modifier article' : 'Nouvel article'" />
    <div class="container mx-auto max-w-4xl px-4 py-6 lg:px-6">
        <Link href="/admin/news" class="inline-flex items-center gap-1 text-sm text-muted-foreground hover:text-foreground">
            <ArrowLeft class="h-4 w-4" /> Tous les articles
        </Link>

        <h1 class="mt-4 text-2xl font-bold">{{ article.id ? 'Modifier l\'article' : 'Nouvel article' }}</h1>

        <form @submit.prevent="submit" class="mt-6 grid gap-6 lg:grid-cols-[1fr_320px]">
            <!-- Contenu principal -->
            <div class="space-y-5">
                <fieldset class="space-y-3 rounded-xl border bg-card p-5">
                    <input v-model="form.title" type="text" required placeholder="Titre de l'article *" class="w-full text-xl font-bold rounded-md border-0 bg-transparent px-0 py-2 focus:outline-none" />
                    <input v-model="form.subtitle" type="text" placeholder="Sous-titre (optionnel)" class="w-full text-sm text-muted-foreground rounded-md border-0 bg-transparent px-0 py-1 focus:outline-none" />
                    <input v-model="form.slug" type="text" placeholder="Slug (auto si laissé vide)" class="w-full text-xs font-mono rounded-md border bg-background px-3 py-1.5" />
                </fieldset>

                <fieldset class="space-y-3 rounded-xl border bg-card p-5">
                    <legend class="px-2 text-sm font-semibold">Résumé (affiché en liste)</legend>
                    <textarea v-model="form.excerpt" rows="3" maxlength="600" class="w-full rounded-md border bg-background px-3 py-2 text-sm"></textarea>
                </fieldset>

                <fieldset class="space-y-3 rounded-xl border bg-card p-5">
                    <legend class="px-2 text-sm font-semibold">Contenu de l'article</legend>
                    <p class="text-xs text-muted-foreground">Syntaxe Markdown supportée : <code>**gras**</code>, <code>## Titre</code>, <code>- liste</code>, <code>[lien](url)</code>.</p>
                    <textarea v-model="form.body" rows="20" required class="w-full rounded-md border bg-background px-3 py-2 text-sm font-mono"></textarea>
                </fieldset>

                <fieldset class="space-y-3 rounded-xl border bg-card p-5">
                    <legend class="px-2 text-sm font-semibold">Image de couverture</legend>
                    <input v-model="form.cover_image_path" type="text" placeholder="Chemin (ex: news/photo.jpg dans /storage)" class="w-full rounded-md border bg-background px-3 py-2 text-sm font-mono" />
                    <input v-model="form.cover_caption" type="text" placeholder="Légende (optionnelle)" class="w-full rounded-md border bg-background px-3 py-2 text-sm" />
                </fieldset>
            </div>

            <!-- Sidebar paramètres -->
            <aside class="space-y-5">
                <fieldset class="space-y-3 rounded-xl border bg-card p-5">
                    <legend class="px-2 text-sm font-semibold">Publication</legend>
                    <label class="flex items-center gap-2 text-sm cursor-pointer">
                        <input type="checkbox" v-model="form.is_published" class="accent-primary" />
                        Publié
                    </label>
                    <label class="flex items-center gap-2 text-sm cursor-pointer">
                        <input type="checkbox" v-model="form.is_featured" class="accent-primary" />
                        À la une
                    </label>
                    <label class="flex items-center gap-2 text-sm cursor-pointer">
                        <input type="checkbox" v-model="form.is_pinned" class="accent-primary" />
                        Épinglé en haut
                    </label>
                    <div>
                        <label class="text-xs font-medium">Date de publication</label>
                        <input v-model="form.published_at" type="datetime-local" class="w-full rounded-md border bg-background px-3 py-2 text-sm" />
                    </div>
                </fieldset>

                <fieldset class="space-y-3 rounded-xl border bg-card p-5">
                    <legend class="px-2 text-sm font-semibold">Classement</legend>
                    <select v-model="form.category" class="w-full rounded-md border bg-background px-3 py-2 text-sm">
                        <option v-for="c in categories" :key="c.value" :value="c.value">{{ c.label }}</option>
                    </select>
                    <select v-model="form.locale" class="w-full rounded-md border bg-background px-3 py-2 text-sm">
                        <option value="fr">Français</option>
                        <option value="en">English</option>
                    </select>
                </fieldset>

                <fieldset class="space-y-3 rounded-xl border bg-card p-5">
                    <legend class="px-2 text-sm font-semibold">Tags</legend>
                    <div class="flex gap-1">
                        <input v-model="tagInput" type="text" placeholder="Ajouter un tag" @keydown.enter.prevent="addTag" class="flex-1 rounded-md border bg-background px-3 py-1.5 text-sm" />
                        <button type="button" @click="addTag" class="rounded-md border px-3 text-sm">+</button>
                    </div>
                    <div class="flex flex-wrap gap-1">
                        <span v-for="t in form.tags" :key="t" class="inline-flex items-center gap-1 rounded-full bg-primary/10 px-2 py-0.5 text-xs text-primary">
                            {{ t }}
                            <button type="button" @click="removeTag(t)"><X class="h-3 w-3" /></button>
                        </span>
                    </div>
                </fieldset>

                <fieldset class="rounded-xl border bg-card p-5">
                    <legend class="px-2 text-sm font-semibold">Auteur</legend>
                    <input v-model="form.author_display_name" type="text" placeholder="Nom à afficher" class="w-full rounded-md border bg-background px-3 py-2 text-sm" />
                </fieldset>

                <button type="submit" :disabled="form.processing" class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-primary px-6 py-3 text-sm font-semibold text-primary-foreground hover:bg-primary/90 disabled:opacity-50">
                    <Save class="h-4 w-4" />
                    {{ form.processing ? 'Enregistrement…' : 'Enregistrer' }}
                </button>
            </aside>
        </form>
    </div>
</template>

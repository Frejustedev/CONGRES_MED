<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { Plus, Pencil, Trash2, Eye, Pin, Star } from 'lucide-vue-next';
import AppLayout from '@/layouts/AppLayout.vue';

defineOptions({ layout: AppLayout as any });

defineProps<{ articles: { data: Array<any>; links: Array<any> } }>();

function destroy(id: number) {
    if (!confirm('Supprimer cet article ?')) return;
    router.delete(`/admin/news/${id}`, { preserveScroll: true });
}
</script>

<template>
    <Head title="Actualités" />
    <div class="container mx-auto px-4 py-6 lg:px-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold">Actualités</h1>
            <Link href="/admin/news/create" class="inline-flex items-center gap-1 rounded-md bg-primary px-4 py-2 text-sm font-semibold text-primary-foreground hover:bg-primary/90">
                <Plus class="h-4 w-4" /> Nouvel article
            </Link>
        </div>

        <div class="mt-4 overflow-x-auto rounded-xl border bg-card">
            <table class="w-full text-sm">
                <thead class="text-left text-xs uppercase text-muted-foreground">
                    <tr class="border-b">
                        <th class="px-4 py-2">Titre</th><th>Catégorie</th><th>Statut</th><th>Auteur</th><th>Publié le</th><th>Vues</th><th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="a in articles.data" :key="a.id" class="border-t hover:bg-muted/30">
                        <td class="px-4 py-2 max-w-md">
                            <Link :href="`/admin/news/${a.id}/edit`" class="font-medium hover:text-primary line-clamp-2">{{ a.title }}</Link>
                            <div class="mt-1 flex gap-1">
                                <Pin v-if="a.is_pinned" class="h-3 w-3 text-amber-500" />
                                <Star v-if="a.is_featured" class="h-3 w-3 text-amber-500 fill-amber-500" />
                            </div>
                        </td>
                        <td class="text-xs capitalize">{{ a.category }}</td>
                        <td>
                            <span :class="['rounded-full px-2 py-0.5 text-[10px] font-semibold', a.is_published ? 'bg-emerald-500/10 text-emerald-700 dark:text-emerald-400' : 'bg-amber-500/10 text-amber-700 dark:text-amber-400']">
                                {{ a.is_published ? 'Publié' : 'Brouillon' }}
                            </span>
                        </td>
                        <td class="text-xs">{{ a.author ?? '—' }}</td>
                        <td class="text-xs">{{ a.published_at ? new Date(a.published_at).toLocaleDateString('fr-FR') : '—' }}</td>
                        <td class="text-xs"><Eye class="inline h-3 w-3 mr-1" />{{ a.view_count }}</td>
                        <td>
                            <div class="flex gap-1">
                                <Link :href="`/admin/news/${a.id}/edit`" class="rounded p-1 hover:bg-muted"><Pencil class="h-3.5 w-3.5" /></Link>
                                <button @click="destroy(a.id)" class="rounded p-1 text-red-600 hover:bg-red-500/10"><Trash2 class="h-3.5 w-3.5" /></button>
                            </div>
                        </td>
                    </tr>
                    <tr v-if="!articles.data.length"><td colspan="7" class="px-4 py-12 text-center text-sm text-muted-foreground">Aucun article. Créez le premier.</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

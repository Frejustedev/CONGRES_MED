<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { computed } from 'vue';
import { Newspaper, Eye, Clock, Calendar, Pin } from 'lucide-vue-next';
import PublicLayout from '@/layouts/PublicLayout.vue';

defineOptions({ layout: null });

const props = defineProps<{
    featured: Array<any>;
    articles: { data: Array<any>; links: Array<any>; meta: any };
    categories: Array<{ key: string; label: string }>;
    currentCategory: string | null;
}>();

function filterCategory(key: string | null) {
    router.get('/actualites', key ? { category: key } : {}, { preserveState: true, replace: true });
}

const categoryColors: Record<string, string> = {
    announcement: 'bg-primary/10 text-primary',
    congress: 'bg-emerald-500/10 text-emerald-700 dark:text-emerald-400',
    scientific: 'bg-purple-500/10 text-purple-700 dark:text-purple-400',
    press: 'bg-amber-500/10 text-amber-700 dark:text-amber-400',
    social: 'bg-pink-500/10 text-pink-700 dark:text-pink-400',
    sponsor: 'bg-sky-500/10 text-sky-700 dark:text-sky-400',
};
</script>

<template>
    <Head title="Actualités" />
    <PublicLayout>
        <!-- Hero -->
        <section class="border-b bg-gradient-to-br from-primary/5 to-background py-12 lg:py-16">
            <div class="container mx-auto px-4 lg:px-6">
                <div class="inline-flex items-center gap-2 rounded-full border bg-muted px-3 py-1 text-xs font-medium text-muted-foreground">
                    <Newspaper class="h-3 w-3" />
                    Actualités
                </div>
                <h1 class="mt-4 text-4xl font-bold tracking-tight sm:text-5xl">Toutes les actualités</h1>
                <p class="mt-3 max-w-2xl text-muted-foreground">
                    Annonces, vie du congrès, publications scientifiques, partenaires : retrouvez ici tout ce qui anime notre événement.
                </p>

                <!-- Filtres catégories -->
                <div class="mt-6 flex flex-wrap gap-2">
                    <button
                        @click="filterCategory(null)"
                        :class="['rounded-full border px-3 py-1 text-xs font-medium transition', !currentCategory ? 'border-primary bg-primary text-primary-foreground' : 'hover:bg-accent']"
                    >
                        Toutes
                    </button>
                    <button
                        v-for="cat in categories"
                        :key="cat.key"
                        @click="filterCategory(cat.key)"
                        :class="['rounded-full border px-3 py-1 text-xs font-medium transition', currentCategory === cat.key ? 'border-primary bg-primary text-primary-foreground' : 'hover:bg-accent']"
                    >
                        {{ cat.label }}
                    </button>
                </div>
            </div>
        </section>

        <!-- Featured (sans filtre) -->
        <section v-if="featured.length && !currentCategory" class="container mx-auto px-4 py-12 lg:px-6">
            <h2 class="mb-6 text-2xl font-bold">À la une</h2>
            <div class="grid gap-6 lg:grid-cols-2">
                <Link
                    v-for="(article, i) in featured.slice(0, 1)"
                    :key="article.id"
                    :href="`/actualites/${article.slug}`"
                    class="group block overflow-hidden rounded-xl border bg-card transition hover:shadow-lg lg:row-span-2"
                >
                    <div class="aspect-video bg-muted">
                        <img v-if="article.cover_image_path" :src="`/storage/${article.cover_image_path}`" class="h-full w-full object-cover transition group-hover:scale-105" :alt="article.title" />
                        <div v-else class="flex h-full w-full items-center justify-center bg-gradient-to-br from-primary/20 to-accent/20"><Newspaper class="h-20 w-20 text-primary/30" /></div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-2">
                            <span :class="['rounded-full px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wider', categoryColors[article.category]]">{{ article.category_label }}</span>
                            <Pin v-if="article.is_pinned" class="h-3 w-3 text-amber-500" />
                        </div>
                        <h3 class="mt-3 text-2xl font-bold leading-tight group-hover:text-primary">{{ article.title }}</h3>
                        <p v-if="article.subtitle" class="mt-1 text-sm text-muted-foreground">{{ article.subtitle }}</p>
                        <p v-if="article.excerpt" class="mt-3 text-sm line-clamp-3">{{ article.excerpt }}</p>
                        <div class="mt-4 flex items-center gap-4 text-xs text-muted-foreground">
                            <span v-if="article.published_at" class="flex items-center gap-1"><Calendar class="h-3 w-3" />{{ new Date(article.published_at).toLocaleDateString('fr-FR', { dateStyle: 'long' }) }}</span>
                            <span v-if="article.reading_time" class="flex items-center gap-1"><Clock class="h-3 w-3" />{{ article.reading_time }} min</span>
                        </div>
                    </div>
                </Link>

                <Link
                    v-for="article in featured.slice(1, 3)"
                    :key="article.id"
                    :href="`/actualites/${article.slug}`"
                    class="group block overflow-hidden rounded-xl border bg-card transition hover:shadow-lg"
                >
                    <div class="aspect-video bg-muted">
                        <img v-if="article.cover_image_path" :src="`/storage/${article.cover_image_path}`" class="h-full w-full object-cover" :alt="article.title" />
                        <div v-else class="flex h-full w-full items-center justify-center bg-gradient-to-br from-primary/20 to-accent/20"><Newspaper class="h-14 w-14 text-primary/30" /></div>
                    </div>
                    <div class="p-5">
                        <span :class="['rounded-full px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wider', categoryColors[article.category]]">{{ article.category_label }}</span>
                        <h3 class="mt-2 text-lg font-bold leading-tight group-hover:text-primary line-clamp-2">{{ article.title }}</h3>
                        <p v-if="article.excerpt" class="mt-2 text-sm text-muted-foreground line-clamp-2">{{ article.excerpt }}</p>
                    </div>
                </Link>
            </div>
        </section>

        <!-- Liste -->
        <section class="container mx-auto px-4 py-12 lg:px-6">
            <h2 v-if="featured.length && !currentCategory" class="mb-6 text-2xl font-bold">Toutes les actualités</h2>
            <div v-if="articles.data.length" class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <Link
                    v-for="article in articles.data"
                    :key="article.id"
                    :href="`/actualites/${article.slug}`"
                    class="group block overflow-hidden rounded-xl border bg-card transition hover:shadow-md"
                >
                    <div class="aspect-video bg-muted">
                        <img v-if="article.cover_image_path" :src="`/storage/${article.cover_image_path}`" class="h-full w-full object-cover" :alt="article.title" />
                        <div v-else class="flex h-full w-full items-center justify-center bg-gradient-to-br from-primary/10 to-accent/10"><Newspaper class="h-12 w-12 text-primary/30" /></div>
                    </div>
                    <div class="p-5">
                        <span :class="['rounded-full px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wider', categoryColors[article.category]]">{{ article.category_label }}</span>
                        <h3 class="mt-2 text-base font-bold leading-tight group-hover:text-primary line-clamp-2">{{ article.title }}</h3>
                        <p v-if="article.excerpt" class="mt-2 text-xs text-muted-foreground line-clamp-3">{{ article.excerpt }}</p>
                        <div class="mt-3 flex items-center justify-between text-[10px] text-muted-foreground">
                            <span v-if="article.published_at">{{ new Date(article.published_at).toLocaleDateString('fr-FR') }}</span>
                            <span class="flex items-center gap-2">
                                <Clock v-if="article.reading_time" class="h-3 w-3" />
                                <span v-if="article.reading_time">{{ article.reading_time }} min</span>
                                <Eye class="h-3 w-3" />
                                {{ article.view_count }}
                            </span>
                        </div>
                    </div>
                </Link>
            </div>
            <div v-else class="rounded-xl border border-dashed bg-muted/30 py-16 text-center">
                <Newspaper class="mx-auto h-10 w-10 text-muted-foreground/50" />
                <p class="mt-3 text-sm text-muted-foreground">Aucune actualité dans cette catégorie.</p>
            </div>

            <!-- Pagination -->
            <div v-if="articles.links?.length > 3" class="mt-8 flex flex-wrap justify-center gap-1">
                <Link
                    v-for="(link, i) in articles.links"
                    :key="i"
                    :href="link.url ?? '#'"
                    :class="['rounded-md border px-3 py-1 text-xs', link.active ? 'bg-primary text-primary-foreground' : 'hover:bg-accent', !link.url ? 'opacity-50 pointer-events-none' : '']"
                    v-html="link.label"
                />
            </div>
        </section>
    </PublicLayout>
</template>

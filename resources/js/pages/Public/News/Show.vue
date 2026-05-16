<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { ArrowLeft, Calendar, Clock, Eye, Newspaper } from 'lucide-vue-next';
import PublicLayout from '@/layouts/PublicLayout.vue';

defineOptions({ layout: null });

defineProps<{
    article: {
        id: number;
        slug: string;
        title: string;
        subtitle: string | null;
        excerpt: string | null;
        body: string;
        category: string;
        category_label: string;
        cover_image_path: string | null;
        cover_caption: string | null;
        tags: string[] | null;
        author: string | null;
        published_at: string | null;
        reading_time: number | null;
        view_count: number;
    };
    related: Array<any>;
}>();
</script>

<template>
    <Head :title="article.title">
        <meta v-if="article.excerpt" name="description" :content="article.excerpt" />
    </Head>
    <PublicLayout>
        <article class="container mx-auto max-w-3xl px-4 py-10 lg:px-6">
            <Link href="/actualites" class="inline-flex items-center gap-1 text-sm text-muted-foreground hover:text-foreground">
                <ArrowLeft class="h-4 w-4" /> Toutes les actualités
            </Link>

            <header class="mt-6">
                <span class="rounded-full bg-primary/10 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-primary">{{ article.category_label }}</span>
                <h1 class="mt-3 text-3xl font-bold tracking-tight sm:text-4xl">{{ article.title }}</h1>
                <p v-if="article.subtitle" class="mt-3 text-lg text-muted-foreground">{{ article.subtitle }}</p>

                <div class="mt-6 flex flex-wrap items-center gap-4 text-sm text-muted-foreground">
                    <span v-if="article.author">Par <strong>{{ article.author }}</strong></span>
                    <span v-if="article.published_at" class="flex items-center gap-1"><Calendar class="h-3 w-3" />{{ new Date(article.published_at).toLocaleDateString('fr-FR', { dateStyle: 'long' }) }}</span>
                    <span v-if="article.reading_time" class="flex items-center gap-1"><Clock class="h-3 w-3" />{{ article.reading_time }} min de lecture</span>
                    <span class="flex items-center gap-1"><Eye class="h-3 w-3" />{{ article.view_count }} vues</span>
                </div>
            </header>

            <!-- Cover -->
            <figure v-if="article.cover_image_path" class="mt-8 overflow-hidden rounded-xl">
                <img :src="`/storage/${article.cover_image_path}`" class="w-full" :alt="article.title" />
                <figcaption v-if="article.cover_caption" class="mt-2 text-xs text-muted-foreground italic">{{ article.cover_caption }}</figcaption>
            </figure>

            <!-- Body : markdown rudimentaire (paragraphes, gras, titres, listes, liens) -->
            <div class="prose prose-sm mt-8 max-w-none dark:prose-invert prose-headings:font-bold prose-a:text-primary prose-strong:text-foreground whitespace-pre-line" v-html="article.body
                .replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>')
                .replace(/\[([^\]]+)\]\(([^)]+)\)/g, '<a href=&quot;$2&quot; class=&quot;underline&quot;>$1</a>')
                .replace(/^## (.+)$/gm, '<h2>$1</h2>')
                .replace(/^### (.+)$/gm, '<h3>$1</h3>')
                .replace(/^- (.+)$/gm, '<li>$1</li>')
                .replace(/(<li>.+<\/li>\n?)+/g, '<ul>$&</ul>')"></div>

            <!-- Tags -->
            <div v-if="article.tags?.length" class="mt-10 flex flex-wrap gap-2 border-t pt-6">
                <span v-for="tag in article.tags" :key="tag" class="rounded-full bg-muted px-3 py-1 text-xs">#{{ tag }}</span>
            </div>
        </article>

        <!-- Related -->
        <section v-if="related.length" class="container mx-auto max-w-5xl px-4 py-12 lg:px-6">
            <h2 class="mb-6 text-xl font-bold">Articles liés</h2>
            <div class="grid gap-4 sm:grid-cols-3">
                <Link
                    v-for="r in related"
                    :key="r.id"
                    :href="`/actualites/${r.slug}`"
                    class="group block rounded-xl border bg-card p-4 transition hover:shadow-md"
                >
                    <span class="rounded-full bg-muted px-2 py-0.5 text-[10px] uppercase">{{ r.category_label }}</span>
                    <h3 class="mt-2 text-sm font-semibold line-clamp-2 group-hover:text-primary">{{ r.title }}</h3>
                    <p v-if="r.excerpt" class="mt-1 text-xs text-muted-foreground line-clamp-2">{{ r.excerpt }}</p>
                </Link>
            </div>
        </section>
    </PublicLayout>
</template>

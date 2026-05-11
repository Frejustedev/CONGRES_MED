<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { Store, MapPin, ExternalLink, Mail } from 'lucide-vue-next';
import PublicLayout from '@/layouts/PublicLayout.vue';

defineOptions({ layout: null });

defineProps<{
    exhibitors: Array<{
        id: number;
        slug: string;
        name: string;
        booth_number: string | null;
        booth_size: string | null;
        logo_path: string | null;
        description: string | null;
        website: string | null;
        product_tags: string[] | null;
    }>;
}>();
</script>

<template>
    <Head title="Exposants" />
    <PublicLayout>
        <section class="border-b bg-gradient-to-br from-primary/5 to-background py-12 lg:py-16">
            <div class="container mx-auto px-4 lg:px-6">
                <div class="inline-flex items-center gap-2 rounded-full border bg-muted px-3 py-1 text-xs font-medium text-muted-foreground">
                    <Store class="h-3 w-3" />
                    Exposition
                </div>
                <h1 class="mt-4 text-4xl font-bold tracking-tight sm:text-5xl">Exposants</h1>
                <p class="mt-3 max-w-2xl text-muted-foreground">
                    Découvrez les sociétés présentes sur l'espace d'exposition : matériel médical, laboratoires, éditeurs, services numériques.
                </p>
            </div>
        </section>

        <section class="container mx-auto px-4 py-12 lg:px-6">
            <div v-if="!exhibitors.length" class="rounded-xl border border-dashed bg-muted/30 py-16 text-center">
                <Store class="mx-auto h-10 w-10 text-muted-foreground/50" />
                <p class="mt-4 text-base font-medium">Liste des exposants à venir</p>
                <p class="mt-1 text-sm text-muted-foreground">Vous êtes un exposant ? Contactez-nous pour réserver votre stand.</p>
                <Link href="/contact" class="mt-6 inline-flex items-center gap-2 rounded-lg bg-primary px-5 py-2 text-sm font-medium text-primary-foreground">
                    <Mail class="h-4 w-4" />
                    Réserver un stand
                </Link>
            </div>

            <div v-else class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <article
                    v-for="exhibitor in exhibitors"
                    :key="exhibitor.id"
                    class="flex flex-col rounded-xl border bg-card p-5 transition hover:shadow-md"
                >
                    <div class="flex h-20 items-center justify-center">
                        <img
                            v-if="exhibitor.logo_path"
                            :src="`/storage/${exhibitor.logo_path}`"
                            :alt="exhibitor.name"
                            class="max-h-full max-w-full object-contain"
                        />
                        <span v-else class="text-lg font-bold text-muted-foreground/60">{{ exhibitor.name }}</span>
                    </div>
                    <div class="mt-4 border-t pt-4">
                        <h3 class="text-base font-semibold">{{ exhibitor.name }}</h3>
                        <div v-if="exhibitor.booth_number" class="mt-1 flex items-center gap-1 text-xs text-muted-foreground">
                            <MapPin class="h-3 w-3" />
                            Stand {{ exhibitor.booth_number }}<span v-if="exhibitor.booth_size"> · {{ exhibitor.booth_size }}</span>
                        </div>
                        <p v-if="exhibitor.description" class="mt-2 line-clamp-3 text-sm text-muted-foreground">{{ exhibitor.description }}</p>
                        <div v-if="exhibitor.product_tags?.length" class="mt-3 flex flex-wrap gap-1">
                            <span v-for="tag in exhibitor.product_tags" :key="tag" class="rounded-full bg-muted px-2 py-0.5 text-[10px] font-medium">{{ tag }}</span>
                        </div>
                        <a
                            v-if="exhibitor.website"
                            :href="exhibitor.website"
                            target="_blank"
                            rel="noopener"
                            class="mt-4 inline-flex items-center gap-1 text-xs font-medium text-primary hover:underline"
                        >
                            Site web
                            <ExternalLink class="h-3 w-3" />
                        </a>
                    </div>
                </article>
            </div>
        </section>
    </PublicLayout>
</template>

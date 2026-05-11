<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { Award, ExternalLink, Mail } from 'lucide-vue-next';
import PublicLayout from '@/layouts/PublicLayout.vue';

defineOptions({ layout: null });

defineProps<{
    tiers: Array<{
        key: string;
        label: string;
        sponsors: Array<{
            id: number;
            slug: string;
            name: string;
            tier: string;
            logo_path: string | null;
            description: string | null;
            website: string | null;
        }>;
    }>;
    totalCount: number;
}>();

const tierStyle = (tier: string) =>
    ({
        platinum: { bg: 'bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-800 dark:to-slate-900', border: 'border-slate-300', text: 'text-slate-900 dark:text-slate-100', size: 'h-32' },
        gold: { bg: 'bg-gradient-to-br from-amber-50 to-amber-100 dark:from-amber-900/20 dark:to-amber-950/20', border: 'border-amber-300', text: 'text-amber-900 dark:text-amber-300', size: 'h-28' },
        silver: { bg: 'bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800/40 dark:to-gray-900/40', border: 'border-gray-300', text: 'text-gray-900 dark:text-gray-300', size: 'h-24' },
        bronze: { bg: 'bg-gradient-to-br from-orange-50 to-orange-100 dark:from-orange-900/20 dark:to-orange-950/20', border: 'border-orange-300', text: 'text-orange-900 dark:text-orange-300', size: 'h-20' },
    }[tier] ?? { bg: 'bg-card', border: 'border-border', text: 'text-foreground', size: 'h-20' });
</script>

<template>
    <Head title="Sponsors & partenaires" />
    <PublicLayout>
        <section class="border-b bg-gradient-to-br from-primary/5 to-background py-12 lg:py-16">
            <div class="container mx-auto px-4 lg:px-6">
                <div class="inline-flex items-center gap-2 rounded-full border bg-muted px-3 py-1 text-xs font-medium text-muted-foreground">
                    <Award class="h-3 w-3" />
                    Sponsors
                </div>
                <h1 class="mt-4 text-4xl font-bold tracking-tight sm:text-5xl">Sponsors & partenaires</h1>
                <p class="mt-3 max-w-2xl text-muted-foreground">
                    Merci à nos {{ totalCount }} partenaires qui rendent cette édition possible.
                </p>
            </div>
        </section>

        <section class="container mx-auto px-4 py-12 lg:px-6">
            <div v-if="!totalCount" class="rounded-xl border border-dashed bg-muted/30 py-16 text-center">
                <Award class="mx-auto h-10 w-10 text-muted-foreground/50" />
                <p class="mt-4 text-base font-medium">Devenez sponsor</p>
                <p class="mt-1 text-sm text-muted-foreground">Contactez-nous pour découvrir nos opportunités de partenariat.</p>
                <Link href="/contact" class="mt-6 inline-flex items-center gap-2 rounded-lg bg-primary px-5 py-2 text-sm font-medium text-primary-foreground">
                    <Mail class="h-4 w-4" />
                    Nous contacter
                </Link>
            </div>

            <div v-for="tier in tiers" :key="tier.key" class="mb-12">
                <div class="mb-6 flex items-center gap-3">
                    <h2 class="text-2xl font-bold">{{ tier.label }}</h2>
                    <div class="h-px flex-1 bg-border"></div>
                </div>

                <div
                    :class="[
                        'grid gap-4',
                        tier.key === 'platinum' ? 'sm:grid-cols-2 lg:grid-cols-3' : tier.key === 'gold' ? 'sm:grid-cols-2 lg:grid-cols-4' : 'sm:grid-cols-3 lg:grid-cols-5 xl:grid-cols-6',
                    ]"
                >
                    <a
                        v-for="sponsor in tier.sponsors"
                        :key="sponsor.id"
                        :href="sponsor.website ?? '#'"
                        :target="sponsor.website ? '_blank' : undefined"
                        rel="noopener"
                        :class="['group relative flex flex-col rounded-xl border-2 p-4 transition hover:shadow-lg', tierStyle(tier.key).bg, tierStyle(tier.key).border]"
                    >
                        <div :class="['flex items-center justify-center', tierStyle(tier.key).size]">
                            <img
                                v-if="sponsor.logo_path"
                                :src="`/storage/${sponsor.logo_path}`"
                                :alt="sponsor.name"
                                class="max-h-full max-w-full object-contain"
                            />
                            <span v-else :class="['text-center font-bold', tierStyle(tier.key).text]">{{ sponsor.name }}</span>
                        </div>
                        <div v-if="sponsor.description" class="mt-3 border-t pt-3">
                            <p class="line-clamp-2 text-xs text-muted-foreground">{{ sponsor.description }}</p>
                        </div>
                        <ExternalLink v-if="sponsor.website" class="absolute top-3 right-3 h-3 w-3 text-muted-foreground opacity-0 transition group-hover:opacity-100" />
                    </a>
                </div>
            </div>

            <!-- CTA partenariat -->
            <div v-if="totalCount" class="mt-16 rounded-2xl border bg-muted/30 p-8 text-center lg:p-12">
                <h3 class="text-2xl font-bold">Envie de devenir sponsor ?</h3>
                <p class="mt-2 text-muted-foreground">Plusieurs niveaux de partenariat disponibles avec une visibilité dédiée.</p>
                <Link href="/contact" class="mt-6 inline-flex items-center gap-2 rounded-lg bg-primary px-6 py-3 text-base font-semibold text-primary-foreground">
                    <Mail class="h-4 w-4" />
                    Demander notre dossier sponsors
                </Link>
            </div>
        </section>
    </PublicLayout>
</template>

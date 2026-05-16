<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { Sparkles, MapPin, Calendar, Users } from 'lucide-vue-next';
import PublicLayout from '@/layouts/PublicLayout.vue';

defineOptions({ layout: null });

defineProps<{ symposiums: Array<any> }>();

const fmt = (d: string) => new Date(d).toLocaleString('fr-FR', { dateStyle: 'medium', timeStyle: 'short' });
const fmtPrice = (v: number, c: string) => new Intl.NumberFormat('fr-FR', { style: 'currency', currency: c, maximumFractionDigits: 0 }).format(v);
</script>

<template>
    <Head title="Symposiums satellites" />
    <PublicLayout>
        <section class="border-b bg-gradient-to-br from-primary/5 to-background py-12 lg:py-16">
            <div class="container mx-auto px-4 lg:px-6">
                <div class="inline-flex items-center gap-2 rounded-full border bg-muted px-3 py-1 text-xs font-medium text-muted-foreground"><Sparkles class="h-3 w-3" /> Symposiums</div>
                <h1 class="mt-4 text-4xl font-bold tracking-tight sm:text-5xl">Symposiums satellites</h1>
                <p class="mt-3 max-w-2xl text-muted-foreground">Sessions sponsorisées par nos partenaires industriels. Inscription séparée requise.</p>
            </div>
        </section>

        <section class="container mx-auto px-4 py-12 lg:px-6">
            <div v-if="!symposiums.length" class="rounded-xl border border-dashed bg-muted/30 py-16 text-center">
                <Sparkles class="mx-auto h-10 w-10 text-muted-foreground/50" />
                <p class="mt-3 text-sm text-muted-foreground">Symposiums à venir.</p>
            </div>
            <div v-else class="grid gap-6 sm:grid-cols-2">
                <Link v-for="s in symposiums" :key="s.id" :href="`/symposiums/${s.slug}`" class="group block overflow-hidden rounded-xl border bg-card transition hover:shadow-lg">
                    <div class="aspect-video bg-muted">
                        <img v-if="s.cover_image_path" :src="`/storage/${s.cover_image_path}`" class="h-full w-full object-cover" :alt="s.title" />
                        <div v-else class="flex h-full w-full items-center justify-center bg-gradient-to-br from-primary/20 to-accent/20">
                            <img v-if="s.sponsor?.logo_path" :src="`/storage/${s.sponsor.logo_path}`" class="max-h-20 max-w-[60%] object-contain" :alt="s.sponsor.name" />
                            <Sparkles v-else class="h-16 w-16 text-primary/30" />
                        </div>
                    </div>
                    <div class="p-5">
                        <p v-if="s.sponsor" class="text-xs text-muted-foreground">Sponsorisé par <strong>{{ s.sponsor.name }}</strong></p>
                        <h3 class="mt-2 text-lg font-bold leading-tight group-hover:text-primary line-clamp-2">{{ s.title }}</h3>
                        <p v-if="s.subtitle" class="mt-1 text-sm text-muted-foreground line-clamp-2">{{ s.subtitle }}</p>
                        <dl class="mt-3 space-y-1 text-xs">
                            <div class="flex items-center gap-1"><Calendar class="h-3 w-3 text-muted-foreground" />{{ fmt(s.starts_at) }}</div>
                            <div v-if="s.room" class="flex items-center gap-1"><MapPin class="h-3 w-3" :style="{ color: s.room.color }" />{{ s.room.name }}</div>
                            <div v-if="s.capacity" class="flex items-center gap-1"><Users class="h-3 w-3 text-muted-foreground" />{{ s.registered_count }} / {{ s.capacity }} inscrits</div>
                        </dl>
                        <div class="mt-3 flex items-center justify-between">
                            <span class="text-sm font-bold">{{ s.price > 0 ? fmtPrice(s.price, s.currency) : 'Gratuit' }}</span>
                            <span v-if="s.is_full" class="text-xs text-red-600">COMPLET</span>
                            <span v-else class="text-xs text-primary">S'inscrire →</span>
                        </div>
                    </div>
                </Link>
            </div>
        </section>
    </PublicLayout>
</template>

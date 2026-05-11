<script setup lang="ts">
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { Calendar, MapPin, Microscope, FileText, Users, ArrowRight, Sparkles } from 'lucide-vue-next';
import PublicLayout from '@/layouts/PublicLayout.vue';
import Countdown from '@/components/Countdown.vue';

defineOptions({ layout: null });

const props = defineProps<{
    event: any;
    eventDates: { starts_at: string | null; ends_at: string | null };
    thematicAreas: Array<{ id: number; slug: string; name: string; color: string }>;
    featuredSpeakers: Array<any>;
    sponsors: Array<{ id: number; slug: string; name: string; tier: string; logo_path: string | null; website: string | null }>;
    registrationCategories: Array<{ id: number; slug: string; name: string; description: string | null; current_price: number; current_tier: string; currency: string }>;
}>();

const page = usePage();
const modules = computed(() => (page.props as any).modules ?? {});

const formattedDates = computed(() => {
    if (!props.event?.starts_at) return null;
    const start = new Date(props.event.starts_at);
    const end = props.event.ends_at ? new Date(props.event.ends_at) : null;
    const fmt = new Intl.DateTimeFormat('fr-FR', { day: 'numeric', month: 'long', year: 'numeric' });
    if (end) {
        const fmtDayMonth = new Intl.DateTimeFormat('fr-FR', { day: 'numeric', month: 'long' });
        return `${fmtDayMonth.format(start)} – ${fmt.format(end)}`;
    }
    return fmt.format(start);
});

const formatPrice = (value: number, currency: string) =>
    new Intl.NumberFormat('fr-FR', { style: 'currency', currency, maximumFractionDigits: 0 }).format(value);

const tierLabel = (tier: string) =>
    ({
        platinum: 'Platine',
        gold: 'Or',
        silver: 'Argent',
        bronze: 'Bronze',
        partner: 'Partenaire',
        institutional: 'Institutionnel',
        media: 'Média',
    }[tier] ?? tier);
</script>

<template>
    <Head>
        <title>{{ event?.name ?? 'Congresia' }}</title>
        <meta name="description" :content="event?.tagline ?? 'Plateforme de gestion de congrès médicaux'" />
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>

    <PublicLayout>
        <!-- ============ HERO ============ -->
        <section class="relative overflow-hidden border-b">
            <!-- Décoration arrière-plan -->
            <div class="absolute inset-0 -z-10 bg-gradient-to-br from-primary/10 via-background to-accent/10"></div>
            <div class="absolute top-1/2 left-1/2 -z-10 h-[600px] w-[600px] -translate-x-1/2 -translate-y-1/2 rounded-full bg-primary/5 blur-3xl"></div>

            <div class="container mx-auto px-4 py-16 lg:px-6 lg:py-24">
                <div class="mx-auto max-w-4xl text-center">
                    <!-- Badge thème -->
                    <div v-if="event?.theme" class="mb-6 inline-flex items-center gap-2 rounded-full border border-primary/20 bg-primary/5 px-4 py-1.5 text-sm font-medium text-primary">
                        <Sparkles class="h-3.5 w-3.5" />
                        Thème : {{ event.theme }}
                    </div>

                    <h1 class="text-balance text-4xl font-bold tracking-tight sm:text-5xl lg:text-6xl">
                        {{ event?.name ?? 'Congresia' }}
                    </h1>

                    <p v-if="event?.tagline" class="mt-4 text-lg text-muted-foreground sm:text-xl">
                        {{ event.tagline }}
                    </p>

                    <!-- Dates + lieu -->
                    <div v-if="formattedDates || event?.venue_city" class="mt-8 flex flex-col items-center justify-center gap-4 sm:flex-row sm:gap-8">
                        <div v-if="formattedDates" class="flex items-center gap-2 text-base font-medium">
                            <Calendar class="h-5 w-5 text-primary" />
                            <span>{{ formattedDates }}</span>
                        </div>
                        <div v-if="event?.venue_city" class="flex items-center gap-2 text-base font-medium">
                            <MapPin class="h-5 w-5 text-primary" />
                            <span>{{ event.venue_name ? event.venue_name + ', ' : '' }}{{ event.venue_city }}</span>
                        </div>
                    </div>

                    <!-- Description courte -->
                    <p v-if="event?.description" class="mx-auto mt-6 max-w-2xl text-base text-muted-foreground">
                        {{ event.description }}
                    </p>

                    <!-- CTAs -->
                    <div class="mt-10 flex flex-col items-center justify-center gap-3 sm:flex-row">
                        <Link
                            v-if="modules.registrations_enabled && event?.registration_open"
                            href="/register"
                            class="inline-flex items-center gap-2 rounded-lg bg-primary px-6 py-3 text-base font-semibold text-primary-foreground shadow-md transition hover:bg-primary/90 hover:shadow-lg"
                        >
                            Je m'inscris
                            <ArrowRight class="h-4 w-4" />
                        </Link>
                        <Link
                            v-if="modules.abstracts_enabled"
                            href="/abstracts/submit"
                            class="inline-flex items-center gap-2 rounded-lg border border-input bg-background px-6 py-3 text-base font-semibold hover:bg-accent"
                        >
                            <FileText class="h-4 w-4" />
                            Soumettre un résumé
                        </Link>
                    </div>

                    <!-- Compte à rebours -->
                    <div v-if="event?.starts_at" class="mx-auto mt-12 max-w-2xl">
                        <p class="mb-3 text-xs uppercase tracking-wider text-muted-foreground">Plus que</p>
                        <Countdown :target="event.starts_at" />
                    </div>
                </div>
            </div>
        </section>

        <!-- ============ THEMATIQUES ============ -->
        <section v-if="thematicAreas.length" class="container mx-auto px-4 py-16 lg:px-6 lg:py-20">
            <div class="mx-auto max-w-2xl text-center">
                <div class="inline-flex items-center gap-2 rounded-full border bg-muted px-3 py-1 text-xs font-medium text-muted-foreground">
                    <Microscope class="h-3 w-3" />
                    Domaines abordés
                </div>
                <h2 class="mt-4 text-3xl font-bold tracking-tight sm:text-4xl">Thématiques scientifiques</h2>
                <p class="mt-3 text-muted-foreground">{{ thematicAreas.length }} grands axes pour explorer en profondeur les avancées et les perspectives.</p>
            </div>

            <div class="mt-12 grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5">
                <div
                    v-for="theme in thematicAreas"
                    :key="theme.id"
                    class="group relative overflow-hidden rounded-xl border bg-card p-5 transition hover:border-primary/30 hover:shadow-md"
                >
                    <div
                        class="mb-3 h-1 w-12 rounded-full transition-all group-hover:w-full"
                        :style="{ backgroundColor: theme.color }"
                    ></div>
                    <h3 class="text-sm font-semibold leading-tight">{{ theme.name }}</h3>
                </div>
            </div>
        </section>

        <!-- ============ TARIFS ============ -->
        <section v-if="registrationCategories.length" class="border-y bg-muted/30 py-16 lg:py-20">
            <div class="container mx-auto px-4 lg:px-6">
                <div class="mx-auto max-w-2xl text-center">
                    <h2 class="text-3xl font-bold tracking-tight sm:text-4xl">Tarifs d'inscription</h2>
                    <p class="mt-3 text-muted-foreground">Choisissez la catégorie qui vous correspond. Tarifs en FCFA, paiement par Mobile Money ou carte.</p>
                </div>

                <div class="mt-12 grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                    <div
                        v-for="cat in registrationCategories"
                        :key="cat.id"
                        class="flex flex-col rounded-xl border bg-card p-6 shadow-sm transition hover:shadow-md"
                    >
                        <h3 class="text-lg font-semibold">{{ cat.name }}</h3>
                        <p v-if="cat.description" class="mt-1 line-clamp-2 text-sm text-muted-foreground">{{ cat.description }}</p>
                        <div class="mt-4 flex items-baseline gap-1">
                            <span class="text-3xl font-bold">{{ formatPrice(cat.current_price, cat.currency) }}</span>
                        </div>
                        <span class="mt-1 text-xs uppercase tracking-wider text-muted-foreground">
                            Tarif {{ cat.current_tier === 'early_bird' ? 'Early Bird' : cat.current_tier === 'standard' ? 'Standard' : 'Late' }}
                        </span>
                    </div>
                </div>

                <div class="mt-10 text-center">
                    <Link
                        v-if="event?.registration_open"
                        href="/register"
                        class="inline-flex items-center gap-2 rounded-lg bg-primary px-6 py-3 text-base font-semibold text-primary-foreground shadow-md hover:bg-primary/90"
                    >
                        S'inscrire maintenant
                        <ArrowRight class="h-4 w-4" />
                    </Link>
                </div>
            </div>
        </section>

        <!-- ============ INTERVENANTS A LA UNE ============ -->
        <section v-if="featuredSpeakers.length" class="container mx-auto px-4 py-16 lg:px-6 lg:py-20">
            <div class="flex flex-col items-center justify-between gap-4 sm:flex-row">
                <div>
                    <div class="inline-flex items-center gap-2 rounded-full border bg-muted px-3 py-1 text-xs font-medium text-muted-foreground">
                        <Users class="h-3 w-3" />
                        Conférenciers
                    </div>
                    <h2 class="mt-4 text-3xl font-bold tracking-tight sm:text-4xl">Ils interviendront</h2>
                </div>
                <Link href="/intervenants" class="inline-flex items-center gap-1 text-sm font-medium text-primary hover:underline">
                    Tous les intervenants
                    <ArrowRight class="h-4 w-4" />
                </Link>
            </div>

            <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <div
                    v-for="speaker in featuredSpeakers"
                    :key="speaker.id"
                    class="group flex gap-4 rounded-xl border bg-card p-5 transition hover:shadow-md"
                >
                    <div class="h-16 w-16 shrink-0 overflow-hidden rounded-full bg-muted">
                        <img
                            v-if="speaker.photo_path"
                            :src="`/storage/${speaker.photo_path}`"
                            :alt="speaker.first_name + ' ' + speaker.last_name"
                            class="h-full w-full object-cover"
                        />
                        <div v-else class="flex h-full w-full items-center justify-center text-lg font-semibold text-muted-foreground">
                            {{ (speaker.first_name?.[0] ?? '') + (speaker.last_name?.[0] ?? '') }}
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="truncate text-base font-semibold">
                            {{ speaker.salutation ? speaker.salutation + ' ' : '' }}{{ speaker.first_name }} {{ speaker.last_name }}
                        </h3>
                        <p v-if="speaker.job_title" class="truncate text-sm text-muted-foreground">{{ speaker.job_title }}</p>
                        <p v-if="speaker.affiliation" class="mt-1 truncate text-xs text-muted-foreground">{{ speaker.affiliation }}</p>
                        <span v-if="speaker.is_keynote" class="mt-2 inline-block rounded-full bg-primary/10 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wider text-primary">
                            Keynote
                        </span>
                    </div>
                </div>
            </div>
        </section>

        <!-- ============ SPONSORS ============ -->
        <section v-if="sponsors.length" class="border-t bg-muted/30 py-16 lg:py-20">
            <div class="container mx-auto px-4 lg:px-6">
                <div class="mx-auto max-w-2xl text-center">
                    <h2 class="text-3xl font-bold tracking-tight sm:text-4xl">Nos sponsors & partenaires</h2>
                    <p class="mt-3 text-muted-foreground">Ils nous accompagnent dans cette édition.</p>
                </div>

                <div class="mt-12 flex flex-wrap items-center justify-center gap-4">
                    <a
                        v-for="sponsor in sponsors"
                        :key="sponsor.id"
                        :href="sponsor.website ?? '#'"
                        :target="sponsor.website ? '_blank' : undefined"
                        rel="noopener"
                        class="group flex h-24 w-44 flex-col items-center justify-center gap-1 rounded-xl border bg-card p-4 transition hover:border-primary/30 hover:shadow-md"
                    >
                        <img
                            v-if="sponsor.logo_path"
                            :src="`/storage/${sponsor.logo_path}`"
                            :alt="sponsor.name"
                            class="max-h-12 max-w-full object-contain grayscale transition group-hover:grayscale-0"
                        />
                        <span v-else class="text-sm font-semibold">{{ sponsor.name }}</span>
                        <span class="text-[10px] uppercase tracking-wider text-muted-foreground">{{ tierLabel(sponsor.tier) }}</span>
                    </a>
                </div>

                <div class="mt-10 text-center">
                    <Link href="/sponsors" class="text-sm font-medium text-primary hover:underline">
                        Devenir sponsor →
                    </Link>
                </div>
            </div>
        </section>

        <!-- ============ CTA FINAL ============ -->
        <section v-if="modules.registrations_enabled && event?.registration_open" class="container mx-auto px-4 py-16 lg:px-6 lg:py-20">
            <div class="mx-auto max-w-3xl rounded-2xl bg-gradient-to-br from-primary to-primary/80 px-8 py-12 text-center text-primary-foreground shadow-lg lg:px-16 lg:py-16">
                <h2 class="text-3xl font-bold tracking-tight sm:text-4xl">
                    Rejoignez l'édition {{ new Date(event.starts_at).getFullYear() }}
                </h2>
                <p class="mt-4 text-lg opacity-90">
                    Inscriptions ouvertes — places limitées.
                </p>
                <div class="mt-8">
                    <Link
                        href="/register"
                        class="inline-flex items-center gap-2 rounded-lg bg-background px-8 py-3 text-base font-semibold text-foreground shadow-md transition hover:bg-background/95"
                    >
                        Je m'inscris
                        <ArrowRight class="h-4 w-4" />
                    </Link>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>

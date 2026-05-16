<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import { ArrowLeft, Calendar, Clock, MapPin, Users, Award, Globe, Video, FileText, Sparkles } from 'lucide-vue-next';
import PublicLayout from '@/layouts/PublicLayout.vue';

defineOptions({ layout: null });

const props = defineProps<{
    session: any;
}>();

const formattedStart = computed(() => new Date(props.session.starts_at).toLocaleString('fr-FR', { dateStyle: 'full', timeStyle: 'short' }));
const formattedEnd = computed(() => new Date(props.session.ends_at).toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' }));

const typeLabels: Record<string, string> = {
    plenary: 'Session plénière',
    workshop: 'Atelier',
    oral: 'Communication orale',
    poster: 'Poster',
    symposium: 'Symposium',
    keynote: 'Keynote',
    break: 'Pause',
    ceremony: 'Cérémonie',
};

const youtubeEmbed = computed(() => {
    if (!props.session.is_streamed || !props.session.stream_url) return null;
    if (props.session.stream_provider === 'youtube') {
        const match = props.session.stream_url.match(/(?:youtube\.com\/(?:watch\?v=|live\/)|youtu\.be\/)([^&?\s]+)/);
        if (match) return `https://www.youtube.com/embed/${match[1]}`;
    }
    return props.session.stream_url;
});
</script>

<template>
    <Head :title="session.title" />
    <PublicLayout>
        <article class="container mx-auto max-w-4xl px-4 py-10 lg:px-6">
            <Link href="/programme" class="inline-flex items-center gap-1 text-sm text-muted-foreground hover:text-foreground">
                <ArrowLeft class="h-4 w-4" /> Retour au programme
            </Link>

            <header class="mt-6">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="rounded-full bg-primary/10 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-primary">{{ typeLabels[session.type] ?? session.type }}</span>
                    <span v-if="session.is_featured" class="inline-flex items-center gap-1 rounded-full bg-amber-500/10 px-3 py-1 text-xs font-semibold text-amber-700 dark:text-amber-400">
                        <Sparkles class="h-3 w-3" /> À ne pas manquer
                    </span>
                    <span v-if="session.cme_credits > 0" class="inline-flex items-center gap-1 rounded-full bg-emerald-500/10 px-3 py-1 text-xs font-semibold text-emerald-700 dark:text-emerald-400">
                        <Award class="h-3 w-3" /> {{ session.cme_credits }} crédit{{ session.cme_credits > 1 ? 's' : '' }} CME
                    </span>
                </div>

                <h1 class="mt-4 text-3xl font-bold tracking-tight sm:text-4xl">{{ session.title }}</h1>
                <p v-if="session.subtitle" class="mt-2 text-lg text-muted-foreground">{{ session.subtitle }}</p>

                <Link v-if="session.parent" :href="`/programme/${session.parent.slug}`" class="mt-3 inline-block text-sm text-primary hover:underline">
                    Sous-session de : {{ session.parent.title }}
                </Link>
            </header>

            <!-- Infos -->
            <div class="mt-8 grid gap-4 sm:grid-cols-3">
                <div class="rounded-lg border bg-card p-4">
                    <Calendar class="h-5 w-5 text-primary" />
                    <p class="mt-2 text-xs uppercase text-muted-foreground">Date</p>
                    <p class="mt-1 text-sm font-semibold">{{ formattedStart }}</p>
                </div>
                <div class="rounded-lg border bg-card p-4">
                    <Clock class="h-5 w-5 text-primary" />
                    <p class="mt-2 text-xs uppercase text-muted-foreground">Durée</p>
                    <p class="mt-1 text-sm font-semibold">{{ session.duration_minutes }} min (jusqu'à {{ formattedEnd }})</p>
                </div>
                <div v-if="session.room" class="rounded-lg border bg-card p-4">
                    <MapPin class="h-5 w-5" :style="{ color: session.room.color }" />
                    <p class="mt-2 text-xs uppercase text-muted-foreground">Salle</p>
                    <p class="mt-1 text-sm font-semibold">{{ session.room.name }}</p>
                </div>
            </div>

            <!-- Streaming live -->
            <section v-if="session.is_streamed" class="mt-8 rounded-xl border-2 border-primary/30 bg-primary/5 p-1">
                <div class="aspect-video overflow-hidden rounded-lg bg-black">
                    <iframe v-if="youtubeEmbed" :src="youtubeEmbed" class="h-full w-full" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    <div v-else class="flex h-full w-full items-center justify-center text-white">
                        <div class="text-center">
                            <Video class="mx-auto h-12 w-12" />
                            <p class="mt-2">Live à venir</p>
                        </div>
                    </div>
                </div>
                <p class="px-4 py-2 text-xs text-muted-foreground">🔴 Cette session est retransmise en direct</p>
            </section>

            <!-- Replay si video_url -->
            <section v-else-if="session.video_url" class="mt-8 rounded-xl border bg-card p-4">
                <h3 class="flex items-center gap-2 text-sm font-bold"><Video class="h-4 w-4" /> Replay disponible</h3>
                <a :href="session.video_url" target="_blank" rel="noopener" class="mt-2 inline-block text-sm text-primary hover:underline">Voir la vidéo →</a>
            </section>

            <!-- Description -->
            <section v-if="session.description" class="mt-8">
                <h2 class="text-xl font-bold">Description</h2>
                <p class="mt-3 whitespace-pre-line text-sm leading-relaxed">{{ session.description }}</p>
            </section>

            <!-- Intervenants -->
            <section v-if="session.speakers.length" class="mt-8">
                <h2 class="flex items-center gap-2 text-xl font-bold"><Users class="h-5 w-5" /> Intervenants</h2>
                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                    <div v-for="(sp, i) in session.speakers" :key="i" class="flex gap-3 rounded-lg border bg-card p-4">
                        <div class="h-12 w-12 shrink-0 overflow-hidden rounded-full bg-muted">
                            <img v-if="sp.photo_path" :src="`/storage/${sp.photo_path}`" :alt="sp.name" class="h-full w-full object-cover" />
                            <div v-else class="flex h-full w-full items-center justify-center text-sm font-bold text-muted-foreground">{{ sp.name.split(' ').map((n: string) => n[0]).slice(0, 2).join('') }}</div>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="font-semibold">{{ sp.name }}</p>
                            <p v-if="sp.title" class="text-xs text-muted-foreground">{{ sp.title }}</p>
                            <p v-if="sp.affiliation" class="text-xs text-muted-foreground">{{ sp.affiliation }}</p>
                            <p v-if="sp.talk_title" class="mt-1 text-xs font-medium text-primary">« {{ sp.talk_title }} »</p>
                            <span v-if="sp.role !== 'speaker'" class="mt-1 inline-block rounded-full bg-muted px-2 py-0.5 text-[10px] font-semibold uppercase">{{ sp.role }}</span>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Sous-sessions (si symposium parent) -->
            <section v-if="session.children?.length" class="mt-8">
                <h2 class="text-xl font-bold">Programme détaillé</h2>
                <div class="mt-3 space-y-2">
                    <Link v-for="c in session.children" :key="c.slug" :href="`/programme/${c.slug}`" class="block rounded-lg border bg-card p-3 transition hover:shadow-md">
                        <div class="flex items-center justify-between gap-3">
                            <div class="min-w-0">
                                <p class="text-xs text-muted-foreground">{{ c.starts_at }} – {{ c.ends_at }}</p>
                                <p class="font-medium">{{ c.title }}</p>
                                <p v-if="c.speakers" class="text-xs text-muted-foreground">{{ c.speakers }}</p>
                            </div>
                        </div>
                    </Link>
                </div>
            </section>

            <!-- Topics -->
            <section v-if="session.topics?.length" class="mt-8">
                <h2 class="text-xl font-bold">Thématiques</h2>
                <div class="mt-3 flex flex-wrap gap-2">
                    <span v-for="t in session.topics" :key="t" class="rounded-full bg-muted px-3 py-1 text-xs">{{ t }}</span>
                </div>
            </section>

            <!-- Slides -->
            <section v-if="session.slides_path" class="mt-8">
                <a :href="`/storage/${session.slides_path}`" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-lg border bg-card px-4 py-2 text-sm hover:bg-accent">
                    <FileText class="h-4 w-4" /> Télécharger les slides
                </a>
            </section>

            <!-- Langue -->
            <div class="mt-8 flex items-center gap-2 text-xs text-muted-foreground">
                <Globe class="h-3 w-3" /> Session en {{ session.language === 'fr' ? 'français' : session.language === 'en' ? 'anglais' : session.language }}
            </div>
        </article>
    </PublicLayout>
</template>

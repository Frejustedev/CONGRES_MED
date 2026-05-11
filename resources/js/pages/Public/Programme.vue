<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { Calendar, Clock, MapPin, Users, Sparkles, Award } from 'lucide-vue-next';
import PublicLayout from '@/layouts/PublicLayout.vue';

defineOptions({ layout: null });

const props = defineProps<{
    days: Array<{
        date: string;
        label: string;
        sessions: Array<{
            id: number;
            slug: string;
            type: string;
            title: string;
            subtitle: string | null;
            starts_at: string;
            ends_at: string;
            room: { name: string; color: string } | null;
            language: string;
            is_featured: boolean;
            cme_credits: number;
            speakers: Array<{ name: string; title: string | null; affiliation: string | null }>;
        }>;
    }>;
    rooms: Array<{ id: number; slug: string; name: string; color: string }>;
    thematicAreas: Array<{ id: number; slug: string; name: string; color: string }>;
}>();

const selectedRoom = ref<string | null>(null);
const selectedType = ref<string | null>(null);
const activeDay = ref<string | null>(props.days[0]?.date ?? null);

const sessionTypes = computed(() => {
    const set = new Set<string>();
    props.days.forEach((d) => d.sessions.forEach((s) => set.add(s.type)));
    return Array.from(set);
});

const typeLabel = (t: string) =>
    ({
        plenary: 'Plénière',
        workshop: 'Atelier',
        oral: 'Communication orale',
        poster: 'Poster',
        symposium: 'Symposium',
        keynote: 'Keynote',
        break: 'Pause',
        ceremony: 'Cérémonie',
    }[t] ?? t);

const typeColor = (t: string) =>
    ({
        plenary: 'bg-primary/10 text-primary border-primary/20',
        keynote: 'bg-amber-500/10 text-amber-700 border-amber-500/20 dark:text-amber-400',
        workshop: 'bg-emerald-500/10 text-emerald-700 border-emerald-500/20 dark:text-emerald-400',
        oral: 'bg-sky-500/10 text-sky-700 border-sky-500/20 dark:text-sky-400',
        symposium: 'bg-violet-500/10 text-violet-700 border-violet-500/20 dark:text-violet-400',
        poster: 'bg-pink-500/10 text-pink-700 border-pink-500/20 dark:text-pink-400',
        break: 'bg-muted text-muted-foreground border-border',
        ceremony: 'bg-rose-500/10 text-rose-700 border-rose-500/20 dark:text-rose-400',
    }[t] ?? 'bg-muted text-muted-foreground');

const visibleDays = computed(() =>
    props.days.map((day) => ({
        ...day,
        sessions: day.sessions.filter(
            (s) =>
                (!selectedRoom.value || s.room?.name === selectedRoom.value) &&
                (!selectedType.value || s.type === selectedType.value),
        ),
    })),
);

const activeDayData = computed(() => visibleDays.value.find((d) => d.date === activeDay.value));
</script>

<template>
    <Head title="Programme scientifique" />
    <PublicLayout>
        <section class="border-b bg-gradient-to-br from-primary/5 to-background py-12 lg:py-16">
            <div class="container mx-auto px-4 lg:px-6">
                <div class="inline-flex items-center gap-2 rounded-full border bg-muted px-3 py-1 text-xs font-medium text-muted-foreground">
                    <Calendar class="h-3 w-3" />
                    Programme
                </div>
                <h1 class="mt-4 text-4xl font-bold tracking-tight sm:text-5xl">Programme scientifique</h1>
                <p class="mt-3 max-w-2xl text-muted-foreground">
                    Découvrez les sessions plénières, ateliers, communications orales, posters et symposiums sponsorisés. Sélectionnez un jour, une salle ou un type de session pour filtrer.
                </p>
            </div>
        </section>

        <section class="container mx-auto px-4 py-12 lg:px-6">
            <div v-if="!days.length" class="rounded-xl border border-dashed bg-muted/30 py-16 text-center">
                <Calendar class="mx-auto h-10 w-10 text-muted-foreground/50" />
                <p class="mt-4 text-base font-medium">Programme bientôt disponible</p>
                <p class="mt-1 text-sm text-muted-foreground">Les sessions seront publiées dans les prochaines semaines.</p>
            </div>

            <template v-else>
                <!-- Filtres -->
                <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                    <div class="flex flex-wrap gap-2">
                        <button
                            v-for="day in visibleDays"
                            :key="day.date"
                            type="button"
                            @click="activeDay = day.date"
                            class="rounded-lg border px-4 py-2 text-sm font-medium transition"
                            :class="activeDay === day.date ? 'border-primary bg-primary text-primary-foreground' : 'hover:bg-accent'"
                        >
                            {{ day.label }}
                        </button>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <select v-model="selectedRoom" class="rounded-md border bg-background px-3 py-2 text-sm">
                            <option :value="null">Toutes les salles</option>
                            <option v-for="room in rooms" :key="room.id" :value="room.name">{{ room.name }}</option>
                        </select>
                        <select v-model="selectedType" class="rounded-md border bg-background px-3 py-2 text-sm">
                            <option :value="null">Tous les types</option>
                            <option v-for="t in sessionTypes" :key="t" :value="t">{{ typeLabel(t) }}</option>
                        </select>
                    </div>
                </div>

                <!-- Programme -->
                <div v-if="activeDayData" class="mt-8 space-y-3">
                    <div v-if="!activeDayData.sessions.length" class="rounded-xl border border-dashed bg-muted/30 py-12 text-center text-sm text-muted-foreground">
                        Aucune session pour ces filtres.
                    </div>

                    <article
                        v-for="session in activeDayData.sessions"
                        :key="session.id"
                        class="group grid gap-3 rounded-xl border bg-card p-5 transition hover:shadow-md sm:grid-cols-[140px_1fr]"
                    >
                        <div class="flex flex-col items-start gap-2 border-b pb-3 sm:border-b-0 sm:border-r sm:pr-3 sm:pb-0">
                            <div class="flex items-center gap-1.5 text-sm font-semibold">
                                <Clock class="h-4 w-4 text-muted-foreground" />
                                <span>{{ session.starts_at }} – {{ session.ends_at }}</span>
                            </div>
                            <span :class="['rounded-full border px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wider', typeColor(session.type)]">
                                {{ typeLabel(session.type) }}
                            </span>
                            <span v-if="session.is_featured" class="flex items-center gap-1 text-[10px] font-semibold uppercase tracking-wider text-amber-600 dark:text-amber-400">
                                <Sparkles class="h-3 w-3" />
                                À ne pas manquer
                            </span>
                            <span v-if="session.cme_credits > 0" class="flex items-center gap-1 text-[10px] font-semibold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">
                                <Award class="h-3 w-3" />
                                {{ session.cme_credits }} CME
                            </span>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold leading-tight">{{ session.title }}</h3>
                            <p v-if="session.subtitle" class="mt-1 text-sm text-muted-foreground">{{ session.subtitle }}</p>
                            <div v-if="session.speakers.length" class="mt-3 flex items-start gap-2 text-sm">
                                <Users class="mt-0.5 h-4 w-4 shrink-0 text-muted-foreground" />
                                <div class="flex flex-wrap gap-x-3 gap-y-1">
                                    <span v-for="(sp, i) in session.speakers" :key="i" class="text-foreground">
                                        <span class="font-medium">{{ sp.name }}</span>
                                        <span v-if="sp.affiliation" class="text-muted-foreground"> · {{ sp.affiliation }}</span>
                                    </span>
                                </div>
                            </div>
                            <div v-if="session.room" class="mt-2 flex items-center gap-1.5 text-xs text-muted-foreground">
                                <MapPin class="h-3 w-3" :style="{ color: session.room.color }" />
                                {{ session.room.name }}
                            </div>
                        </div>
                    </article>
                </div>
            </template>
        </section>
    </PublicLayout>
</template>

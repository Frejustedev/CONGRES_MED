<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { Users, Search, Globe, Linkedin, Twitter, Sparkles } from 'lucide-vue-next';
import PublicLayout from '@/layouts/PublicLayout.vue';

defineOptions({ layout: null });

const props = defineProps<{
    speakers: Array<{
        id: number;
        slug: string;
        name: string;
        job_title: string | null;
        affiliation: string | null;
        country: string | null;
        photo_path: string | null;
        biography: string | null;
        is_keynote: boolean;
        orcid: string | null;
        linkedin: string | null;
        twitter: string | null;
        website: string | null;
    }>;
    keynoteCount: number;
    totalCount: number;
}>();

const search = ref('');

const filteredSpeakers = computed(() => {
    if (!search.value) return props.speakers;
    const q = search.value.toLowerCase();
    return props.speakers.filter(
        (s) =>
            s.name.toLowerCase().includes(q) ||
            (s.job_title ?? '').toLowerCase().includes(q) ||
            (s.affiliation ?? '').toLowerCase().includes(q),
    );
});

const keynotes = computed(() => filteredSpeakers.value.filter((s) => s.is_keynote));
const others = computed(() => filteredSpeakers.value.filter((s) => !s.is_keynote));
</script>

<template>
    <Head title="Intervenants" />
    <PublicLayout>
        <section class="border-b bg-gradient-to-br from-primary/5 to-background py-12 lg:py-16">
            <div class="container mx-auto px-4 lg:px-6">
                <div class="inline-flex items-center gap-2 rounded-full border bg-muted px-3 py-1 text-xs font-medium text-muted-foreground">
                    <Users class="h-3 w-3" />
                    Conférenciers
                </div>
                <h1 class="mt-4 text-4xl font-bold tracking-tight sm:text-5xl">Intervenants</h1>
                <p class="mt-3 max-w-2xl text-muted-foreground">
                    {{ totalCount }} intervenants nationaux et internationaux<span v-if="keynoteCount"> dont {{ keynoteCount }} keynote{{ keynoteCount > 1 ? 's' : '' }}</span>.
                </p>

                <div class="mt-6 max-w-md">
                    <div class="relative">
                        <Search class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-muted-foreground" />
                        <input
                            v-model="search"
                            type="search"
                            placeholder="Rechercher un intervenant, une affiliation..."
                            class="w-full rounded-lg border bg-background py-2 pl-10 pr-4 text-sm outline-none ring-primary focus:ring-2"
                        />
                    </div>
                </div>
            </div>
        </section>

        <section class="container mx-auto px-4 py-12 lg:px-6">
            <div v-if="!totalCount" class="rounded-xl border border-dashed bg-muted/30 py-16 text-center">
                <Users class="mx-auto h-10 w-10 text-muted-foreground/50" />
                <p class="mt-4 text-base font-medium">Liste des intervenants à venir</p>
                <p class="mt-1 text-sm text-muted-foreground">Le comité scientifique finalise la sélection.</p>
            </div>

            <template v-else>
                <!-- Keynotes -->
                <div v-if="keynotes.length" class="mb-12">
                    <div class="mb-6 flex items-center gap-2">
                        <Sparkles class="h-5 w-5 text-amber-500" />
                        <h2 class="text-xl font-semibold">Keynotes</h2>
                    </div>
                    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        <article
                            v-for="speaker in keynotes"
                            :key="speaker.id"
                            class="overflow-hidden rounded-xl border-2 border-amber-500/30 bg-card transition hover:shadow-lg"
                        >
                            <div class="aspect-[4/3] bg-muted">
                                <img
                                    v-if="speaker.photo_path"
                                    :src="`/storage/${speaker.photo_path}`"
                                    :alt="speaker.name"
                                    class="h-full w-full object-cover"
                                />
                                <div v-else class="flex h-full w-full items-center justify-center text-4xl font-bold text-muted-foreground/40">
                                    {{ speaker.name.split(' ').map(n => n[0]).join('').slice(0, 2).toUpperCase() }}
                                </div>
                            </div>
                            <div class="p-5">
                                <span class="rounded-full bg-amber-500/10 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wider text-amber-700 dark:text-amber-400">Keynote</span>
                                <h3 class="mt-2 text-lg font-bold leading-tight">{{ speaker.name }}</h3>
                                <p v-if="speaker.job_title" class="mt-1 text-sm text-muted-foreground">{{ speaker.job_title }}</p>
                                <p v-if="speaker.affiliation" class="text-xs text-muted-foreground">{{ speaker.affiliation }}</p>
                                <p v-if="speaker.biography" class="mt-3 line-clamp-3 text-sm">{{ speaker.biography }}</p>
                            </div>
                        </article>
                    </div>
                </div>

                <!-- Autres intervenants -->
                <div v-if="others.length">
                    <h2 v-if="keynotes.length" class="mb-6 text-xl font-semibold">Autres intervenants</h2>
                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                        <article
                            v-for="speaker in others"
                            :key="speaker.id"
                            class="flex gap-3 rounded-xl border bg-card p-4 transition hover:shadow-md"
                        >
                            <div class="h-14 w-14 shrink-0 overflow-hidden rounded-full bg-muted">
                                <img
                                    v-if="speaker.photo_path"
                                    :src="`/storage/${speaker.photo_path}`"
                                    :alt="speaker.name"
                                    class="h-full w-full object-cover"
                                />
                                <div v-else class="flex h-full w-full items-center justify-center text-base font-semibold text-muted-foreground">
                                    {{ speaker.name.split(' ').map(n => n[0]).join('').slice(0, 2).toUpperCase() }}
                                </div>
                            </div>
                            <div class="min-w-0 flex-1">
                                <h3 class="truncate text-sm font-semibold">{{ speaker.name }}</h3>
                                <p v-if="speaker.job_title" class="truncate text-xs text-muted-foreground">{{ speaker.job_title }}</p>
                                <p v-if="speaker.affiliation" class="truncate text-xs text-muted-foreground">{{ speaker.affiliation }}</p>
                            </div>
                        </article>
                    </div>
                </div>
            </template>
        </section>
    </PublicLayout>
</template>

<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import { Star, Loader2 } from 'lucide-vue-next';
import PublicLayout from '@/layouts/PublicLayout.vue';

defineOptions({ layout: null });

const props = defineProps<{ registration: { reference: string; participant_name: string }; topics: string[] }>();

const form = useForm({
    nps_score: 8,
    overall_rating: 4,
    content_rating: 4,
    venue_rating: 4,
    organization_rating: 4,
    networking_rating: 4,
    topics_of_interest_next_edition: [] as string[],
    positive_feedback: '',
    improvement_feedback: '',
    comments: '',
    would_recommend: true,
    would_return: true,
});

function submit() {
    form.post(`/sondage/${props.registration.reference}`);
}

function toggleTopic(t: string) {
    const i = form.topics_of_interest_next_edition.indexOf(t);
    if (i === -1) form.topics_of_interest_next_edition.push(t); else form.topics_of_interest_next_edition.splice(i, 1);
}
</script>

<template>
    <Head title="Votre avis" />
    <PublicLayout>
        <section class="container mx-auto max-w-2xl px-4 py-10 lg:px-6">
            <h1 class="text-3xl font-bold">Votre avis nous intéresse</h1>
            <p class="mt-2 text-muted-foreground">Merci {{ registration.participant_name }} d'avoir participé. 5 minutes pour nous aider à améliorer les prochaines éditions.</p>

            <form @submit.prevent="submit" class="mt-8 space-y-6">
                <!-- NPS -->
                <fieldset class="rounded-xl border bg-card p-5">
                    <legend class="px-2 text-sm font-semibold">Recommanderiez-vous ce congrès ? (0 = jamais, 10 = absolument)</legend>
                    <div class="mt-3 flex flex-wrap gap-1">
                        <button v-for="n in 11" :key="n - 1" type="button" @click="form.nps_score = n - 1" :class="['h-10 w-10 rounded-md border text-sm font-bold transition', form.nps_score === n - 1 ? 'border-primary bg-primary text-primary-foreground scale-110' : 'hover:bg-accent']">{{ n - 1 }}</button>
                    </div>
                </fieldset>

                <!-- Ratings -->
                <fieldset class="space-y-3 rounded-xl border bg-card p-5">
                    <legend class="px-2 text-sm font-semibold">Notes (1 à 5 étoiles)</legend>
                    <div v-for="rating in [
                        { key: 'overall_rating', label: 'Satisfaction globale *' },
                        { key: 'content_rating', label: 'Qualité du contenu scientifique' },
                        { key: 'venue_rating', label: 'Lieu / installations' },
                        { key: 'organization_rating', label: 'Organisation' },
                        { key: 'networking_rating', label: 'Opportunités networking' },
                    ]" :key="rating.key">
                        <div class="flex items-center justify-between">
                            <span class="text-sm">{{ rating.label }}</span>
                            <div class="flex gap-1">
                                <button v-for="n in 5" :key="n" type="button" @click="(form as any)[rating.key] = n" class="text-amber-400">
                                    <Star :class="['h-5 w-5', n <= (form as any)[rating.key] ? 'fill-amber-400' : '']" />
                                </button>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <!-- Topics next edition -->
                <fieldset class="rounded-xl border bg-card p-5">
                    <legend class="px-2 text-sm font-semibold">Thématiques souhaitées pour la prochaine édition</legend>
                    <div class="mt-3 flex flex-wrap gap-2">
                        <label v-for="t in topics" :key="t" class="cursor-pointer">
                            <input type="checkbox" :checked="form.topics_of_interest_next_edition.includes(t)" @change="toggleTopic(t)" class="hidden" />
                            <span :class="['rounded-full border px-3 py-1 text-xs transition', form.topics_of_interest_next_edition.includes(t) ? 'border-primary bg-primary text-primary-foreground' : 'hover:bg-accent']">{{ t }}</span>
                        </label>
                    </div>
                </fieldset>

                <!-- Textes -->
                <fieldset class="space-y-3 rounded-xl border bg-card p-5">
                    <legend class="px-2 text-sm font-semibold">Vos commentaires</legend>
                    <div>
                        <label class="text-xs font-medium">Ce que vous avez aimé</label>
                        <textarea v-model="form.positive_feedback" rows="3" class="w-full rounded-md border bg-background px-3 py-2 text-sm"></textarea>
                    </div>
                    <div>
                        <label class="text-xs font-medium">Ce qui pourrait être amélioré</label>
                        <textarea v-model="form.improvement_feedback" rows="3" class="w-full rounded-md border bg-background px-3 py-2 text-sm"></textarea>
                    </div>
                    <div>
                        <label class="text-xs font-medium">Autres remarques (anonymes)</label>
                        <textarea v-model="form.comments" rows="2" class="w-full rounded-md border bg-background px-3 py-2 text-sm"></textarea>
                    </div>
                </fieldset>

                <fieldset class="space-y-2 rounded-xl border bg-card p-5">
                    <label class="flex items-center gap-2 text-sm cursor-pointer"><input type="checkbox" v-model="form.would_recommend" class="accent-primary" />Je recommanderai ce congrès à mes confrères</label>
                    <label class="flex items-center gap-2 text-sm cursor-pointer"><input type="checkbox" v-model="form.would_return" class="accent-primary" />Je reviendrai pour la prochaine édition</label>
                </fieldset>

                <button type="submit" :disabled="form.processing" class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-primary px-6 py-3 text-sm font-semibold text-primary-foreground hover:bg-primary/90 disabled:opacity-50">
                    <Loader2 v-if="form.processing" class="h-4 w-4 animate-spin" />
                    Envoyer mon avis
                </button>
            </form>
        </section>
    </PublicLayout>
</template>

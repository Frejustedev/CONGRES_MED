<script setup lang="ts">
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { Award, Loader2, CheckCircle2, AlertTriangle } from 'lucide-vue-next';
import PublicLayout from '@/layouts/PublicLayout.vue';

defineOptions({ layout: null });

const props = defineProps<{
    session: { id: number; title: string; cme_credits: number; pass_threshold: number; questions: Array<{ index: number; question: string; options: string[] }> };
    registration_reference: string;
    registration_email: string;
}>();

const page = usePage();
const flash = computed<any>(() => (page.props as any).flash ?? {});

const form = useForm({
    reference: props.registration_reference,
    email: props.registration_email,
    answers: {} as Record<number, number>,
});

function submit() {
    form.post(`/cme/quiz/${props.session.id}`);
}

const allAnswered = computed(() => Object.keys(form.answers).length === props.session.questions.length);
</script>

<template>
    <Head :title="`Quiz CME — ${session.title}`" />
    <PublicLayout>
        <section class="container mx-auto max-w-2xl px-4 py-10 lg:px-6">
            <div class="inline-flex items-center gap-2 rounded-full bg-emerald-500/10 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-emerald-700 dark:text-emerald-400">
                <Award class="h-3 w-3" />{{ session.cme_credits }} crédit{{ session.cme_credits > 1 ? 's' : '' }} CME
            </div>
            <h1 class="mt-3 text-3xl font-bold">{{ session.title }}</h1>
            <p class="mt-2 text-sm text-muted-foreground">Quiz de validation des crédits CME. Seuil de réussite : <strong>{{ session.pass_threshold }} %</strong>.</p>

            <div v-if="flash.success" class="mt-6 flex items-start gap-2 rounded-lg border-2 border-emerald-500/30 bg-emerald-500/10 p-4 text-sm text-emerald-700 dark:text-emerald-400"><CheckCircle2 class="mt-0.5 h-5 w-5" />{{ flash.success }}</div>
            <div v-else-if="flash.warning" class="mt-6 flex items-start gap-2 rounded-lg border-2 border-amber-500/30 bg-amber-500/10 p-4 text-sm text-amber-700 dark:text-amber-400"><AlertTriangle class="mt-0.5 h-5 w-5" />{{ flash.warning }}</div>

            <form @submit.prevent="submit" class="mt-8 space-y-6">
                <fieldset v-for="(q, i) in session.questions" :key="q.index" class="rounded-xl border bg-card p-5">
                    <legend class="px-2 text-xs font-bold uppercase text-primary">Question {{ i + 1 }} / {{ session.questions.length }}</legend>
                    <p class="mt-2 text-base font-semibold">{{ q.question }}</p>
                    <div class="mt-3 space-y-2">
                        <label v-for="(opt, j) in q.options" :key="j" :class="['flex cursor-pointer items-start gap-3 rounded-lg border-2 p-3 transition', form.answers[q.index] === j ? 'border-primary bg-primary/5' : 'hover:bg-accent']">
                            <input type="radio" :value="j" v-model="form.answers[q.index]" class="mt-0.5 accent-primary" />
                            <span class="text-sm">{{ opt }}</span>
                        </label>
                    </div>
                </fieldset>

                <button type="submit" :disabled="!allAnswered || form.processing" class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-primary px-6 py-3 text-sm font-semibold text-primary-foreground hover:bg-primary/90 disabled:opacity-50">
                    <Loader2 v-if="form.processing" class="h-4 w-4 animate-spin" />
                    {{ allAnswered ? 'Valider mes réponses' : `Encore ${session.questions.length - Object.keys(form.answers).length} question(s)` }}
                </button>
            </form>
        </section>
    </PublicLayout>
</template>

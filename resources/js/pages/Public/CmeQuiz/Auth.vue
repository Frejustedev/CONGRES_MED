<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import { Award, Loader2 } from 'lucide-vue-next';
import PublicLayout from '@/layouts/PublicLayout.vue';

defineOptions({ layout: null });

const props = defineProps<{ session: { id: number; title: string } }>();

const form = useForm({ reference: '', email: '' });

function submit() {
    form.get(`/cme/quiz/${props.session.id}`, { preserveScroll: true });
}
</script>

<template>
    <Head title="Authentification quiz CME" />
    <PublicLayout>
        <section class="container mx-auto max-w-md px-4 py-16">
            <Award class="mx-auto h-12 w-12 text-emerald-500" />
            <h1 class="mt-4 text-center text-2xl font-bold">Quiz CME — {{ session.title }}</h1>
            <p class="mt-2 text-center text-sm text-muted-foreground">Identifiez-vous pour valider vos crédits.</p>
            <form @submit.prevent="submit" class="mt-6 space-y-3 rounded-xl border bg-card p-5">
                <input v-model="form.reference" type="text" placeholder="Référence inscription" required class="w-full rounded-md border bg-background px-3 py-2 text-sm font-mono uppercase" />
                <input v-model="form.email" type="email" placeholder="E-mail" required class="w-full rounded-md border bg-background px-3 py-2 text-sm" />
                <button type="submit" :disabled="form.processing" class="inline-flex w-full items-center justify-center gap-2 rounded-md bg-primary px-4 py-2.5 text-sm font-semibold text-primary-foreground disabled:opacity-50">
                    <Loader2 v-if="form.processing" class="h-4 w-4 animate-spin" />
                    Continuer
                </button>
            </form>
        </section>
    </PublicLayout>
</template>

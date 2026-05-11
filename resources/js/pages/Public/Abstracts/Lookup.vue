<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import { Search, Loader2 } from 'lucide-vue-next';
import PublicLayout from '@/layouts/PublicLayout.vue';

defineOptions({ layout: null });

const form = useForm({ email: '', reference: '' });

function submit() {
    form.post('/abstracts/lookup', { preserveScroll: true });
}
</script>

<template>
    <Head title="Consulter mon résumé" />
    <PublicLayout>
        <section class="container mx-auto max-w-md px-4 py-12 lg:px-6">
            <div class="text-center">
                <Search class="mx-auto h-10 w-10 text-primary" />
                <h1 class="mt-4 text-2xl font-bold">Consulter mon résumé</h1>
                <p class="mt-2 text-sm text-muted-foreground">Renseignez la référence reçue par e-mail et votre adresse e-mail.</p>
            </div>

            <form @submit.prevent="submit" class="mt-8 space-y-4 rounded-xl border bg-card p-6">
                <div>
                    <label class="mb-1.5 block text-xs font-medium">Référence</label>
                    <input v-model="form.reference" type="text" required placeholder="ABS-2026-00001" class="w-full rounded-md border bg-background px-3 py-2 text-sm font-mono uppercase" />
                </div>
                <div>
                    <label class="mb-1.5 block text-xs font-medium">E-mail</label>
                    <input v-model="form.email" type="email" required class="w-full rounded-md border bg-background px-3 py-2 text-sm" />
                    <p v-if="form.errors.reference" class="mt-1 text-xs text-red-500">{{ form.errors.reference }}</p>
                </div>
                <button type="submit" :disabled="form.processing" class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-primary px-5 py-2.5 text-sm font-semibold text-primary-foreground hover:bg-primary/90 disabled:opacity-50">
                    <Loader2 v-if="form.processing" class="h-4 w-4 animate-spin" />
                    Consulter
                </button>
            </form>
        </section>
    </PublicLayout>
</template>

<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';

defineOptions({ layout: AppLayout as any });

const props = defineProps<{ settings: Record<string, boolean> }>();

const form = useForm({ ...props.settings });

const labels: Record<string, string> = {
    public_portal_enabled: 'Portail public',
    registrations_enabled: 'Inscriptions',
    payments_enabled: 'Paiements en ligne',
    abstracts_enabled: 'Soumission de résumés',
    peer_review_enabled: 'Peer review double-blind',
    sessions_enabled: 'Programme scientifique',
    speakers_enabled: 'Intervenants',
    sponsors_enabled: 'Sponsors',
    exhibitors_enabled: 'Exposants',
    symposiums_enabled: 'Symposiums satellites',
    streaming_enabled: 'Streaming live (YouTube embed)',
    cme_enabled: 'Crédits CME / DPC',
    networking_enabled: 'Networking (annuaire, messagerie)',
    eposters_enabled: 'E-posters galerie',
    live_qa_enabled: 'Q&A live + sondages',
    visa_letters_enabled: 'Lettres d\'invitation visa',
    group_registration_enabled: 'Inscriptions groupées',
    multi_language_enabled: 'Multilingue (FR/EN)',
    blog_enabled: 'Blog / actualités',
    faq_enabled: 'FAQ publique',
};

function submit() {
    form.put('/admin/settings/modules', { preserveScroll: true });
}
</script>

<template>
    <Head title="Modules" />
    <div class="container mx-auto max-w-3xl px-4 py-6 lg:px-6">
        <h1 class="text-2xl font-bold">Modules activables</h1>
        <p class="text-sm text-muted-foreground">Activez ou désactivez chaque fonctionnalité selon les besoins de votre congrès.</p>

        <form @submit.prevent="submit" class="mt-6 space-y-2">
            <label v-for="(label, key) in labels" :key="key" class="flex items-center justify-between rounded-lg border bg-card p-4 cursor-pointer hover:bg-accent">
                <span class="text-sm font-medium">{{ label }}</span>
                <input type="checkbox" v-model="(form as any)[key]" class="h-5 w-5 accent-primary" />
            </label>

            <button type="submit" :disabled="form.processing" class="mt-6 inline-flex rounded-md bg-primary px-6 py-2.5 text-sm font-semibold text-primary-foreground hover:bg-primary/90 disabled:opacity-50">
                {{ form.processing ? 'Enregistrement…' : 'Enregistrer' }}
            </button>
        </form>
    </div>
</template>

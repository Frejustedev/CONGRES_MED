<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Mail, Plus } from 'lucide-vue-next';
import AppLayout from '@/layouts/AppLayout.vue';

defineOptions({ layout: AppLayout as any });

const props = defineProps<{ templates: Array<any>; availableKeys: Record<string, string> }>();

const showCreate = ref(false);
const form = useForm({ key: '', name: '', subject: '', body_html: '', locale: 'fr', is_active: true });

function save() {
    form.post('/admin/email-templates', { preserveScroll: true, onSuccess: () => { showCreate.value = false; form.reset(); } });
}
</script>

<template>
    <Head title="Templates emails" />
    <div class="container mx-auto max-w-4xl px-4 py-6 lg:px-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold">Templates d'emails</h1>
            <button @click="showCreate = true" class="inline-flex items-center gap-1 rounded-md bg-primary px-4 py-2 text-sm font-semibold text-primary-foreground hover:bg-primary/90"><Plus class="h-4 w-4" />Nouveau</button>
        </div>

        <div class="mt-4 space-y-2">
            <Link v-for="t in templates" :key="t.id" :href="`/admin/email-templates/${t.id}/edit`" class="flex items-center justify-between rounded-xl border bg-card p-4 hover:shadow-md">
                <div class="flex items-start gap-3">
                    <Mail class="h-5 w-5 mt-1 text-primary" />
                    <div>
                        <p class="font-semibold">{{ t.name }}</p>
                        <p class="text-xs font-mono text-muted-foreground">{{ t.key }}</p>
                        <p class="mt-1 text-sm">{{ t.subject }}</p>
                    </div>
                </div>
                <span :class="['rounded-full px-2 py-0.5 text-[10px] font-semibold', t.is_active ? 'bg-emerald-500/10 text-emerald-700 dark:text-emerald-400' : 'bg-muted text-muted-foreground']">{{ t.is_active ? 'Actif' : 'Inactif' }}</span>
            </Link>
            <div v-if="!templates.length" class="rounded-xl border border-dashed p-12 text-center text-sm text-muted-foreground">Aucun template. Lance le seeder DefaultEmailTemplatesSeeder.</div>
        </div>

        <div v-if="showCreate" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
            <div class="w-full max-w-lg rounded-xl bg-card p-6">
                <h2 class="text-lg font-bold">Nouveau template</h2>
                <form @submit.prevent="save" class="mt-4 space-y-3">
                    <select v-model="form.key" required class="w-full rounded-md border bg-background px-3 py-2 text-sm">
                        <option value="">— Clé technique —</option>
                        <option v-for="(label, key) in availableKeys" :key="key" :value="key">{{ key }} — {{ label }}</option>
                    </select>
                    <input v-model="form.name" type="text" placeholder="Nom interne" required class="w-full rounded-md border bg-background px-3 py-2 text-sm" />
                    <input v-model="form.subject" type="text" placeholder="Sujet email" required class="w-full rounded-md border bg-background px-3 py-2 text-sm" />
                    <textarea v-model="form.body_html" rows="6" placeholder="Corps HTML" required class="w-full rounded-md border bg-background px-3 py-2 text-sm font-mono"></textarea>
                    <div class="flex gap-2">
                        <button type="button" @click="showCreate = false" class="flex-1 rounded-md border px-4 py-2 text-sm">Annuler</button>
                        <button type="submit" :disabled="form.processing" class="flex-1 rounded-md bg-primary px-4 py-2 text-sm font-semibold text-primary-foreground">Créer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

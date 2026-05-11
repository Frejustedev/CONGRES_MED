<script setup lang="ts">
import { Head, useForm, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Plus, Building2, Trash2 } from 'lucide-vue-next';
import AppLayout from '@/layouts/AppLayout.vue';

defineOptions({ layout: AppLayout as any });

defineProps<{
    groups: { data: Array<any>; links: Array<any> };
    categories: Array<{ id: number; name: string }>;
}>();

const showModal = ref(false);
const form = useForm({
    organization_name: '',
    contact_name: '',
    contact_email: '',
    contact_phone: '',
    vat_number: '',
    category_id: null as number | null,
    participants: [{ first_name: '', last_name: '', email: '', phone: '' }] as Array<any>,
});

function addParticipant() {
    form.participants.push({ first_name: '', last_name: '', email: '', phone: '' });
}
function removeParticipant(i: number) {
    form.participants.splice(i, 1);
}
function submit() {
    form.post('/admin/groups', {
        preserveScroll: true,
        onSuccess: () => { showModal.value = false; form.reset(); form.participants = [{ first_name: '', last_name: '', email: '', phone: '' }]; },
    });
}
</script>

<template>
    <Head title="Inscriptions groupées" />
    <div class="container mx-auto px-4 py-6 lg:px-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold">Inscriptions groupées</h1>
            <button @click="showModal = true" class="inline-flex items-center gap-1 rounded-md bg-primary px-4 py-2 text-sm font-semibold text-primary-foreground hover:bg-primary/90">
                <Plus class="h-4 w-4" /> Nouveau groupe
            </button>
        </div>

        <div class="mt-4 overflow-x-auto rounded-xl border bg-card">
            <table class="w-full text-sm">
                <thead class="text-left text-xs uppercase text-muted-foreground">
                    <tr class="border-b">
                        <th class="px-4 py-2">Réf.</th><th>Organisation</th><th>Contact</th><th>Participants</th><th>Statut</th><th class="text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="g in groups.data" :key="g.id" class="border-t hover:bg-muted/30">
                        <td class="px-4 py-2 font-mono text-xs">{{ g.reference }}</td>
                        <td><Building2 class="inline h-3 w-3 mr-1" /> {{ g.organization_name }}</td>
                        <td>{{ g.contact_name }}<br><span class="text-xs text-muted-foreground">{{ g.contact_email }}</span></td>
                        <td class="text-center">{{ g.registrations_count }} / {{ g.expected_count }}</td>
                        <td><span class="rounded-full bg-amber-500/10 px-2 py-0.5 text-[10px] text-amber-700 dark:text-amber-400">{{ g.status }}</span></td>
                        <td class="text-right tabular-nums">{{ new Intl.NumberFormat('fr-FR').format(g.total_amount) }} {{ g.currency }}</td>
                    </tr>
                    <tr v-if="!groups.data.length"><td colspan="6" class="px-4 py-12 text-center text-sm text-muted-foreground">Aucun groupe.</td></tr>
                </tbody>
            </table>
        </div>

        <!-- Modal -->
        <div v-if="showModal" class="fixed inset-0 z-50 flex items-start justify-center bg-black/50 p-4 overflow-y-auto" @click.self="showModal = false">
            <div class="mt-12 w-full max-w-2xl rounded-xl bg-card p-6 shadow-xl">
                <h2 class="text-lg font-bold">Nouvelle inscription groupée</h2>
                <form @submit.prevent="submit" class="mt-4 space-y-4">
                    <div class="grid gap-3 sm:grid-cols-2">
                        <input v-model="form.organization_name" type="text" placeholder="Organisation *" required class="rounded-md border bg-background px-3 py-2 text-sm" />
                        <select v-model="form.category_id" required class="rounded-md border bg-background px-3 py-2 text-sm">
                            <option :value="null">— Catégorie tarifaire —</option>
                            <option v-for="c in categories" :key="c.id" :value="c.id">{{ c.name }}</option>
                        </select>
                        <input v-model="form.contact_name" type="text" placeholder="Nom contact *" required class="rounded-md border bg-background px-3 py-2 text-sm" />
                        <input v-model="form.contact_email" type="email" placeholder="Email contact *" required class="rounded-md border bg-background px-3 py-2 text-sm" />
                        <input v-model="form.contact_phone" type="tel" placeholder="Téléphone contact" class="rounded-md border bg-background px-3 py-2 text-sm" />
                        <input v-model="form.vat_number" type="text" placeholder="N° TVA (optionnel)" class="rounded-md border bg-background px-3 py-2 text-sm" />
                    </div>

                    <div>
                        <h3 class="mb-2 text-sm font-semibold">Participants ({{ form.participants.length }})</h3>
                        <div v-for="(p, i) in form.participants" :key="i" class="mb-2 grid gap-2 sm:grid-cols-[1fr_1fr_1fr_auto]">
                            <input v-model="p.first_name" type="text" placeholder="Prénom *" required class="rounded-md border bg-background px-3 py-2 text-sm" />
                            <input v-model="p.last_name" type="text" placeholder="Nom *" required class="rounded-md border bg-background px-3 py-2 text-sm" />
                            <input v-model="p.email" type="email" placeholder="Email *" required class="rounded-md border bg-background px-3 py-2 text-sm" />
                            <button v-if="form.participants.length > 1" type="button" @click="removeParticipant(i)" class="rounded p-2 text-red-500 hover:bg-red-500/10">
                                <Trash2 class="h-4 w-4" />
                            </button>
                        </div>
                        <button type="button" @click="addParticipant" class="text-sm text-primary hover:underline">+ Ajouter un participant</button>
                    </div>

                    <div class="flex gap-2">
                        <button type="button" @click="showModal = false" class="flex-1 rounded-md border px-4 py-2 text-sm">Annuler</button>
                        <button type="submit" :disabled="form.processing" class="flex-1 rounded-md bg-primary px-4 py-2 text-sm font-semibold text-primary-foreground hover:bg-primary/90 disabled:opacity-50">
                            Créer le groupe
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

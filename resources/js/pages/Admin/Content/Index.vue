<script setup lang="ts">
import { Head, useForm, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { Plus, Trash2, Pencil, X } from 'lucide-vue-next';
import AppLayout from '@/layouts/AppLayout.vue';

defineOptions({ layout: AppLayout as any });

const props = defineProps<{ type: string; items: Array<any> }>();

const editing = ref<any | null>(null);

const titleByType: Record<string, string> = {
    sponsors: 'Sponsors',
    exhibitors: 'Exposants',
    speakers: 'Intervenants',
    sessions: 'Sessions',
    symposiums: 'Symposiums',
    rooms: 'Salles',
};

function emptyForm() {
    return {
        sponsors: { name: '', tier: 'gold', website: '', description: '', is_published: true, display_order: 0 },
        exhibitors: { name: '', booth_number: '', website: '', description: '', is_published: true, display_order: 0 },
        speakers: { first_name: '', last_name: '', salutation: 'Dr', job_title: '', affiliation: '', country: '', biography: '', is_keynote: false, is_featured: false, is_published: true, name: '' },
        sessions: { title: '', type: 'plenary', starts_at: '', ends_at: '', room_id: null, language: 'fr', cme_credits: 0, is_published: false, is_featured: false },
        symposiums: { title: '', sponsor_id: null, room_id: null, starts_at: '', ends_at: '', price: 0, currency: 'XOF', capacity: null, is_published: false },
        rooms: { name: '', capacity: null, color: '#0ea5e9', is_active: true, display_order: 0 },
    }[props.type];
}

const form = useForm(emptyForm());

function startCreate() {
    editing.value = null;
    form.reset();
    Object.assign(form, emptyForm());
}

function startEdit(item: any) {
    editing.value = item;
    Object.keys(form.data()).forEach((k) => ((form as any)[k] = item[k] ?? (form as any)[k]));
}

function save() {
    if (editing.value) {
        form.put(`/admin/content/${props.type}/${editing.value.id}`, {
            preserveScroll: true,
            onSuccess: () => { editing.value = null; form.reset(); },
        });
    } else {
        form.post(`/admin/content/${props.type}`, {
            preserveScroll: true,
            onSuccess: () => form.reset(),
        });
    }
}

function remove(id: number) {
    if (!confirm('Supprimer définitivement ?')) return;
    router.delete(`/admin/content/${props.type}/${id}`, { preserveScroll: true });
}

const displayFields = computed(() => Object.keys(form.data()));
</script>

<template>
    <Head :title="titleByType[type]" />
    <div class="container mx-auto px-4 py-6 lg:px-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold">{{ titleByType[type] }}</h1>
            <button @click="startCreate" class="inline-flex items-center gap-1 rounded-md bg-primary px-4 py-2 text-sm font-semibold text-primary-foreground hover:bg-primary/90">
                <Plus class="h-4 w-4" /> Créer
            </button>
        </div>

        <!-- Liste -->
        <div class="mt-4 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
            <div v-for="item in items" :key="item.id" class="rounded-xl border bg-card p-4">
                <div class="flex items-start justify-between gap-2">
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold truncate">{{ item.name ?? item.title ?? item.first_name + ' ' + item.last_name }}</p>
                        <p v-if="item.tier" class="text-xs uppercase text-muted-foreground">{{ item.tier }}</p>
                        <p v-if="item.affiliation" class="text-xs text-muted-foreground truncate">{{ item.affiliation }}</p>
                        <p v-if="item.starts_at" class="text-xs text-muted-foreground">{{ new Date(item.starts_at).toLocaleString('fr-FR') }}</p>
                        <p v-if="item.booth_number" class="text-xs text-muted-foreground">Stand {{ item.booth_number }}</p>
                    </div>
                    <div class="flex gap-1 shrink-0">
                        <button @click="startEdit(item)" class="rounded p-1 hover:bg-muted"><Pencil class="h-3.5 w-3.5" /></button>
                        <button @click="remove(item.id)" class="rounded p-1 text-red-600 hover:bg-red-500/10"><Trash2 class="h-3.5 w-3.5" /></button>
                    </div>
                </div>
                <div class="mt-2 flex gap-1">
                    <span v-if="item.is_published === false" class="rounded-full bg-muted px-2 py-0.5 text-[10px]">Brouillon</span>
                    <span v-else-if="item.is_published" class="rounded-full bg-emerald-500/10 px-2 py-0.5 text-[10px] text-emerald-700 dark:text-emerald-400">Publié</span>
                </div>
            </div>
            <div v-if="!items.length" class="col-span-full rounded-xl border border-dashed p-12 text-center text-sm text-muted-foreground">Aucun élément.</div>
        </div>

        <!-- Modal create/edit -->
        <div v-if="editing !== null || form.isDirty" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" @click.self="editing = null; form.reset(); Object.assign(form, emptyForm())">
            <div class="max-h-[90vh] w-full max-w-lg overflow-y-auto rounded-xl bg-card p-6 shadow-xl">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-bold">{{ editing ? 'Modifier' : 'Créer' }}</h2>
                    <button @click="editing = null; form.reset(); Object.assign(form, emptyForm())" class="rounded p-1 hover:bg-muted"><X class="h-4 w-4" /></button>
                </div>
                <form @submit.prevent="save" class="mt-4 space-y-3">
                    <div v-for="field in displayFields" :key="field">
                        <label class="mb-1 block text-xs font-medium capitalize">{{ field.replace(/_/g, ' ') }}</label>
                        <textarea v-if="['description', 'biography'].includes(field)" v-model="(form as any)[field]" rows="3" class="w-full rounded-md border bg-background px-3 py-2 text-sm"></textarea>
                        <input v-else-if="['starts_at', 'ends_at'].includes(field)" v-model="(form as any)[field]" type="datetime-local" class="w-full rounded-md border bg-background px-3 py-2 text-sm" />
                        <input v-else-if="typeof (form as any)[field] === 'boolean' || ['is_published','is_featured','is_keynote','is_active'].includes(field)" type="checkbox" v-model="(form as any)[field]" class="h-4 w-4 accent-primary" />
                        <input v-else-if="typeof (form as any)[field] === 'number' || ['display_order','price','cme_credits','capacity'].includes(field)" v-model.number="(form as any)[field]" type="number" class="w-full rounded-md border bg-background px-3 py-2 text-sm" />
                        <input v-else v-model="(form as any)[field]" type="text" class="w-full rounded-md border bg-background px-3 py-2 text-sm" />
                        <p v-if="(form.errors as any)[field]" class="text-xs text-red-500">{{ (form.errors as any)[field] }}</p>
                    </div>
                    <button type="submit" :disabled="form.processing" class="inline-flex w-full items-center justify-center rounded-md bg-primary px-4 py-2 text-sm font-semibold text-primary-foreground hover:bg-primary/90 disabled:opacity-50">
                        {{ form.processing ? 'Enregistrement…' : 'Enregistrer' }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';
import { FileText, Plus, Trash2, Loader2, AlertCircle, Calendar } from 'lucide-vue-next';
import PublicLayout from '@/layouts/PublicLayout.vue';

defineOptions({ layout: null });

const props = defineProps<{
    thematicAreas: Array<{ id: number; slug: string; name: string; color: string }>;
    deadline: string | null;
    countries: Array<{ code: string; name: string }>;
}>();

const form = useForm({
    thematic_area_id: null as number | null,
    submission_type: 'oral' as 'oral' | 'poster' | 'eposter' | 'case_report',
    title: '',
    language: 'fr' as 'fr' | 'en',
    keywords: [] as string[],
    introduction: '',
    methods: '',
    results: '',
    discussion: '',
    conclusion: '',
    case_description: '',
    has_conflict_of_interest: false,
    conflict_disclosure: '',
    funding_disclosed: false,
    funding_sources: '',
    ethical_approval: false,
    ethical_approval_number: '',
    authors: [
        { salutation: 'Dr', first_name: '', last_name: '', email: '', affiliation: '', country: '', orcid: '', is_corresponding: true, is_presenter: true },
    ] as Array<any>,
    terms_accepted: false,
});

const keywordInput = ref('');
function addKeyword() {
    const kw = keywordInput.value.trim();
    if (kw && form.keywords.length < 6 && !form.keywords.includes(kw)) {
        form.keywords.push(kw);
        keywordInput.value = '';
    }
}
function removeKeyword(kw: string) {
    form.keywords = form.keywords.filter((k) => k !== kw);
}

function addAuthor() {
    form.authors.push({ salutation: '', first_name: '', last_name: '', email: '', affiliation: '', country: '', orcid: '', is_corresponding: false, is_presenter: false });
}
function removeAuthor(index: number) {
    if (form.authors.length > 1) form.authors.splice(index, 1);
}

const wordCount = computed(() => {
    const text = [form.title, form.introduction, form.methods, form.results, form.discussion, form.conclusion, form.case_description]
        .filter(Boolean)
        .join(' ');
    return text.trim() ? text.trim().split(/\s+/).length : 0;
});

const showImrad = computed(() => form.submission_type !== 'case_report');

function submit() {
    form.post('/abstracts/submit', { preserveScroll: true });
}

const typeLabels: Record<string, string> = {
    oral: 'Communication orale',
    poster: 'Poster classique',
    eposter: 'E-poster (numérique)',
    case_report: 'Cas clinique',
};
</script>

<template>
    <Head title="Soumettre un résumé" />
    <PublicLayout>
        <section class="border-b bg-gradient-to-br from-primary/5 to-background py-10">
            <div class="container mx-auto px-4 lg:px-6">
                <div class="inline-flex items-center gap-2 rounded-full border bg-muted px-3 py-1 text-xs font-medium text-muted-foreground">
                    <FileText class="h-3 w-3" />
                    Soumission scientifique
                </div>
                <h1 class="mt-4 text-3xl font-bold tracking-tight sm:text-4xl">Soumettre un résumé</h1>
                <p v-if="deadline" class="mt-2 flex items-center gap-2 text-sm text-muted-foreground">
                    <Calendar class="h-4 w-4" />
                    Date limite : {{ new Date(deadline).toLocaleDateString('fr-FR', { dateStyle: 'long' }) }}
                </p>
            </div>
        </section>

        <section class="container mx-auto max-w-4xl px-4 py-10 lg:px-6">
            <form @submit.prevent="submit" class="space-y-6">
                <!-- Thématique + Type -->
                <fieldset class="space-y-4 rounded-xl border bg-card p-6">
                    <legend class="px-2 text-sm font-semibold">Type & thématique</legend>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="mb-1.5 block text-xs font-medium">Type de soumission *</label>
                            <select v-model="form.submission_type" required class="w-full rounded-md border bg-background px-3 py-2 text-sm">
                                <option v-for="(label, val) in typeLabels" :key="val" :value="val">{{ label }}</option>
                            </select>
                        </div>
                        <div>
                            <label class="mb-1.5 block text-xs font-medium">Thématique *</label>
                            <select v-model="form.thematic_area_id" required class="w-full rounded-md border bg-background px-3 py-2 text-sm">
                                <option :value="null">—</option>
                                <option v-for="t in thematicAreas" :key="t.id" :value="t.id">{{ t.name }}</option>
                            </select>
                            <p v-if="form.errors.thematic_area_id" class="mt-1 text-xs text-red-500">{{ form.errors.thematic_area_id }}</p>
                        </div>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-xs font-medium">Titre *</label>
                        <input v-model="form.title" type="text" required maxlength="300" class="w-full rounded-md border bg-background px-3 py-2 text-sm" />
                        <p class="mt-1 text-xs text-muted-foreground">{{ form.title.length }}/300 caractères</p>
                        <p v-if="form.errors.title" class="mt-1 text-xs text-red-500">{{ form.errors.title }}</p>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-xs font-medium">Langue</label>
                        <div class="flex gap-3">
                            <label v-for="lang in [{ v: 'fr', l: 'Français' }, { v: 'en', l: 'English' }]" :key="lang.v" class="flex items-center gap-2 text-sm cursor-pointer">
                                <input type="radio" :value="lang.v" v-model="form.language" class="accent-primary" />
                                {{ lang.l }}
                            </label>
                        </div>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-xs font-medium">Mots-clés * (3 à 6)</label>
                        <div class="flex gap-2">
                            <input v-model="keywordInput" type="text" placeholder="Tapez un mot-clé puis Entrée"
                                @keydown.enter.prevent="addKeyword"
                                class="flex-1 rounded-md border bg-background px-3 py-2 text-sm" />
                            <button type="button" @click="addKeyword" class="rounded-md border px-4 text-sm">Ajouter</button>
                        </div>
                        <div class="mt-2 flex flex-wrap gap-2">
                            <span v-for="kw in form.keywords" :key="kw" class="inline-flex items-center gap-1 rounded-full bg-primary/10 px-3 py-1 text-xs font-medium text-primary">
                                {{ kw }}
                                <button type="button" @click="removeKeyword(kw)" class="hover:text-red-500">×</button>
                            </span>
                        </div>
                        <p v-if="form.errors.keywords" class="mt-1 text-xs text-red-500">{{ form.errors.keywords }}</p>
                    </div>
                </fieldset>

                <!-- Contenu IMRAD ou cas clinique -->
                <fieldset v-if="showImrad" class="space-y-4 rounded-xl border bg-card p-6">
                    <legend class="px-2 text-sm font-semibold">Contenu (structure IMRAD)</legend>
                    <div v-for="section in [
                        { key: 'introduction', label: 'Introduction', max: 5000 },
                        { key: 'methods', label: 'Méthodes', max: 5000 },
                        { key: 'results', label: 'Résultats', max: 5000 },
                        { key: 'discussion', label: 'Discussion', max: 5000 },
                        { key: 'conclusion', label: 'Conclusion', max: 5000 },
                    ]" :key="section.key">
                        <label class="mb-1.5 block text-xs font-medium">{{ section.label }}</label>
                        <textarea :value="(form as any)[section.key]" @input="(form as any)[section.key] = ($event.target as HTMLTextAreaElement).value" rows="3" :maxlength="section.max" class="w-full resize-y rounded-md border bg-background px-3 py-2 text-sm"></textarea>
                    </div>
                </fieldset>
                <fieldset v-else class="space-y-4 rounded-xl border bg-card p-6">
                    <legend class="px-2 text-sm font-semibold">Description du cas clinique</legend>
                    <textarea v-model="form.case_description" rows="10" maxlength="6000" placeholder="Anamnèse, examen clinique, examens complémentaires, prise en charge, évolution, discussion..." class="w-full resize-y rounded-md border bg-background px-3 py-2 text-sm"></textarea>
                </fieldset>

                <div class="rounded-lg bg-muted/30 p-3 text-xs">
                    <strong>{{ wordCount }}</strong> mots au total
                    <span v-if="wordCount > 350" class="ml-2 text-amber-600">— recommandé < 350 mots</span>
                </div>

                <!-- Auteurs -->
                <fieldset class="space-y-4 rounded-xl border bg-card p-6">
                    <legend class="px-2 text-sm font-semibold">Auteurs ({{ form.authors.length }}/15)</legend>
                    <div v-for="(author, i) in form.authors" :key="i" class="rounded-lg border p-4">
                        <div class="mb-3 flex items-center justify-between">
                            <p class="text-sm font-semibold">Auteur {{ i + 1 }}{{ author.is_corresponding ? ' · Correspondant' : '' }}{{ author.is_presenter ? ' · Présentateur' : '' }}</p>
                            <button v-if="form.authors.length > 1" type="button" @click="removeAuthor(i)" class="text-red-500 hover:text-red-700">
                                <Trash2 class="h-4 w-4" />
                            </button>
                        </div>
                        <div class="grid gap-3 sm:grid-cols-[80px_1fr_1fr]">
                            <select v-model="author.salutation" class="rounded-md border bg-background px-2 py-2 text-sm">
                                <option value="">—</option>
                                <option>Dr</option><option>Pr</option><option>M.</option><option>Mme</option>
                            </select>
                            <input v-model="author.first_name" type="text" placeholder="Prénom *" required class="rounded-md border bg-background px-3 py-2 text-sm" />
                            <input v-model="author.last_name" type="text" placeholder="Nom *" required class="rounded-md border bg-background px-3 py-2 text-sm" />
                        </div>
                        <div class="mt-3 grid gap-3 sm:grid-cols-2">
                            <input v-model="author.email" type="email" placeholder="E-mail *" required class="rounded-md border bg-background px-3 py-2 text-sm" />
                            <select v-model="author.country" class="rounded-md border bg-background px-3 py-2 text-sm">
                                <option value="">Pays</option>
                                <option v-for="c in countries" :key="c.code" :value="c.code">{{ c.name }}</option>
                            </select>
                        </div>
                        <input v-model="author.affiliation" type="text" placeholder="Affiliation (institution) *" required class="mt-3 w-full rounded-md border bg-background px-3 py-2 text-sm" />
                        <div class="mt-3 flex gap-4 text-sm">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" v-model="author.is_corresponding" class="accent-primary" /> Auteur correspondant
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" v-model="author.is_presenter" class="accent-primary" /> Présentateur
                            </label>
                        </div>
                    </div>
                    <button v-if="form.authors.length < 15" type="button" @click="addAuthor" class="inline-flex items-center gap-1 rounded-md border px-4 py-2 text-sm hover:bg-accent">
                        <Plus class="h-4 w-4" />
                        Ajouter un co-auteur
                    </button>
                </fieldset>

                <!-- Déclarations -->
                <fieldset class="space-y-4 rounded-xl border bg-card p-6">
                    <legend class="px-2 text-sm font-semibold">Déclarations</legend>
                    <label class="flex items-start gap-3 text-sm cursor-pointer">
                        <input type="checkbox" v-model="form.has_conflict_of_interest" class="mt-1 accent-primary" />
                        <span>Je déclare un <strong>conflit d'intérêts</strong> (sponsor, lien financier, lien personnel avec l'industrie...)</span>
                    </label>
                    <textarea v-if="form.has_conflict_of_interest" v-model="form.conflict_disclosure" rows="2" placeholder="Précisez le conflit déclaré" class="w-full rounded-md border bg-background px-3 py-2 text-sm"></textarea>

                    <label class="flex items-start gap-3 text-sm cursor-pointer">
                        <input type="checkbox" v-model="form.funding_disclosed" class="mt-1 accent-primary" />
                        <span>Cette recherche a bénéficié d'un <strong>financement</strong> (institutionnel, industriel, association)</span>
                    </label>
                    <input v-if="form.funding_disclosed" v-model="form.funding_sources" type="text" placeholder="Sources de financement" class="w-full rounded-md border bg-background px-3 py-2 text-sm" />

                    <label class="flex items-start gap-3 text-sm cursor-pointer">
                        <input type="checkbox" v-model="form.ethical_approval" class="mt-1 accent-primary" />
                        <span>Cette recherche a été approuvée par un <strong>comité d'éthique</strong></span>
                    </label>
                    <input v-if="form.ethical_approval" v-model="form.ethical_approval_number" type="text" placeholder="Numéro d'approbation" class="w-full rounded-md border bg-background px-3 py-2 text-sm" />
                </fieldset>

                <!-- Consentement -->
                <fieldset class="rounded-xl border bg-card p-6">
                    <label class="flex items-start gap-3 text-sm cursor-pointer">
                        <input type="checkbox" v-model="form.terms_accepted" required class="mt-1 accent-primary" />
                        <span>
                            Je certifie que ce travail est <strong>original</strong>, n'a pas été soumis ailleurs, et que tous les co-auteurs ont donné leur accord pour cette soumission. *
                        </span>
                    </label>
                    <p v-if="form.errors.terms_accepted" class="mt-1 text-xs text-red-500">{{ form.errors.terms_accepted }}</p>
                </fieldset>

                <button
                    type="submit"
                    :disabled="!form.terms_accepted || form.processing"
                    class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-primary px-6 py-3 text-base font-semibold text-primary-foreground hover:bg-primary/90 disabled:opacity-50"
                >
                    <Loader2 v-if="form.processing" class="h-4 w-4 animate-spin" />
                    {{ form.processing ? 'Envoi…' : 'Soumettre mon résumé' }}
                </button>
            </form>
        </section>
    </PublicLayout>
</template>

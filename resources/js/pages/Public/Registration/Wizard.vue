<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';
import {
    Check,
    ChevronLeft,
    ChevronRight,
    UserCircle,
    Receipt,
    Tag,
    AlertCircle,
    Loader2,
} from 'lucide-vue-next';
import PublicLayout from '@/layouts/PublicLayout.vue';

defineOptions({ layout: null });

const props = defineProps<{
    event: { name: string; starts_at: string | null; ends_at: string | null; venue_city: string | null };
    categories: Array<{
        id: number;
        slug: string;
        name: string;
        description: string | null;
        current_price: number;
        current_tier: string;
        currency: string;
        requires_proof: boolean;
    }>;
    countries: Array<{ code: string; name: string }>;
}>();

// Form Inertia
const form = useForm({
    category_id: null as number | null,
    salutation: '',
    first_name: '',
    last_name: '',
    email: '',
    phone: '',
    whatsapp: '',
    profession: '',
    organization: '',
    job_title: '',
    specialty: '',
    city: '',
    country: '',
    country_of_origin: '',
    promo_code: '',
    visa_letter_requested: false,
    accompanying_persons: 0,
    dietary_restrictions: [] as string[],
    newsletter_optin: false,
    directory_optin: false,
    terms_accepted: false,
});

const currentStep = ref(1);
const steps = [
    { id: 1, title: 'Catégorie', icon: Tag },
    { id: 2, title: 'Vos informations', icon: UserCircle },
    { id: 3, title: 'Récapitulatif', icon: Receipt },
];

// Pricing dynamique
const pricing = ref<{
    base: number;
    discount: number;
    discount_label: string | null;
    total: number;
    currency: string;
    promo_valid: boolean;
    promo_error: string | null;
} | null>(null);

const pricingLoading = ref(false);

const selectedCategory = computed(() => props.categories.find((c) => c.id === form.category_id) ?? null);

const formatPrice = (value: number, currency: string) =>
    new Intl.NumberFormat('fr-FR', { style: 'currency', currency, maximumFractionDigits: 0 }).format(value);

const tierLabel = (tier: string) =>
    ({ early_bird: 'Early Bird', standard: 'Standard', late: 'Late' }[tier] ?? tier);

async function refreshPricing() {
    if (!form.category_id) {
        pricing.value = null;
        return;
    }
    pricingLoading.value = true;
    try {
        const res = await fetch('/inscription/promo-check', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector<HTMLMetaElement>('meta[name="csrf-token"]')?.content ?? '',
                Accept: 'application/json',
            },
            body: JSON.stringify({
                category_id: form.category_id,
                code: form.promo_code || null,
            }),
            credentials: 'same-origin',
        });
        if (res.ok) {
            pricing.value = await res.json();
        }
    } finally {
        pricingLoading.value = false;
    }
}

watch(() => form.category_id, refreshPricing);

let promoTimer: ReturnType<typeof setTimeout> | null = null;
watch(() => form.promo_code, () => {
    if (promoTimer) clearTimeout(promoTimer);
    promoTimer = setTimeout(refreshPricing, 400);
});

// Navigation
function canGoNext(): boolean {
    if (currentStep.value === 1) return form.category_id !== null;
    if (currentStep.value === 2) {
        return Boolean(form.first_name && form.last_name && form.email);
    }
    return true;
}

function next() {
    if (canGoNext() && currentStep.value < 3) {
        currentStep.value++;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
}

function back() {
    if (currentStep.value > 1) {
        currentStep.value--;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
}

function submit() {
    form.post('/inscription', {
        preserveScroll: true,
    });
}

const dietaryOptions = [
    { value: 'halal', label: 'Halal' },
    { value: 'vegetarian', label: 'Végétarien' },
    { value: 'vegan', label: 'Végétalien' },
    { value: 'gluten_free', label: 'Sans gluten' },
    { value: 'lactose_free', label: 'Sans lactose' },
    { value: 'kosher', label: 'Casher' },
];
</script>

<template>
    <Head title="Inscription" />
    <PublicLayout>
        <section class="border-b bg-gradient-to-br from-primary/5 to-background py-10">
            <div class="container mx-auto px-4 lg:px-6">
                <h1 class="text-3xl font-bold tracking-tight sm:text-4xl">Inscription au congrès</h1>
                <p class="mt-2 text-muted-foreground">{{ event.name }}</p>
            </div>
        </section>

        <section class="container mx-auto px-4 py-10 lg:px-6">
            <!-- Stepper -->
            <ol class="mb-10 flex items-center justify-center gap-4 sm:gap-8">
                <li v-for="step in steps" :key="step.id" class="flex items-center gap-2">
                    <div
                        :class="[
                            'flex h-9 w-9 items-center justify-center rounded-full border-2 transition',
                            currentStep > step.id ? 'border-primary bg-primary text-primary-foreground' : '',
                            currentStep === step.id ? 'border-primary text-primary' : '',
                            currentStep < step.id ? 'border-muted text-muted-foreground' : '',
                        ]"
                    >
                        <Check v-if="currentStep > step.id" class="h-4 w-4" />
                        <component v-else :is="step.icon" class="h-4 w-4" />
                    </div>
                    <span
                        :class="[
                            'hidden text-sm font-medium sm:block',
                            currentStep === step.id ? 'text-foreground' : 'text-muted-foreground',
                        ]"
                    >
                        {{ step.title }}
                    </span>
                    <div v-if="step.id < steps.length" class="hidden h-px w-12 bg-border sm:block"></div>
                </li>
            </ol>

            <div class="mx-auto max-w-3xl">
                <!-- ============ ETAPE 1 : CATEGORIE ============ -->
                <div v-if="currentStep === 1" class="space-y-4">
                    <h2 class="text-2xl font-bold">Choisissez votre catégorie tarifaire</h2>
                    <p class="text-muted-foreground">Les tarifs Early Bird sont automatiquement appliqués pendant la période promotionnelle.</p>

                    <div class="grid gap-3">
                        <label
                            v-for="cat in categories"
                            :key="cat.id"
                            :class="[
                                'flex cursor-pointer items-start gap-4 rounded-xl border-2 p-5 transition hover:shadow-sm',
                                form.category_id === cat.id ? 'border-primary bg-primary/5' : 'border-border',
                            ]"
                        >
                            <input
                                type="radio"
                                :value="cat.id"
                                v-model="form.category_id"
                                class="mt-1 h-5 w-5 accent-primary"
                            />
                            <div class="flex-1 min-w-0">
                                <div class="flex items-baseline justify-between gap-2">
                                    <h3 class="text-base font-semibold">{{ cat.name }}</h3>
                                    <span class="text-lg font-bold whitespace-nowrap">{{ formatPrice(cat.current_price, cat.currency) }}</span>
                                </div>
                                <p v-if="cat.description" class="mt-1 text-sm text-muted-foreground">{{ cat.description }}</p>
                                <div class="mt-2 flex items-center gap-3 text-xs">
                                    <span class="rounded-full bg-primary/10 px-2 py-0.5 font-semibold text-primary">
                                        Tarif {{ tierLabel(cat.current_tier) }}
                                    </span>
                                    <span v-if="cat.requires_proof" class="flex items-center gap-1 text-amber-600 dark:text-amber-400">
                                        <AlertCircle class="h-3 w-3" />
                                        Justificatif requis
                                    </span>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- ============ ETAPE 2 : INFOS ============ -->
                <div v-if="currentStep === 2" class="space-y-6">
                    <h2 class="text-2xl font-bold">Vos informations</h2>
                    <p class="text-muted-foreground">Ces informations apparaîtront sur votre badge et votre attestation.</p>

                    <!-- Identité -->
                    <fieldset class="space-y-4 rounded-xl border bg-card p-5">
                        <legend class="px-2 text-sm font-semibold">Identité</legend>
                        <div class="grid gap-4 sm:grid-cols-[120px_1fr_1fr]">
                            <div>
                                <label class="mb-1.5 block text-xs font-medium">Civilité</label>
                                <select v-model="form.salutation" class="w-full rounded-md border bg-background px-3 py-2 text-sm">
                                    <option value="">—</option>
                                    <option value="Dr">Dr</option>
                                    <option value="Pr">Pr</option>
                                    <option value="M.">M.</option>
                                    <option value="Mme">Mme</option>
                                </select>
                            </div>
                            <div>
                                <label class="mb-1.5 block text-xs font-medium">Prénom *</label>
                                <input v-model="form.first_name" type="text" required class="w-full rounded-md border bg-background px-3 py-2 text-sm" />
                                <p v-if="form.errors.first_name" class="mt-1 text-xs text-red-500">{{ form.errors.first_name }}</p>
                            </div>
                            <div>
                                <label class="mb-1.5 block text-xs font-medium">Nom *</label>
                                <input v-model="form.last_name" type="text" required class="w-full rounded-md border bg-background px-3 py-2 text-sm" />
                                <p v-if="form.errors.last_name" class="mt-1 text-xs text-red-500">{{ form.errors.last_name }}</p>
                            </div>
                        </div>
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label class="mb-1.5 block text-xs font-medium">E-mail *</label>
                                <input v-model="form.email" type="email" required class="w-full rounded-md border bg-background px-3 py-2 text-sm" />
                                <p v-if="form.errors.email" class="mt-1 text-xs text-red-500">{{ form.errors.email }}</p>
                            </div>
                            <div>
                                <label class="mb-1.5 block text-xs font-medium">Téléphone</label>
                                <input v-model="form.phone" type="tel" class="w-full rounded-md border bg-background px-3 py-2 text-sm" placeholder="+229 ..." />
                            </div>
                        </div>
                    </fieldset>

                    <!-- Profil pro -->
                    <fieldset class="space-y-4 rounded-xl border bg-card p-5">
                        <legend class="px-2 text-sm font-semibold">Profil professionnel</legend>
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label class="mb-1.5 block text-xs font-medium">Profession</label>
                                <input v-model="form.profession" type="text" class="w-full rounded-md border bg-background px-3 py-2 text-sm" placeholder="Médecin, Pharmacien, Étudiant..." />
                            </div>
                            <div>
                                <label class="mb-1.5 block text-xs font-medium">Spécialité</label>
                                <input v-model="form.specialty" type="text" class="w-full rounded-md border bg-background px-3 py-2 text-sm" placeholder="Cardiologie, Oncologie..." />
                            </div>
                            <div>
                                <label class="mb-1.5 block text-xs font-medium">Organisation / Institution</label>
                                <input v-model="form.organization" type="text" class="w-full rounded-md border bg-background px-3 py-2 text-sm" />
                            </div>
                            <div>
                                <label class="mb-1.5 block text-xs font-medium">Fonction / Poste</label>
                                <input v-model="form.job_title" type="text" class="w-full rounded-md border bg-background px-3 py-2 text-sm" />
                            </div>
                        </div>
                    </fieldset>

                    <!-- Localisation -->
                    <fieldset class="space-y-4 rounded-xl border bg-card p-5">
                        <legend class="px-2 text-sm font-semibold">Localisation</legend>
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label class="mb-1.5 block text-xs font-medium">Ville</label>
                                <input v-model="form.city" type="text" class="w-full rounded-md border bg-background px-3 py-2 text-sm" />
                            </div>
                            <div>
                                <label class="mb-1.5 block text-xs font-medium">Pays</label>
                                <select v-model="form.country" class="w-full rounded-md border bg-background px-3 py-2 text-sm">
                                    <option value="">—</option>
                                    <option v-for="c in countries" :key="c.code" :value="c.code">{{ c.name }}</option>
                                </select>
                            </div>
                        </div>
                    </fieldset>

                    <!-- Options -->
                    <fieldset class="space-y-4 rounded-xl border bg-card p-5">
                        <legend class="px-2 text-sm font-semibold">Options</legend>
                        <div class="flex items-start gap-3">
                            <input id="visa" v-model="form.visa_letter_requested" type="checkbox" class="mt-1 h-4 w-4 accent-primary" />
                            <label for="visa" class="flex-1 text-sm">
                                Je souhaite recevoir une <strong>lettre d'invitation</strong> pour ma demande de visa.
                            </label>
                        </div>
                        <div>
                            <label class="mb-2 block text-xs font-medium">Restrictions alimentaires (gala, déjeuner)</label>
                            <div class="flex flex-wrap gap-2">
                                <label v-for="opt in dietaryOptions" :key="opt.value" class="cursor-pointer rounded-full border px-3 py-1 text-xs transition" :class="form.dietary_restrictions.includes(opt.value) ? 'border-primary bg-primary text-primary-foreground' : 'hover:bg-accent'">
                                    <input type="checkbox" :value="opt.value" v-model="form.dietary_restrictions" class="hidden" />
                                    {{ opt.label }}
                                </label>
                            </div>
                        </div>
                    </fieldset>
                </div>

                <!-- ============ ETAPE 3 : RECAP ============ -->
                <div v-if="currentStep === 3" class="space-y-6">
                    <h2 class="text-2xl font-bold">Récapitulatif & validation</h2>

                    <!-- Code promo -->
                    <div class="rounded-xl border bg-card p-5">
                        <label class="mb-2 block text-sm font-semibold">Code promo (optionnel)</label>
                        <div class="flex gap-2">
                            <input v-model="form.promo_code" type="text" class="flex-1 rounded-md border bg-background px-3 py-2 text-sm uppercase" placeholder="EARLY2026" />
                            <Loader2 v-if="pricingLoading" class="h-9 w-9 animate-spin text-primary" />
                        </div>
                        <p v-if="pricing?.promo_valid" class="mt-2 text-sm text-emerald-600">
                            ✓ Code valide : {{ pricing.discount_label }}
                        </p>
                        <p v-if="pricing?.promo_error" class="mt-2 text-sm text-red-500">
                            {{ pricing.promo_error }}
                        </p>
                    </div>

                    <!-- Récap commande -->
                    <div class="rounded-xl border bg-card p-5">
                        <h3 class="mb-4 text-sm font-semibold uppercase tracking-wider text-muted-foreground">Votre inscription</h3>
                        <dl class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <dt class="text-muted-foreground">Catégorie</dt>
                                <dd class="font-medium">{{ selectedCategory?.name }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-muted-foreground">Participant</dt>
                                <dd class="font-medium">{{ form.first_name }} {{ form.last_name }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-muted-foreground">E-mail</dt>
                                <dd class="font-medium">{{ form.email }}</dd>
                            </div>
                            <div v-if="form.organization" class="flex justify-between">
                                <dt class="text-muted-foreground">Organisation</dt>
                                <dd class="font-medium">{{ form.organization }}</dd>
                            </div>
                            <div v-if="form.visa_letter_requested" class="flex justify-between">
                                <dt class="text-muted-foreground">Lettre visa</dt>
                                <dd class="font-medium">Demandée</dd>
                            </div>
                        </dl>
                        <hr class="my-4" />
                        <dl class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <dt>Tarif {{ pricing ? tierLabel(pricing.tier ?? '') : '' }}</dt>
                                <dd>{{ pricing ? formatPrice(pricing.base, pricing.currency) : '—' }}</dd>
                            </div>
                            <div v-if="pricing && pricing.discount > 0" class="flex justify-between text-emerald-600">
                                <dt>Remise ({{ pricing.discount_label }})</dt>
                                <dd>-{{ formatPrice(pricing.discount, pricing.currency) }}</dd>
                            </div>
                            <div class="flex justify-between border-t pt-3 text-lg font-bold">
                                <dt>Total à régler</dt>
                                <dd>{{ pricing ? formatPrice(pricing.total, pricing.currency) : '—' }}</dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Consentements -->
                    <div class="space-y-3 rounded-xl border bg-card p-5">
                        <div class="flex items-start gap-3">
                            <input id="terms" v-model="form.terms_accepted" type="checkbox" required class="mt-1 h-4 w-4 accent-primary" />
                            <label for="terms" class="flex-1 text-sm">
                                J'accepte les <a href="/cgv" target="_blank" class="text-primary hover:underline">conditions générales de vente</a> et la <a href="/confidentialite" target="_blank" class="text-primary hover:underline">politique de confidentialité</a>. *
                            </label>
                        </div>
                        <p v-if="form.errors.terms_accepted" class="text-xs text-red-500">{{ form.errors.terms_accepted }}</p>
                        <div class="flex items-start gap-3">
                            <input id="newsletter" v-model="form.newsletter_optin" type="checkbox" class="mt-1 h-4 w-4 accent-primary" />
                            <label for="newsletter" class="flex-1 text-sm">Je souhaite recevoir la newsletter du congrès.</label>
                        </div>
                        <div class="flex items-start gap-3">
                            <input id="directory" v-model="form.directory_optin" type="checkbox" class="mt-1 h-4 w-4 accent-primary" />
                            <label for="directory" class="flex-1 text-sm">J'accepte d'apparaître dans l'annuaire des participants (consultable par les autres participants opt-in).</label>
                        </div>
                    </div>
                </div>

                <!-- Navigation boutons -->
                <div class="mt-8 flex items-center justify-between">
                    <button
                        v-if="currentStep > 1"
                        type="button"
                        @click="back"
                        class="inline-flex items-center gap-1 rounded-lg border px-5 py-2.5 text-sm font-medium hover:bg-accent"
                    >
                        <ChevronLeft class="h-4 w-4" />
                        Retour
                    </button>
                    <div v-else />

                    <button
                        v-if="currentStep < 3"
                        type="button"
                        @click="next"
                        :disabled="!canGoNext()"
                        class="inline-flex items-center gap-1 rounded-lg bg-primary px-6 py-2.5 text-sm font-semibold text-primary-foreground hover:bg-primary/90 disabled:opacity-50"
                    >
                        Continuer
                        <ChevronRight class="h-4 w-4" />
                    </button>
                    <button
                        v-else
                        type="button"
                        @click="submit"
                        :disabled="!form.terms_accepted || form.processing"
                        class="inline-flex items-center gap-2 rounded-lg bg-primary px-6 py-2.5 text-sm font-semibold text-primary-foreground hover:bg-primary/90 disabled:opacity-50"
                    >
                        <Loader2 v-if="form.processing" class="h-4 w-4 animate-spin" />
                        {{ form.processing ? 'Création…' : 'Valider mon inscription' }}
                    </button>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>

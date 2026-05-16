<script setup lang="ts">
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { ArrowLeft, Calendar, MapPin, Users, Sparkles, Loader2, CheckCircle2, AlertTriangle } from 'lucide-vue-next';
import PublicLayout from '@/layouts/PublicLayout.vue';

defineOptions({ layout: null });

const props = defineProps<{ symposium: any }>();

const page = usePage();
const flash = computed<any>(() => (page.props as any).flash ?? {});

const form = useForm({ registration_reference: '', email: '' });

function submit() {
    form.post(`/symposiums/${props.symposium.slug}/register`, { preserveScroll: true });
}

const fmtPrice = (v: number, c: string) => new Intl.NumberFormat('fr-FR', { style: 'currency', currency: c, maximumFractionDigits: 0 }).format(v);
</script>

<template>
    <Head :title="symposium.title" />
    <PublicLayout>
        <article class="container mx-auto max-w-4xl px-4 py-10 lg:px-6">
            <Link href="/symposiums" class="inline-flex items-center gap-1 text-sm text-muted-foreground hover:text-foreground"><ArrowLeft class="h-4 w-4" /> Tous les symposiums</Link>

            <header class="mt-6">
                <div class="inline-flex items-center gap-2 rounded-full bg-primary/10 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-primary"><Sparkles class="h-3 w-3" /> Symposium satellite</div>
                <h1 class="mt-3 text-3xl font-bold sm:text-4xl">{{ symposium.title }}</h1>
                <p v-if="symposium.subtitle" class="mt-2 text-lg text-muted-foreground">{{ symposium.subtitle }}</p>
            </header>

            <div class="mt-6 grid gap-4 sm:grid-cols-2">
                <div class="rounded-lg border bg-card p-4"><Calendar class="h-5 w-5 text-primary" /><p class="mt-2 text-xs uppercase text-muted-foreground">Date</p><p class="text-sm font-semibold">{{ new Date(symposium.starts_at).toLocaleString('fr-FR', { dateStyle: 'full', timeStyle: 'short' }) }}</p></div>
                <div v-if="symposium.room" class="rounded-lg border bg-card p-4"><MapPin class="h-5 w-5" :style="{ color: symposium.room.color }" /><p class="mt-2 text-xs uppercase text-muted-foreground">Salle</p><p class="text-sm font-semibold">{{ symposium.room.name }}</p></div>
                <div v-if="symposium.capacity" class="rounded-lg border bg-card p-4"><Users class="h-5 w-5 text-primary" /><p class="mt-2 text-xs uppercase text-muted-foreground">Places</p><p class="text-sm font-semibold">{{ symposium.registered_count }} / {{ symposium.capacity }}</p></div>
                <div class="rounded-lg border-2 border-primary bg-primary/5 p-4"><p class="text-xs uppercase text-muted-foreground">Tarif</p><p class="text-2xl font-bold text-primary">{{ symposium.price > 0 ? fmtPrice(symposium.price, symposium.currency) : 'Gratuit' }}</p></div>
            </div>

            <div v-if="symposium.sponsor" class="mt-6 flex items-center gap-4 rounded-xl border bg-muted/30 p-4">
                <img v-if="symposium.sponsor.logo_path" :src="`/storage/${symposium.sponsor.logo_path}`" class="h-16 w-auto max-w-[120px] object-contain" :alt="symposium.sponsor.name" />
                <div><p class="text-xs text-muted-foreground">Sponsor</p><p class="font-bold">{{ symposium.sponsor.name }}</p></div>
            </div>

            <div v-if="symposium.description" class="prose prose-sm mt-8 max-w-none dark:prose-invert">
                <p class="whitespace-pre-line">{{ symposium.description }}</p>
            </div>

            <!-- Form inscription -->
            <section class="mt-10 rounded-xl border-2 border-primary/30 bg-primary/5 p-6">
                <h2 class="text-xl font-bold">S'inscrire à ce symposium</h2>
                <div v-if="flash.success" class="mt-4 flex items-start gap-2 rounded-lg bg-emerald-500/10 p-3 text-sm text-emerald-700 dark:text-emerald-400"><CheckCircle2 class="mt-0.5 h-4 w-4" />{{ flash.success }}</div>
                <div v-else-if="flash.warning" class="mt-4 flex items-start gap-2 rounded-lg bg-amber-500/10 p-3 text-sm text-amber-700 dark:text-amber-400"><AlertTriangle class="mt-0.5 h-4 w-4" />{{ flash.warning }}</div>

                <p v-if="symposium.is_full" class="mt-4 text-sm font-bold text-red-600">⚠ Capacité atteinte : symposium complet.</p>
                <form v-else @submit.prevent="submit" class="mt-4 space-y-3">
                    <p class="text-sm text-muted-foreground">Renseignez votre référence d'inscription au congrès et votre e-mail :</p>
                    <input v-model="form.registration_reference" type="text" placeholder="Référence inscription (CONG-2026-...)" required class="w-full rounded-md border bg-background px-3 py-2 text-sm font-mono uppercase" />
                    <p v-if="form.errors.registration_reference" class="text-xs text-red-500">{{ form.errors.registration_reference }}</p>
                    <input v-model="form.email" type="email" placeholder="E-mail inscription" required class="w-full rounded-md border bg-background px-3 py-2 text-sm" />
                    <button type="submit" :disabled="form.processing" class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-primary px-6 py-3 text-sm font-semibold text-primary-foreground hover:bg-primary/90 disabled:opacity-50">
                        <Loader2 v-if="form.processing" class="h-4 w-4 animate-spin" />
                        Confirmer mon inscription au symposium
                    </button>
                </form>
            </section>
        </article>
    </PublicLayout>
</template>

<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { MapPin, Plane, Hotel, Bus, Thermometer, Phone, Mail, MessageCircle, Calendar } from 'lucide-vue-next';
import PublicLayout from '@/layouts/PublicLayout.vue';

defineOptions({ layout: null });

defineProps<{
    venue: {
        name: string | null;
        address: string | null;
        city: string | null;
        country: string | null;
        latitude: number | null;
        longitude: number | null;
    } | null;
    support: {
        email: string | null;
        phone: string | null;
        whatsapp: string | null;
    };
    dates: {
        starts_at: string | null;
        ends_at: string | null;
    } | null;
}>();
</script>

<template>
    <Head title="Informations pratiques" />
    <PublicLayout>
        <section class="border-b bg-gradient-to-br from-primary/5 to-background py-12 lg:py-16">
            <div class="container mx-auto px-4 lg:px-6">
                <div class="inline-flex items-center gap-2 rounded-full border bg-muted px-3 py-1 text-xs font-medium text-muted-foreground">
                    <MapPin class="h-3 w-3" />
                    Sur place
                </div>
                <h1 class="mt-4 text-4xl font-bold tracking-tight sm:text-5xl">Informations pratiques</h1>
                <p class="mt-3 max-w-2xl text-muted-foreground">
                    Tout ce qu'il faut savoir pour préparer votre venue.
                </p>
            </div>
        </section>

        <section class="container mx-auto px-4 py-12 lg:px-6">
            <div class="grid gap-8 lg:grid-cols-2">
                <!-- Lieu -->
                <article v-if="venue" class="rounded-xl border bg-card p-6">
                    <div class="mb-4 flex items-center gap-2">
                        <div class="rounded-lg bg-primary/10 p-2"><MapPin class="h-5 w-5 text-primary" /></div>
                        <h2 class="text-xl font-bold">Le lieu</h2>
                    </div>
                    <p v-if="venue.name" class="font-semibold">{{ venue.name }}</p>
                    <p v-if="venue.address" class="text-sm text-muted-foreground">{{ venue.address }}</p>
                    <p v-if="venue.city" class="text-sm text-muted-foreground">
                        {{ venue.city }}<span v-if="venue.country">, {{ venue.country }}</span>
                    </p>
                    <a
                        v-if="venue.latitude && venue.longitude"
                        :href="`https://www.google.com/maps?q=${venue.latitude},${venue.longitude}`"
                        target="_blank"
                        rel="noopener"
                        class="mt-4 inline-flex items-center gap-1 text-sm font-medium text-primary hover:underline"
                    >
                        Itinéraire Google Maps
                    </a>
                </article>

                <!-- Aéroport / Transports -->
                <article class="rounded-xl border bg-card p-6">
                    <div class="mb-4 flex items-center gap-2">
                        <div class="rounded-lg bg-primary/10 p-2"><Plane class="h-5 w-5 text-primary" /></div>
                        <h2 class="text-xl font-bold">Y venir</h2>
                    </div>
                    <ul class="space-y-3 text-sm">
                        <li class="flex items-start gap-2">
                            <Plane class="mt-0.5 h-4 w-4 shrink-0 text-muted-foreground" />
                            <div>
                                <strong>Avion</strong> — Aéroport international Cardinal Bernardin Gantin (Cotonou, COO). ~30 min en taxi du lieu du congrès.
                            </div>
                        </li>
                        <li class="flex items-start gap-2">
                            <Bus class="mt-0.5 h-4 w-4 shrink-0 text-muted-foreground" />
                            <div>
                                <strong>Sur place</strong> — Navette gratuite entre les hôtels partenaires et le lieu du congrès. VTC Yango / Gozem partout disponibles.
                            </div>
                        </li>
                    </ul>
                </article>

                <!-- Hébergement -->
                <article class="rounded-xl border bg-card p-6">
                    <div class="mb-4 flex items-center gap-2">
                        <div class="rounded-lg bg-primary/10 p-2"><Hotel class="h-5 w-5 text-primary" /></div>
                        <h2 class="text-xl font-bold">Hébergement</h2>
                    </div>
                    <p class="text-sm text-muted-foreground">
                        Plusieurs hôtels partenaires offrent des tarifs préférentiels aux participants. Les codes promo et la liste détaillée sont communiqués après inscription.
                    </p>
                    <Link href="/register" class="mt-4 inline-flex items-center gap-1 text-sm font-medium text-primary hover:underline">
                        S'inscrire pour recevoir les détails
                    </Link>
                </article>

                <!-- Climat -->
                <article class="rounded-xl border bg-card p-6">
                    <div class="mb-4 flex items-center gap-2">
                        <div class="rounded-lg bg-primary/10 p-2"><Thermometer class="h-5 w-5 text-primary" /></div>
                        <h2 class="text-xl font-bold">Climat & tenue</h2>
                    </div>
                    <p class="text-sm text-muted-foreground">
                        Climat tropical humide. Températures entre 24 °C et 30 °C à cette saison. Tenue professionnelle légère recommandée. Pluie occasionnelle, prévoyez un parapluie compact.
                    </p>
                </article>
            </div>

            <!-- Visa -->
            <article class="mt-8 rounded-xl border border-primary/20 bg-primary/5 p-6">
                <h2 class="text-xl font-bold">Vous venez de l'étranger ?</h2>
                <p class="mt-2 max-w-3xl text-sm text-muted-foreground">
                    Après confirmation de votre inscription, vous pouvez demander une <strong>lettre d'invitation officielle</strong> depuis votre espace participant pour faciliter vos démarches de visa. Délai de traitement : 48 h ouvrées.
                </p>
            </article>

            <!-- Contact -->
            <article class="mt-8 rounded-xl border bg-card p-6">
                <h2 class="text-xl font-bold">Une question ?</h2>
                <div class="mt-4 grid gap-4 sm:grid-cols-3">
                    <a v-if="support.email" :href="`mailto:${support.email}`" class="flex items-center gap-3 rounded-lg border p-4 hover:bg-accent">
                        <Mail class="h-5 w-5 text-primary" />
                        <div class="min-w-0">
                            <p class="text-xs uppercase text-muted-foreground">E-mail</p>
                            <p class="truncate text-sm font-medium">{{ support.email }}</p>
                        </div>
                    </a>
                    <a v-if="support.phone" :href="`tel:${support.phone}`" class="flex items-center gap-3 rounded-lg border p-4 hover:bg-accent">
                        <Phone class="h-5 w-5 text-primary" />
                        <div class="min-w-0">
                            <p class="text-xs uppercase text-muted-foreground">Téléphone</p>
                            <p class="truncate text-sm font-medium">{{ support.phone }}</p>
                        </div>
                    </a>
                    <a v-if="support.whatsapp" :href="`https://wa.me/${support.whatsapp.replace(/\D/g, '')}`" target="_blank" rel="noopener" class="flex items-center gap-3 rounded-lg border p-4 hover:bg-accent">
                        <MessageCircle class="h-5 w-5 text-primary" />
                        <div class="min-w-0">
                            <p class="text-xs uppercase text-muted-foreground">WhatsApp</p>
                            <p class="truncate text-sm font-medium">{{ support.whatsapp }}</p>
                        </div>
                    </a>
                </div>
            </article>
        </section>
    </PublicLayout>
</template>

<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { Menu, X } from 'lucide-vue-next';
import { ref } from 'vue';

const page = usePage();

const event = computed(() => (page.props as any).event ?? {});
const branding = computed(() => (page.props as any).branding ?? {});
const modules = computed(() => (page.props as any).modules ?? {});
const auth = computed(() => (page.props as any).auth ?? {});

const navOpen = ref(false);

const navLinks = computed(() => {
    const links: Array<{ label: string; href: string; show: boolean }> = [
        { label: 'Accueil', href: '/', show: true },
        { label: 'Programme', href: '/programme', show: modules.value.sessions_enabled },
        { label: 'Intervenants', href: '/intervenants', show: modules.value.speakers_enabled },
        { label: 'Résumés', href: '/abstracts', show: modules.value.abstracts_enabled },
        { label: 'Sponsors', href: '/sponsors', show: modules.value.sponsors_enabled },
        { label: 'Exposants', href: '/exposants', show: modules.value.exhibitors_enabled },
        { label: 'Infos pratiques', href: '/infos-pratiques', show: true },
        { label: 'FAQ', href: '/faq', show: modules.value.faq_enabled },
        { label: 'Contact', href: '/contact', show: true },
    ];
    return links.filter((l) => l.show);
});
</script>

<template>
    <div class="min-h-screen bg-background text-foreground">
        <!-- Header -->
        <header class="sticky top-0 z-50 w-full border-b border-border/40 bg-background/95 backdrop-blur supports-[backdrop-filter]:bg-background/60">
            <div class="container mx-auto flex h-16 items-center justify-between px-4 lg:px-6">
                <!-- Logo / Nom -->
                <Link href="/" class="flex items-center gap-2">
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-primary text-primary-foreground font-bold">
                        {{ (event.name ?? 'C').charAt(0) }}
                    </div>
                    <div class="hidden flex-col sm:flex">
                        <span class="text-sm font-semibold leading-tight">{{ event.name ?? 'Congresia' }}</span>
                        <span v-if="event.tagline" class="text-xs text-muted-foreground leading-tight">{{ event.tagline }}</span>
                    </div>
                </Link>

                <!-- Nav desktop -->
                <nav class="hidden lg:flex items-center gap-1">
                    <Link
                        v-for="link in navLinks"
                        :key="link.href"
                        :href="link.href"
                        class="rounded-md px-3 py-1.5 text-sm font-medium text-muted-foreground transition-colors hover:bg-accent hover:text-foreground"
                    >
                        {{ link.label }}
                    </Link>
                </nav>

                <!-- Actions droite -->
                <div class="flex items-center gap-2">
                    <Link
                        v-if="auth.user"
                        href="/dashboard"
                        class="hidden sm:inline-flex items-center rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground transition-colors hover:bg-primary/90"
                    >
                        Mon espace
                    </Link>
                    <template v-else>
                        <Link
                            href="/login"
                            class="hidden sm:inline-flex items-center rounded-md px-3 py-2 text-sm font-medium hover:bg-accent"
                        >
                            Connexion
                        </Link>
                        <Link
                            v-if="modules.registrations_enabled"
                            href="/register"
                            class="hidden sm:inline-flex items-center rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground transition-colors hover:bg-primary/90"
                        >
                            S'inscrire
                        </Link>
                    </template>

                    <!-- Burger mobile -->
                    <button
                        type="button"
                        class="inline-flex h-9 w-9 items-center justify-center rounded-md lg:hidden hover:bg-accent"
                        @click="navOpen = !navOpen"
                        :aria-expanded="navOpen"
                        aria-label="Menu"
                    >
                        <Menu v-if="!navOpen" class="h-5 w-5" />
                        <X v-else class="h-5 w-5" />
                    </button>
                </div>
            </div>

            <!-- Menu mobile -->
            <div v-if="navOpen" class="border-t lg:hidden">
                <nav class="container mx-auto flex flex-col gap-1 px-4 py-3">
                    <Link
                        v-for="link in navLinks"
                        :key="link.href"
                        :href="link.href"
                        class="rounded-md px-3 py-2 text-sm font-medium text-foreground hover:bg-accent"
                        @click="navOpen = false"
                    >
                        {{ link.label }}
                    </Link>
                    <div class="mt-2 flex flex-col gap-2 border-t pt-3">
                        <Link
                            v-if="auth.user"
                            href="/dashboard"
                            class="rounded-md bg-primary px-4 py-2 text-center text-sm font-medium text-primary-foreground"
                        >
                            Mon espace
                        </Link>
                        <template v-else>
                            <Link
                                href="/login"
                                class="rounded-md border px-4 py-2 text-center text-sm font-medium"
                            >
                                Connexion
                            </Link>
                            <Link
                                v-if="modules.registrations_enabled"
                                href="/register"
                                class="rounded-md bg-primary px-4 py-2 text-center text-sm font-medium text-primary-foreground"
                            >
                                S'inscrire
                            </Link>
                        </template>
                    </div>
                </nav>
            </div>
        </header>

        <!-- Slot principal -->
        <main>
            <slot />
        </main>

        <!-- Footer -->
        <footer class="mt-24 border-t bg-muted/30">
            <div class="container mx-auto px-4 py-12 lg:px-6">
                <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-4">
                    <div>
                        <h3 class="mb-3 text-sm font-semibold">{{ event.name ?? 'Congresia' }}</h3>
                        <p v-if="event.tagline" class="text-sm text-muted-foreground">{{ event.tagline }}</p>
                        <p v-if="event.venue_city" class="mt-3 text-sm text-muted-foreground">
                            {{ event.venue_name }}<br v-if="event.venue_name" />
                            {{ event.venue_city }}<span v-if="event.venue_country">, {{ event.venue_country }}</span>
                        </p>
                    </div>
                    <div>
                        <h3 class="mb-3 text-sm font-semibold">Navigation</h3>
                        <ul class="space-y-2 text-sm">
                            <li v-for="link in navLinks.slice(0, 5)" :key="link.href">
                                <Link :href="link.href" class="text-muted-foreground hover:text-foreground">{{ link.label }}</Link>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="mb-3 text-sm font-semibold">Participer</h3>
                        <ul class="space-y-2 text-sm">
                            <li v-if="modules.registrations_enabled">
                                <Link href="/register" class="text-muted-foreground hover:text-foreground">S'inscrire</Link>
                            </li>
                            <li v-if="modules.abstracts_enabled">
                                <Link href="/abstracts/submit" class="text-muted-foreground hover:text-foreground">Soumettre un résumé</Link>
                            </li>
                            <li>
                                <Link href="/login" class="text-muted-foreground hover:text-foreground">Espace participant</Link>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="mb-3 text-sm font-semibold">Légal</h3>
                        <ul class="space-y-2 text-sm">
                            <li><Link href="/mentions-legales" class="text-muted-foreground hover:text-foreground">Mentions légales</Link></li>
                            <li><Link href="/confidentialite" class="text-muted-foreground hover:text-foreground">Confidentialité</Link></li>
                            <li><Link href="/cgv" class="text-muted-foreground hover:text-foreground">CGV</Link></li>
                        </ul>
                    </div>
                </div>
                <div class="mt-8 flex flex-col items-center justify-between gap-4 border-t pt-6 text-xs text-muted-foreground sm:flex-row">
                    <p>© {{ new Date().getFullYear() }} {{ event.name ?? 'Congresia' }}. Tous droits réservés.</p>
                    <p>Propulsé par <span class="font-semibold text-foreground">Congresia</span></p>
                </div>
            </div>
        </footer>
    </div>
</template>

<script setup lang="ts">
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { Mail, Phone, MessageCircle, Send, CheckCircle2 } from 'lucide-vue-next';
import PublicLayout from '@/layouts/PublicLayout.vue';

defineOptions({ layout: null });

defineProps<{
    support: {
        email: string | null;
        phone: string | null;
        whatsapp: string | null;
    };
}>();

const page = usePage();
const flash = computed(() => (page.props as any).flash ?? {});

const form = useForm({
    name: '',
    email: '',
    subject: '',
    message: '',
});

function submit() {
    form.post('/contact', {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
}
</script>

<template>
    <Head title="Contact" />
    <PublicLayout>
        <section class="border-b bg-gradient-to-br from-primary/5 to-background py-12 lg:py-16">
            <div class="container mx-auto px-4 lg:px-6">
                <div class="inline-flex items-center gap-2 rounded-full border bg-muted px-3 py-1 text-xs font-medium text-muted-foreground">
                    <Mail class="h-3 w-3" />
                    Contact
                </div>
                <h1 class="mt-4 text-4xl font-bold tracking-tight sm:text-5xl">Contactez-nous</h1>
                <p class="mt-3 max-w-2xl text-muted-foreground">
                    Une question, un partenariat, une demande spécifique ? Nous vous répondons rapidement.
                </p>
            </div>
        </section>

        <section class="container mx-auto px-4 py-12 lg:px-6">
            <div class="grid gap-8 lg:grid-cols-[1fr_360px]">
                <!-- Formulaire -->
                <div class="rounded-xl border bg-card p-6 lg:p-8">
                    <div v-if="flash.success" class="mb-6 flex items-start gap-3 rounded-lg border border-emerald-500/30 bg-emerald-500/10 p-4 text-sm">
                        <CheckCircle2 class="mt-0.5 h-5 w-5 shrink-0 text-emerald-600" />
                        <p class="text-emerald-900 dark:text-emerald-300">{{ flash.success }}</p>
                    </div>

                    <form @submit.prevent="submit" class="space-y-5">
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label for="name" class="mb-1.5 block text-sm font-medium">Nom complet *</label>
                                <input
                                    id="name"
                                    v-model="form.name"
                                    type="text"
                                    required
                                    class="w-full rounded-md border bg-background px-3 py-2 text-sm outline-none ring-primary focus:ring-2"
                                />
                                <p v-if="form.errors.name" class="mt-1 text-xs text-red-500">{{ form.errors.name }}</p>
                            </div>
                            <div>
                                <label for="email" class="mb-1.5 block text-sm font-medium">E-mail *</label>
                                <input
                                    id="email"
                                    v-model="form.email"
                                    type="email"
                                    required
                                    class="w-full rounded-md border bg-background px-3 py-2 text-sm outline-none ring-primary focus:ring-2"
                                />
                                <p v-if="form.errors.email" class="mt-1 text-xs text-red-500">{{ form.errors.email }}</p>
                            </div>
                        </div>

                        <div>
                            <label for="subject" class="mb-1.5 block text-sm font-medium">Sujet *</label>
                            <input
                                id="subject"
                                v-model="form.subject"
                                type="text"
                                required
                                class="w-full rounded-md border bg-background px-3 py-2 text-sm outline-none ring-primary focus:ring-2"
                            />
                            <p v-if="form.errors.subject" class="mt-1 text-xs text-red-500">{{ form.errors.subject }}</p>
                        </div>

                        <div>
                            <label for="message" class="mb-1.5 block text-sm font-medium">Message *</label>
                            <textarea
                                id="message"
                                v-model="form.message"
                                rows="6"
                                required
                                class="w-full resize-y rounded-md border bg-background px-3 py-2 text-sm outline-none ring-primary focus:ring-2"
                            ></textarea>
                            <p v-if="form.errors.message" class="mt-1 text-xs text-red-500">{{ form.errors.message }}</p>
                        </div>

                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="inline-flex items-center gap-2 rounded-lg bg-primary px-6 py-2.5 text-sm font-semibold text-primary-foreground shadow-md transition hover:bg-primary/90 disabled:opacity-50"
                        >
                            <Send class="h-4 w-4" />
                            {{ form.processing ? 'Envoi…' : 'Envoyer le message' }}
                        </button>
                    </form>
                </div>

                <!-- Coordonnées -->
                <aside class="space-y-4">
                    <a
                        v-if="support.email"
                        :href="`mailto:${support.email}`"
                        class="flex items-start gap-3 rounded-xl border bg-card p-4 transition hover:shadow-md"
                    >
                        <div class="rounded-lg bg-primary/10 p-2"><Mail class="h-5 w-5 text-primary" /></div>
                        <div class="min-w-0 flex-1">
                            <p class="text-xs uppercase tracking-wider text-muted-foreground">E-mail</p>
                            <p class="truncate text-sm font-medium">{{ support.email }}</p>
                        </div>
                    </a>
                    <a
                        v-if="support.phone"
                        :href="`tel:${support.phone}`"
                        class="flex items-start gap-3 rounded-xl border bg-card p-4 transition hover:shadow-md"
                    >
                        <div class="rounded-lg bg-primary/10 p-2"><Phone class="h-5 w-5 text-primary" /></div>
                        <div class="min-w-0 flex-1">
                            <p class="text-xs uppercase tracking-wider text-muted-foreground">Téléphone</p>
                            <p class="truncate text-sm font-medium">{{ support.phone }}</p>
                        </div>
                    </a>
                    <a
                        v-if="support.whatsapp"
                        :href="`https://wa.me/${support.whatsapp.replace(/\D/g, '')}`"
                        target="_blank"
                        rel="noopener"
                        class="flex items-start gap-3 rounded-xl border bg-card p-4 transition hover:shadow-md"
                    >
                        <div class="rounded-lg bg-emerald-500/10 p-2"><MessageCircle class="h-5 w-5 text-emerald-600" /></div>
                        <div class="min-w-0 flex-1">
                            <p class="text-xs uppercase tracking-wider text-muted-foreground">WhatsApp</p>
                            <p class="truncate text-sm font-medium">{{ support.whatsapp }}</p>
                        </div>
                    </a>
                </aside>
            </div>
        </section>
    </PublicLayout>
</template>

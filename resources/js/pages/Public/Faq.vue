<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { HelpCircle, ChevronDown } from 'lucide-vue-next';
import PublicLayout from '@/layouts/PublicLayout.vue';

defineOptions({ layout: null });

defineProps<{
    categories: Array<{
        key: string;
        label: string;
        items: Array<{ id: number; question: string; answer: string }>;
    }>;
}>();

const openId = ref<number | null>(null);

function toggle(id: number) {
    openId.value = openId.value === id ? null : id;
}
</script>

<template>
    <Head title="Foire aux questions" />
    <PublicLayout>
        <section class="border-b bg-gradient-to-br from-primary/5 to-background py-12 lg:py-16">
            <div class="container mx-auto px-4 lg:px-6">
                <div class="inline-flex items-center gap-2 rounded-full border bg-muted px-3 py-1 text-xs font-medium text-muted-foreground">
                    <HelpCircle class="h-3 w-3" />
                    FAQ
                </div>
                <h1 class="mt-4 text-4xl font-bold tracking-tight sm:text-5xl">Questions fréquentes</h1>
                <p class="mt-3 max-w-2xl text-muted-foreground">
                    Inscription, paiement, soumission de résumés, logistique : retrouvez les réponses aux questions les plus posées.
                </p>
            </div>
        </section>

        <section class="container mx-auto max-w-3xl px-4 py-12 lg:px-6">
            <div v-if="!categories.length" class="rounded-xl border border-dashed bg-muted/30 py-16 text-center">
                <HelpCircle class="mx-auto h-10 w-10 text-muted-foreground/50" />
                <p class="mt-4 text-base font-medium">FAQ en préparation</p>
            </div>

            <div v-for="cat in categories" :key="cat.key" class="mb-10">
                <h2 class="mb-4 text-xl font-bold">{{ cat.label }}</h2>
                <div class="space-y-2">
                    <div
                        v-for="item in cat.items"
                        :key="item.id"
                        class="rounded-lg border bg-card transition"
                    >
                        <button
                            type="button"
                            @click="toggle(item.id)"
                            class="flex w-full items-start justify-between gap-3 p-4 text-left hover:bg-accent"
                            :aria-expanded="openId === item.id"
                        >
                            <span class="text-sm font-semibold">{{ item.question }}</span>
                            <ChevronDown
                                class="mt-0.5 h-5 w-5 shrink-0 text-muted-foreground transition-transform"
                                :class="{ 'rotate-180': openId === item.id }"
                            />
                        </button>
                        <div v-if="openId === item.id" class="border-t px-4 pb-4 pt-3 text-sm text-muted-foreground whitespace-pre-line">
                            {{ item.answer }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-12 rounded-xl border bg-muted/30 p-6 text-center">
                <h3 class="text-lg font-semibold">Vous ne trouvez pas votre réponse ?</h3>
                <p class="mt-1 text-sm text-muted-foreground">Notre équipe vous répond en moins de 24h.</p>
                <Link href="/contact" class="mt-4 inline-flex items-center gap-2 rounded-lg bg-primary px-5 py-2 text-sm font-medium text-primary-foreground">
                    Nous contacter
                </Link>
            </div>
        </section>
    </PublicLayout>
</template>

<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import { Loader2 } from 'lucide-vue-next';
import PublicLayout from '@/layouts/PublicLayout.vue';

defineOptions({ layout: null });

const props = defineProps<{
    registration: { reference: string; amount: number; currency: string };
    widget: {
        public_key: string;
        sandbox: boolean;
        script_url: string;
        amount: number;
        currency: string;
        name: string;
        email: string;
        phone: string | null;
        data: string;
        callback: string;
    };
}>();

const ready = ref(false);
const error = ref<string | null>(null);

onMounted(() => {
    if (!props.widget.public_key) {
        error.value = 'Configuration Kkiapay manquante (KKIAPAY_PUBLIC_KEY dans .env).';
        return;
    }

    const script = document.createElement('script');
    script.src = props.widget.script_url;
    script.async = true;
    script.onload = () => {
        ready.value = true;
        // @ts-ignore
        if (typeof window.openKkiapayWidget === 'function') {
            // @ts-ignore
            window.openKkiapayWidget({
                amount: props.widget.amount,
                api_key: props.widget.public_key,
                sandbox: props.widget.sandbox,
                phone: props.widget.phone || '',
                email: props.widget.email,
                name: props.widget.name,
                data: props.widget.data,
                callback: props.widget.callback,
            });
        }
    };
    script.onerror = () => (error.value = 'Impossible de charger le widget Kkiapay.');
    document.body.appendChild(script);
});
</script>

<template>
    <Head title="Paiement Kkiapay" />
    <PublicLayout>
        <section class="container mx-auto max-w-xl px-4 py-16 text-center lg:px-6">
            <div v-if="error" class="rounded-xl border border-red-500/30 bg-red-500/10 p-6 text-sm text-red-700 dark:text-red-300">
                {{ error }}
            </div>
            <div v-else>
                <Loader2 class="mx-auto h-10 w-10 animate-spin text-primary" />
                <p class="mt-4 text-lg font-semibold">Ouverture de Kkiapay…</p>
                <p class="mt-2 text-sm text-muted-foreground">Si le widget ne s'ouvre pas automatiquement, vérifiez que les pop-ups sont autorisés.</p>
            </div>
        </section>
    </PublicLayout>
</template>

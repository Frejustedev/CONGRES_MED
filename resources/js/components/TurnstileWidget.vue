<script setup lang="ts">
import { onBeforeUnmount, onMounted, ref, usePage } from 'vue';
import { usePage as useInertiaPage } from '@inertiajs/vue3';

const emit = defineEmits<{ verified: [token: string]; expired: []; error: [] }>();

const page = useInertiaPage();
const siteKey = (page.props as any).turnstile_site_key ?? '';
const containerRef = ref<HTMLDivElement | null>(null);
const widgetId = ref<string | null>(null);
const loaded = ref(false);

const isDevMode = !siteKey;

onMounted(() => {
    if (isDevMode) {
        // Mode dev : pas de clé → on simule la validation
        setTimeout(() => emit('verified', 'dev-mode-bypass'), 100);
        return;
    }

    // Charge le script Turnstile une seule fois
    if (!document.querySelector('script[src*="turnstile"]')) {
        const script = document.createElement('script');
        script.src = 'https://challenges.cloudflare.com/turnstile/v0/api.js?onload=onTurnstileLoad';
        script.async = true;
        script.defer = true;
        (window as any).onTurnstileLoad = () => {
            loaded.value = true;
            renderWidget();
        };
        document.head.appendChild(script);
    } else if ((window as any).turnstile) {
        loaded.value = true;
        renderWidget();
    }
});

function renderWidget() {
    if (!containerRef.value || !(window as any).turnstile) return;
    widgetId.value = (window as any).turnstile.render(containerRef.value, {
        sitekey: siteKey,
        callback: (token: string) => emit('verified', token),
        'expired-callback': () => emit('expired'),
        'error-callback': () => emit('error'),
        theme: 'auto',
        size: 'normal',
    });
}

onBeforeUnmount(() => {
    if (widgetId.value && (window as any).turnstile) {
        try { (window as any).turnstile.remove(widgetId.value); } catch { /* noop */ }
    }
});
</script>

<template>
    <div v-if="isDevMode" class="rounded-md border border-amber-500/30 bg-amber-500/10 p-2 text-xs text-amber-700 dark:text-amber-400">
        Mode dev : captcha désactivé (TURNSTILE_SITE_KEY vide dans .env).
    </div>
    <div v-else ref="containerRef" class="min-h-[65px]"></div>
</template>

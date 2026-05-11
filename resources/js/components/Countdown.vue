<script setup lang="ts">
import { computed, onBeforeUnmount, onMounted, ref } from 'vue';

const props = withDefaults(
    defineProps<{
        target: string | null;
        label?: string;
    }>(),
    {
        label: 'Avant l\'événement',
    },
);

const now = ref(Date.now());
let timerId: number | null = null;

onMounted(() => {
    timerId = window.setInterval(() => {
        now.value = Date.now();
    }, 1000);
});

onBeforeUnmount(() => {
    if (timerId !== null) clearInterval(timerId);
});

const remaining = computed(() => {
    if (!props.target) return null;
    const targetMs = new Date(props.target).getTime();
    const diff = targetMs - now.value;
    if (diff <= 0) return null;

    const seconds = Math.floor(diff / 1000) % 60;
    const minutes = Math.floor(diff / (1000 * 60)) % 60;
    const hours = Math.floor(diff / (1000 * 60 * 60)) % 24;
    const days = Math.floor(diff / (1000 * 60 * 60 * 24));

    return { days, hours, minutes, seconds };
});

const formatNumber = (n: number) => n.toString().padStart(2, '0');

const eventStarted = computed(() => props.target && new Date(props.target).getTime() <= now.value);
</script>

<template>
    <div v-if="remaining" class="grid grid-cols-4 gap-2 sm:gap-4">
        <div
            v-for="unit in [
                { value: remaining.days, label: 'Jours' },
                { value: remaining.hours, label: 'Heures' },
                { value: remaining.minutes, label: 'Min.' },
                { value: remaining.seconds, label: 'Sec.' },
            ]"
            :key="unit.label"
            class="flex flex-col items-center rounded-xl border border-border/50 bg-card/50 px-2 py-3 backdrop-blur-sm sm:px-4 sm:py-5"
        >
            <span class="tabular-nums text-3xl font-bold text-foreground sm:text-5xl">
                {{ formatNumber(unit.value) }}
            </span>
            <span class="mt-1 text-[10px] uppercase tracking-wider text-muted-foreground sm:text-xs">
                {{ unit.label }}
            </span>
        </div>
    </div>
    <div v-else-if="eventStarted" class="rounded-xl border border-primary/30 bg-primary/10 px-6 py-4 text-center">
        <p class="font-semibold text-primary">L'événement a commencé !</p>
    </div>
    <div v-else class="text-sm text-muted-foreground">Dates à venir prochainement.</div>
</template>

<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3';
import { onBeforeUnmount, onMounted, ref, computed } from 'vue';
import { Camera, CheckCircle2, XCircle, ScanLine, AlertTriangle, Wifi, WifiOff } from 'lucide-vue-next';
import AppLayout from '@/layouts/AppLayout.vue';
import { BrowserMultiFormatReader } from '@zxing/browser';

defineOptions({ layout: AppLayout as any });

const props = defineProps<{
    rooms: Array<{ id: number; slug: string; name: string; color: string }>;
    sessions: Array<{ id: number; title: string; starts_at: string; ends_at: string; room_id: number | null }>;
    recentScans: Array<{ id: number; participant: string; reference: string; session: string | null; scan_point: string; scanned_at: string }>;
}>();

const page = usePage();
const scanPoint = ref<'entrance' | 'room' | 'exit' | 'gala' | 'workshop'>('entrance');
const selectedSessionId = ref<number | null>(null);
const selectedRoomId = ref<number | null>(null);
const reader = ref<BrowserMultiFormatReader | null>(null);
const videoRef = ref<HTMLVideoElement | null>(null);
const scanning = ref(false);
const cameraError = ref<string | null>(null);

const lastResult = ref<{
    ok: boolean;
    message: string;
    participant?: { name: string; reference: string; category: string; organization: string | null };
    duplicate?: boolean;
} | null>(null);

const recentList = ref([...props.recentScans]);
const online = ref(navigator.onLine);
const pendingQueue = ref<Array<any>>([]);

const csrf = () => (document.querySelector<HTMLMetaElement>('meta[name="csrf-token"]')?.content ?? '');

onMounted(() => {
    window.addEventListener('online', handleOnline);
    window.addEventListener('offline', handleOffline);
    loadQueueFromStorage();
});

onBeforeUnmount(() => {
    stopScanner();
    window.removeEventListener('online', handleOnline);
    window.removeEventListener('offline', handleOffline);
});

function handleOnline() {
    online.value = true;
    syncQueue();
}
function handleOffline() {
    online.value = false;
}

async function startScanner() {
    if (scanning.value) return;
    cameraError.value = null;
    try {
        reader.value = new BrowserMultiFormatReader();
        scanning.value = true;
        await reader.value.decodeFromVideoDevice(undefined, videoRef.value!, (result) => {
            if (result) {
                const payload = result.getText();
                handleScanResult(payload);
            }
        });
    } catch (e: any) {
        cameraError.value = e?.message ?? 'Caméra inaccessible.';
        scanning.value = false;
    }
}

function stopScanner() {
    if (reader.value) {
        try {
            // @ts-ignore
            reader.value.reset?.();
        } catch {
            /* noop */
        }
        reader.value = null;
    }
    scanning.value = false;
}

let lastScanText = '';
let lastScanAt = 0;

async function handleScanResult(payload: string) {
    const now = Date.now();
    if (payload === lastScanText && now - lastScanAt < 2000) return;
    lastScanText = payload;
    lastScanAt = now;

    const syncUuid = crypto.randomUUID();
    const body = {
        qr_payload: payload,
        session_id: selectedSessionId.value,
        room_id: selectedRoomId.value,
        scan_point: scanPoint.value,
        sync_uuid: syncUuid,
    };

    if (!online.value) {
        queueOffline(body);
        lastResult.value = { ok: true, message: 'En attente de connexion (queue offline)…' };
        return;
    }

    await sendScan(body);
}

async function sendScan(body: any) {
    try {
        const res = await fetch('/staff/scan/validate', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf(), Accept: 'application/json' },
            credentials: 'same-origin',
            body: JSON.stringify(body),
        });
        const data = await res.json();
        lastResult.value = data;
        if (res.ok && data.success) {
            recentList.value.unshift({
                id: data.attendance_id,
                participant: data.participant.name,
                reference: data.participant.reference,
                session: null,
                scan_point: body.scan_point,
                scanned_at: new Date().toLocaleTimeString('fr-FR'),
            });
            if (recentList.value.length > 20) recentList.value.pop();
            playSound(data.duplicate ? 'warn' : 'ok');
        } else {
            playSound('fail');
        }
    } catch (e) {
        queueOffline(body);
        playSound('warn');
    }
}

function queueOffline(body: any) {
    pendingQueue.value.push(body);
    saveQueueToStorage();
}

function loadQueueFromStorage() {
    try {
        const raw = localStorage.getItem('congresia_scan_queue');
        if (raw) pendingQueue.value = JSON.parse(raw);
    } catch {
        /* noop */
    }
    if (online.value) syncQueue();
}
function saveQueueToStorage() {
    localStorage.setItem('congresia_scan_queue', JSON.stringify(pendingQueue.value));
}

async function syncQueue() {
    if (!pendingQueue.value.length) return;
    const toSend = [...pendingQueue.value];
    pendingQueue.value = [];
    for (const body of toSend) {
        await sendScan({ ...body, is_offline_sync: true });
    }
    saveQueueToStorage();
}

function playSound(type: 'ok' | 'warn' | 'fail') {
    try {
        const ctx = new (window.AudioContext || (window as any).webkitAudioContext)();
        const o = ctx.createOscillator();
        const g = ctx.createGain();
        o.connect(g);
        g.connect(ctx.destination);
        o.frequency.value = type === 'ok' ? 880 : type === 'warn' ? 440 : 220;
        g.gain.value = 0.15;
        o.start();
        setTimeout(() => {
            o.stop();
            ctx.close();
        }, type === 'ok' ? 120 : 240);
    } catch {
        /* noop */
    }
}

const queueSize = computed(() => pendingQueue.value.length);
</script>

<template>
    <Head title="Scanner Jour J" />

    <div class="container mx-auto px-4 py-6 lg:px-6">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <div class="rounded-lg bg-primary/10 p-2"><ScanLine class="h-6 w-6 text-primary" /></div>
                <div>
                    <h1 class="text-xl font-bold">Scanner Jour J</h1>
                    <p class="text-xs text-muted-foreground">Validation des entrées et sessions par QR code</p>
                </div>
            </div>
            <div class="flex items-center gap-3 text-xs">
                <span class="flex items-center gap-1">
                    <Wifi v-if="online" class="h-4 w-4 text-emerald-500" />
                    <WifiOff v-else class="h-4 w-4 text-amber-500" />
                    {{ online ? 'En ligne' : 'Hors ligne' }}
                </span>
                <span v-if="queueSize > 0" class="rounded-full bg-amber-500/10 px-2 py-0.5 text-amber-700 dark:text-amber-400">
                    {{ queueSize }} en attente
                </span>
            </div>
        </div>

        <div class="grid gap-4 lg:grid-cols-[1fr_360px]">
            <!-- Scanner -->
            <div class="rounded-xl border bg-card p-4">
                <!-- Config scan -->
                <div class="mb-4 flex flex-wrap gap-2">
                    <select v-model="scanPoint" class="rounded-md border bg-background px-3 py-2 text-sm">
                        <option value="entrance">Entrée principale</option>
                        <option value="room">Salle de session</option>
                        <option value="exit">Sortie</option>
                        <option value="gala">Gala</option>
                        <option value="workshop">Atelier</option>
                    </select>
                    <select v-if="scanPoint === 'room'" v-model="selectedRoomId" class="rounded-md border bg-background px-3 py-2 text-sm">
                        <option :value="null">— Salle —</option>
                        <option v-for="r in rooms" :key="r.id" :value="r.id">{{ r.name }}</option>
                    </select>
                    <select v-if="scanPoint !== 'entrance' && scanPoint !== 'exit'" v-model="selectedSessionId" class="rounded-md border bg-background px-3 py-2 text-sm">
                        <option :value="null">— Session —</option>
                        <option v-for="s in sessions" :key="s.id" :value="s.id">{{ s.starts_at }} {{ s.title }}</option>
                    </select>
                </div>

                <!-- Video -->
                <div class="relative aspect-video overflow-hidden rounded-lg bg-black">
                    <video ref="videoRef" class="h-full w-full object-cover" autoplay playsinline muted></video>
                    <div v-if="!scanning && !cameraError" class="absolute inset-0 flex items-center justify-center bg-black/60 text-white">
                        <button @click="startScanner" type="button" class="inline-flex items-center gap-2 rounded-lg bg-primary px-6 py-3 text-base font-semibold text-primary-foreground">
                            <Camera class="h-5 w-5" /> Démarrer la caméra
                        </button>
                    </div>
                    <div v-if="cameraError" class="absolute inset-0 flex items-center justify-center bg-black/80 text-white p-6 text-center">
                        <div>
                            <AlertTriangle class="mx-auto h-8 w-8 text-amber-400" />
                            <p class="mt-2 text-sm">{{ cameraError }}</p>
                            <button @click="startScanner" type="button" class="mt-3 rounded-md border border-white/30 px-3 py-1 text-xs">Réessayer</button>
                        </div>
                    </div>
                </div>

                <button v-if="scanning" @click="stopScanner" type="button" class="mt-3 rounded-md border px-4 py-2 text-sm">Arrêter</button>

                <!-- Last result -->
                <div v-if="lastResult" :class="[
                    'mt-4 rounded-xl border-2 p-4',
                    lastResult.ok && !lastResult.duplicate ? 'border-emerald-500/40 bg-emerald-500/5' :
                    lastResult.ok && lastResult.duplicate ? 'border-amber-500/40 bg-amber-500/5' :
                    'border-red-500/40 bg-red-500/5'
                ]">
                    <div class="flex items-start gap-3">
                        <CheckCircle2 v-if="lastResult.ok && !lastResult.duplicate" class="h-6 w-6 text-emerald-600 shrink-0" />
                        <AlertTriangle v-else-if="lastResult.duplicate" class="h-6 w-6 text-amber-600 shrink-0" />
                        <XCircle v-else class="h-6 w-6 text-red-600 shrink-0" />
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold">{{ lastResult.message }}</p>
                            <div v-if="lastResult.participant" class="mt-1 text-sm">
                                <p class="font-bold text-base">{{ lastResult.participant.name }}</p>
                                <p class="text-muted-foreground">{{ lastResult.participant.category }} · <span class="font-mono">{{ lastResult.participant.reference }}</span></p>
                                <p v-if="lastResult.participant.organization" class="text-xs text-muted-foreground">{{ lastResult.participant.organization }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent scans -->
            <div class="rounded-xl border bg-card p-4">
                <h2 class="mb-3 text-sm font-bold">Mes derniers scans</h2>
                <div v-if="!recentList.length" class="rounded-lg border border-dashed bg-muted/30 py-8 text-center text-xs text-muted-foreground">
                    Aucun scan effectué.
                </div>
                <div v-else class="space-y-2 max-h-[500px] overflow-y-auto">
                    <div v-for="s in recentList" :key="s.id" class="rounded-lg border p-2 text-xs">
                        <p class="font-semibold truncate">{{ s.participant }}</p>
                        <p class="text-muted-foreground font-mono">{{ s.reference }}</p>
                        <p class="text-muted-foreground">{{ s.scanned_at }} · {{ s.scan_point }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<template>
    <AdminPageHeader
        description="Наведите камеру на qr code."
        eyebrow="Складской учёт"
        title="Поиск растения по qr"
        back-url="/admin/product-units"
        back-label="Назад"
    />
    <div class="qr-scanner">
        <div v-show="isScanning" class="video-wrapper">
            <video ref="videoRef" playsinline muted></video>
            <canvas ref="overlayRef" class="overlay"></canvas>
        </div>

        <div v-if="scanResult" class="result-box">
            <p><strong>Распознано:</strong> {{ scanResult }}</p>
            <button @click="startScanner">Сканировать еще раз</button>
        </div>

        <p v-if="errorMsg" class="error">{{ errorMsg }}</p>
    </div>
</template>

<script setup>
import { onBeforeUnmount, onMounted, ref } from 'vue';
import { frameLoop, QRCanvas, rearCamera } from 'qr/dom.js';
import AdminLayout from '@/layouts/AdminLayout.vue';
import AdminPageHeader from '@/components/admin/AdminPageHeader.vue';

defineOptions({
    layout: AdminLayout,
})

const videoRef = ref(null);
const overlayRef = ref(null);
const scanResult = ref('');
const errorMsg = ref('');
const isScanning = ref(false);

let cancelLoop = null;
let camera = null;

const startScanner = async () => {
    scanResult.value = '';
    errorMsg.value = '';

    try {
        isScanning.value = true;

        const canvas = new QRCanvas({ overlay: overlayRef.value });

        camera = await rearCamera(videoRef.value);

        cancelLoop = frameLoop(() => {
            const decoded = camera.readFrame(canvas);

            if (decoded !== undefined) {
                scanResult.value = decoded;
                stopScanner();
            }
        })
    } catch (err) {
        isScanning.value = false;
        errorMsg.value = 'Не удалось запустить камеру: ' + err.message;
    }
}

const stopScanner = () => {
    if (cancelLoop) {
        cancelLoop();
        cancelLoop = null;
    }
    if (camera) {
        camera.stop();
        camera = null;
    }
    isScanning.value = false;
}

onMounted(() => {
    startScanner();
})

onBeforeUnmount(() => {
    stopScanner();
})
</script>

<style scoped>
.video-wrapper {
    position: relative;
    width: 100%;
    max-width: 400px;
    aspect-ratio: 1 / 1;
    background: #000;
    overflow: hidden;
    border-radius: 8px;
}

video,
.overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.overlay {
    pointer-events: none;
}

.result-box {
    margin-top: 16px;
}

.error {
    color: #dc2626;
    margin-top: 12px;
}
</style>

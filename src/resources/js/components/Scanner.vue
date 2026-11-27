<template>
    <div class="scanner">
        <Loader v-if="isLoading" class="scanner__loader" />
        <div v-show="!isLoading" class="scanner__camera">
            <video ref="videoRef" playsinline muted class="scanner__video" />
        </div>
        <p v-if="errorMsg" class="scanner__error">{{ errorMsg }}</p>
    </div>
</template>

<script setup lang="ts">
import type { Result} from '@zxing/library';
import  { NotFoundException} from '@zxing/library';
import { BarcodeFormat, BinaryBitmap, DecodeHintType, HybridBinarizer, MultiFormatReader, RGBLuminanceSource } from '@zxing/library';
import { onMounted, onUnmounted, ref, useTemplateRef } from 'vue';
import Loader from '@/components/icons/Loader.vue';
import { useNotificationStore } from '@/stores/useNotificationStore.ts';

const emit = defineEmits(['code-scanned']);

const notificationStore = useNotificationStore();

const videoRef = useTemplateRef('videoRef');
const errorMsg = ref('');
let animationFrameId: number | null = null;
const isLoading = ref(true);

const canvas = document.createElement('canvas');
const ctx = canvas.getContext('2d', { willReadFrequently: true });

const reader = new MultiFormatReader();
const readerHints = new Map();
readerHints.set(DecodeHintType.POSSIBLE_FORMATS, [BarcodeFormat.CODE_128]);
reader.setHints(readerHints);

let lastScanTime = 0;
const scanInterval = 200;

const scanFrame = (timestamp: number) => {
    const video = videoRef.value;

    if (!ctx || !video) {
        return;
    }

    if (timestamp - lastScanTime < scanInterval) {
        animationFrameId = requestAnimationFrame(scanFrame);

        return;
    }

    lastScanTime = timestamp;

    if (video && video.readyState === video.HAVE_ENOUGH_DATA) {
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;

        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

        const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
        const luminanceSource = new RGBLuminanceSource(imageData.data, canvas.width, canvas.height);
        const binaryBitmap = new BinaryBitmap(new HybridBinarizer(luminanceSource));

        try {
            const barcodeResult:Result = reader.decode(binaryBitmap);
            emit('code-scanned', barcodeResult.getText());

            return;
        } catch (err) {
            if (!(err instanceof NotFoundException)) {
                console.error('Ошибка декодирования: ', err);
                notificationStore.add('Произошла ошибка во время декодирования.', 'error', 5000);
            }
        }
    }

    animationFrameId = requestAnimationFrame(scanFrame);
};

onMounted(async () => {
    if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia || !videoRef.value) {
        errorMsg.value = 'Устройство для сканирования не найдено';
        isLoading.value = false;

        return;
    }

    try {
        videoRef.value.srcObject = await navigator.mediaDevices.getUserMedia({
            video: { facingMode: 'environment' }
        });
        await videoRef.value.play();
        isLoading.value = false;

        scanFrame(Date.now());
    } catch (err) {
        console.error(err);
        errorMsg.value = 'Нет доступа к камере';
        isLoading.value = false;
    }
})

onUnmounted(() => {
    if (animationFrameId) {
        cancelAnimationFrame(animationFrameId);
    }

    const srcObject = videoRef.value?.srcObject;

    if (srcObject instanceof MediaStream) {
        srcObject.getTracks().forEach(track => track.stop());
    }
})
</script>

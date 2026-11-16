<template>
    <div class="qr-code">
        <Loader v-if="isLoading" class="qr-code__loader"/>
        <template v-else>
            <button type="button" class="qr-code__print-btn" @click="printQR">
                Распечатать QR-код
            </button>
            <div class="qr-code__svg" v-html="qrCode"></div>
        </template>
    </div>
</template>

<script setup lang="ts">
import encodeQR from 'qr';
import { ref, watchEffect } from 'vue';
import Loader from '@/components/icons/Loader.vue';

interface Props {
    content: string;
}

const props = defineProps<Props>();

const qrCode = ref('');
const isLoading = ref(true);

watchEffect(() => {
    if (!props.content) {
        return;
    }

    isLoading.value = true;
    qrCode.value = encodeQR(props.content, 'svg');
    isLoading.value = false;
});

const printQR = () => {
    if (!qrCode.value) {
        return;
    }

    const iframe = document.createElement('iframe');
    iframe.style.position = 'fixed';
    iframe.style.right = '0';
    iframe.style.bottom = '0';
    iframe.style.width = '0';
    iframe.style.height = '0';
    iframe.style.border = 'none';

    iframe.srcdoc = `
        <!DOCTYPE html>
        <html lang="ru">
            <head>
                <title>Печать QR-кода</title>
                <style>
                    body {
                        margin: 0;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        min-height: 100vh;
                    }
                    svg {
                        width: 400px;
                        height: 400px;
                    }
                </style>
            </head>
            <body>
                ${qrCode.value}
            </body>
        </html>
    `;

    iframe.onload = () => {
        iframe.contentWindow?.focus();
        iframe.contentWindow?.print();

        setTimeout(() => {
            document.body.removeChild(iframe);
        }, 500);
    };

    document.body.appendChild(iframe);
};
</script>

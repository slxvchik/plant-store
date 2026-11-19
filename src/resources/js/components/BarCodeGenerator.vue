<template>
    <div class="barcode">
        <Loader v-if="isLoading" class="barcode__loader" />
        <template v-else>
            <button type="button" class="barcode__print-btn" @click="printBarcode">
                Распечатать баркод
            </button>
            <div class="barcode__svg" v-html="barcodeSvg" />
        </template>
    </div>
</template>

<script setup lang="ts">
import type { BitMatrix } from '@zxing/library';
import { MultiFormatWriter, BarcodeFormat } from '@zxing/library';
import { ref, watchEffect } from 'vue';
import Loader from '@/components/icons/Loader.vue';

interface Props {
    content: string;
}

const props = defineProps<Props>();

const barcodeSvg = ref('');
const isLoading = ref(true);
const multiFormatWriter = new MultiFormatWriter;
const hints = new Map();

watchEffect(() => {
    if (!props.content) {
        return;
    }

    isLoading.value = true;

    try {
        const svgNS = 'https://w3.org';
        const svgElement = document.createElementNS(svgNS, 'svg');

        const bitMatrix: BitMatrix = multiFormatWriter.encode(
            props.content,
            BarcodeFormat.CODE_128,
            500,
            50,
            hints,
        );
        const width = bitMatrix.getWidth();
        const height = bitMatrix.getHeight();

        svgElement.setAttribute('width', width.toString());
        svgElement.setAttribute('height', height.toString());
        svgElement.setAttribute('viewBox', `0 0 ${width} ${height}`);

        for (let y = 0; y < height; y++) {
            for (let x = 0; x < width; x++) {
                if (bitMatrix.get(x, y)) {
                    const rect = document.createElementNS(svgNS, 'rect');
                    rect.setAttribute('x', x.toString());
                    rect.setAttribute('y', y.toString());
                    rect.setAttribute('width', '1');
                    rect.setAttribute('height', '1');
                    rect.setAttribute('fill', '#000000');
                    svgElement.appendChild(rect);
                }
            }
        }

        barcodeSvg.value = svgElement.outerHTML;
    } catch (error) {
        console.error('Ошибка генерации штрихкода:', error);
        barcodeSvg.value = '';
    } finally {
        isLoading.value = false;
    }
});

const printBarcode = () => {
    if (!barcodeSvg.value) {
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
                <title>Печать штрихкода</title>
                <style>
                    body {
                        margin: 0;
                        display: flex;
                        justify-content: center;
                        align-items: flex-start;
                        min-height: 100vh;
                    }
                    svg {
                        max-width: 100%;
                        height: auto;
                    }
                </style>
            </head>
            <body>
                ${barcodeSvg.value}
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

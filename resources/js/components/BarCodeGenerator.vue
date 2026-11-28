<template>
    <div class="barcode">
        <Loader v-if="isLoading" class="barcode__loader" />
        <template v-else>
            <p v-if="error" style="color: red;">
                {{ error }}
            </p>
            <template v-else>
                <button type="button" class="barcode__print-btn" @click="printBarcode">
                    Распечатать баркод
                </button>
                <div class="barcode__svg" v-html="barcodeSvg" />
            </template>
        </template>
    </div>
</template>

<script setup lang="ts">
import JsBarcode from 'jsbarcode';
import { ref, watchEffect } from 'vue';
import Loader from '@/components/icons/Loader.vue';

interface Props {
    content: string;
}

const props = defineProps<Props>();

const barcodeSvg = ref('');
const isLoading = ref(true);
const error = ref('');

watchEffect(() => {
    if (!props.content) {
        return;
    }

    isLoading.value = true;

    try {
        const svgNS = 'http://w3.org';
        const svgElement = document.createElementNS(svgNS, 'svg');

        JsBarcode(svgElement, props.content, {
            format: 'CODE128',
            displayValue: true,
            margin: 0,
        });

        svgElement.setAttribute('width', '100%');

        barcodeSvg.value = svgElement.outerHTML;
    } catch (err) {
        console.error('Ошибка генерации штрихкода:', err);
        error.value = 'Ошибка генерации штрихкода';
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

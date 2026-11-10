<template>
    <section class="bg-bg-base px-4 py-16 md:px-8 md:py-24 dark:bg-bg-night">
        <Container>
            <div
                id="faq"
                class="grid scroll-mt-28 gap-8 lg:grid-cols-[0.75fr_1.25fr] lg:gap-20"
            >
                <Reveal>
                    <p
                        class="text-xs font-semibold tracking-[0.2em] text-accent uppercase"
                    >
                        Вопросы и ответы
                    </p>
                    <h2
                        class="mt-3 font-serif text-3xl leading-tight text-text-title md:text-4xl dark:text-linen"
                    >
                        Всё, что важно
                        <br />
                        знать до покупки
                    </h2>
                    <p
                        class="mt-4 text-sm leading-6 text-text-muted dark:text-white/50"
                    >
                        Не нашли ответ? Наши садоводы помогут разобраться.
                    </p>
                    <Link
                        class="group mt-5 flex min-h-11 w-fit items-center gap-2 text-sm font-semibold text-primary dark:text-secondary"
                        href="/contacts"
                    >
                        Задать вопрос
                        <span
                            class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1"
                        >
                            <AppIcon name="arrow" />
                        </span>
                    </Link>
                </Reveal>
                <Reveal :delay="120">
                    <AccordionItem
                        v-for="(item, index) in faq"
                        :key="item.question"
                        :is-open="openFaq === index"
                        :question="item.question"
                        @toggle="openFaq = openFaq === index ? null : index"
                    >
                        {{ item.answer }}
                    </AccordionItem>
                </Reveal>
            </div>
        </Container>
    </section>
</template>

<script lang="ts" setup>
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import AccordionItem from '@/components/AccordionItem.vue';
import AppIcon from '@/components/AppIcon.vue';
import Reveal from '@/components/Reveal.vue';
import Container from '@/components/Container.vue';

const openFaq = ref<number | null>(0);
const faq = [
    {
        question: 'Как вы упаковываете растения для доставки?',
        answer: 'Фиксируем грунт, защищаем листья мягким материалом и устанавливаем растение в устойчивый короб. В холодное время добавляем утепление, а перед отправкой присылаем фотографию именно вашего растения.',
    },
    {
        question: 'Что делать, если растение не прижилось?',
        answer: 'Напишите нам в течение 30 дней после получения. Садовод разберёт условия содержания, поможет скорректировать уход, а при подтверждении проблемы мы предложим замену или возврат средств.',
    },
    {
        question: 'Можно ли выбрать конкретный экземпляр?',
        answer: 'Да. Для большинства растений доступна услуга «Живой выбор»: мы отправим актуальные фотографии и видео доступных экземпляров, чтобы вы выбрали тот, который вам ближе.',
    },
    {
        question: 'Вы помогаете с пересадкой после доставки?',
        answer: 'Каждый заказ сопровождается памяткой. Также можно добавить набор для пересадки с подходящим грунтом и дренажом или заказать консультацию с нашим специалистом.',
    },
];
</script>

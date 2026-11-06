<template>
    <section class="bg-bg-base px-4 py-16 md:px-8 md:py-24 dark:bg-bg-night">
        <div class="mx-auto max-w-[1280px]">
            <Reveal class="text-center">
                <p
                    class="text-xs font-semibold tracking-[0.2em] text-accent uppercase"
                >
                    Зелень без хлопот
                </p>
                <h2
                    class="mt-3 font-serif text-3xl text-text-title md:text-4xl lg:text-5xl dark:text-linen"
                >
                    Выберите свой формат заботы
                </h2>
                <p
                    class="mx-auto mt-4 max-w-xl text-sm leading-6 text-text-muted md:text-base dark:text-white/50"
                >
                    От одной консультации до полного озеленения — понятные
                    условия и внимание к каждой детали.
                </p>
            </Reveal>
            <div class="mt-10 grid gap-4 md:mt-14 lg:grid-cols-3 lg:gap-6">
                <Reveal
                    v-for="(plan, index) in plans"
                    :key="plan.name"
                    :delay="index * 100"
                >
                    <article
                        class="relative flex h-full flex-col rounded-[28px] border p-6 transition-all duration-300 ease-in-out hover:-translate-y-1.5 hover:shadow-xl md:p-8"
                        :class="
                            plan.featured
                                ? 'border-primary bg-primary text-white shadow-lg shadow-primary/10'
                                : 'border-text-title/10 bg-bg-elevated dark:border-white/10 dark:bg-bg-night-soft'
                        "
                    >
                        <span
                            v-if="plan.featured"
                            class="absolute top-5 right-5 rounded-full bg-white/15 px-3 py-1 text-[10px] font-semibold tracking-wider uppercase"
                            >Популярно</span
                        >
                        <p
                            class="text-xs font-semibold tracking-[0.18em] uppercase"
                            :class="
                                plan.featured
                                    ? 'text-white/60'
                                    : 'text-primary dark:text-secondary'
                            "
                        >
                            {{ plan.eyebrow }}
                        </p>
                        <h3
                            class="mt-4 font-serif text-3xl"
                            :class="
                                plan.featured
                                    ? ''
                                    : 'text-text-title dark:text-linen'
                            "
                        >
                            {{ plan.name }}
                        </h3>
                        <p
                            class="mt-3 min-h-12 text-sm leading-6"
                            :class="
                                plan.featured
                                    ? 'text-white/65'
                                    : 'text-text-muted dark:text-white/50'
                            "
                        >
                            {{ plan.description }}
                        </p>
                        <div class="mt-7 flex items-end gap-2">
                            <span class="font-serif text-4xl">{{
                                plan.price
                            }}</span
                            ><span
                                class="pb-1 text-sm"
                                :class="
                                    plan.featured
                                        ? 'text-white/50'
                                        : 'text-text-muted dark:text-white/40'
                                "
                                >₽</span
                            >
                        </div>
                        <ul
                            class="mt-7 flex-1 space-y-3 border-t pt-6"
                            :class="
                                plan.featured
                                    ? 'border-white/15'
                                    : 'border-text-title/10 dark:border-white/10'
                            "
                        >
                            <li
                                v-for="feature in plan.features"
                                :key="feature"
                                class="flex gap-3 text-sm leading-6"
                                :class="
                                    plan.featured
                                        ? 'text-white/80'
                                        : 'text-text-muted dark:text-white/60'
                                "
                            >
                                <span
                                    class="mt-1 h-4 w-4 shrink-0"
                                    :class="
                                        plan.featured
                                            ? 'text-secondary'
                                            : 'text-primary dark:text-secondary'
                                    "
                                    ><AppIcon name="check" /></span
                                >{{ feature }}
                            </li>
                        </ul>
                        <Link
                            href="/contacts"
                            class="mt-8 flex min-h-12 items-center justify-center rounded-full text-sm font-semibold transition-all duration-300 hover:-translate-y-0.5"
                            :class="
                                plan.featured
                                    ? 'bg-white text-primary hover:bg-linen'
                                    : 'bg-sage-soft text-primary hover:bg-primary hover:text-white dark:bg-primary/25 dark:text-secondary dark:hover:bg-primary dark:hover:text-white'
                            "
                            >Выбрать формат</Link
                        >
                    </article>
                </Reveal>
            </div>

            <div
                id="faq"
                class="mt-20 grid scroll-mt-28 gap-8 md:mt-28 lg:grid-cols-[0.75fr_1.25fr] lg:gap-20"
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
                        Всё, что важно<br />знать до покупки
                    </h2>
                    <p
                        class="mt-4 text-sm leading-6 text-text-muted dark:text-white/50"
                    >
                        Не нашли ответ? Наши садоводы помогут разобраться.
                    </p>
                    <Link
                        href="/contacts"
                        class="group mt-5 flex min-h-11 w-fit items-center gap-2 text-sm font-semibold text-primary dark:text-secondary"
                        >Задать вопрос<span
                            class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1"
                            ><AppIcon name="arrow" /></span
                    ></Link>
                </Reveal>
                <Reveal :delay="120">
                    <div
                        class="border-t border-text-title/10 dark:border-white/10"
                    >
                        <AccordionItem
                            v-for="(item, index) in faq"
                            :key="item.question"
                            :question="item.question"
                            :is-open="openFaq === index"
                            @toggle="openFaq = openFaq === index ? null : index"
                            >{{ item.answer }}</AccordionItem
                        >
                    </div>
                </Reveal>
            </div>
        </div>
    </section>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import AccordionItem from '@/components/AccordionItem.vue';
import AppIcon from '@/components/AppIcon.vue';
import Reveal from '@/components/Reveal.vue';

const openFaq = ref<number | null>(0);
const plans = [
    {
        eyebrow: 'Для первого растения',
        name: 'Лёгкий старт',
        description:
            'Поможем выбрать здоровое растение и освоить базовый уход.',
        price: '990',
        features: [
            'Онлайн-консультация, 30 минут',
            'Индивидуальная памятка по уходу',
            'Подбор грунта и кашпо',
        ],
        featured: false,
    },
    {
        eyebrow: 'Для вашего интерьера',
        name: 'Зелёный дом',
        description:
            'Создадим гармоничную коллекцию с учётом света и стиля дома.',
        price: '3 900',
        features: [
            'Выезд или видеоконсультация',
            'Подбор до 7 растений',
            'План размещения и ухода',
            'Поддержка в течение месяца',
        ],
        featured: true,
    },
    {
        eyebrow: 'Для участка и террасы',
        name: 'Сад под ключ',
        description: 'Продуманное озеленение от первого эскиза до посадки.',
        price: 'от 12 900',
        features: [
            'Замеры и концепция',
            'Авторский подбор растений',
            'Доставка и посадка',
            'Сезонный план ухода',
        ],
        featured: false,
    },
];
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

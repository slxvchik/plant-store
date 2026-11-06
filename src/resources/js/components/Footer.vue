<template>
    <footer class="bg-bg-dark pb-24 text-white lg:pb-0">
        <div
            class="mx-auto max-w-[1440px] px-5 py-12 md:px-8 md:py-16 xl:px-12 xl:py-20"
        >
            <div
                class="grid gap-10 border-b border-white/10 pb-10 md:grid-cols-2 lg:grid-cols-[1.4fr_0.7fr_0.7fr_1fr] lg:gap-12 lg:pb-14"
            >
                <div>
                    <Link href="/" class="flex w-fit items-center gap-3">
                        <span class="h-10 w-10 text-secondary"
                            ><LogoIcon
                        /></span>
                        <span class="font-serif text-2xl font-semibold"
                            >деулино
                            <span class="font-normal text-secondary italic"
                                >garden</span
                            ></span
                        >
                    </Link>
                    <p
                        class="mt-5 max-w-sm text-sm leading-7 text-white/55 md:text-base"
                    >
                        Выращиваем растения с характером и помогаем им полюбить
                        ваш дом. Из нашего питомника — с заботой о каждом листе.
                    </p>
                    <div
                        class="mt-6 flex items-center gap-2 text-sm text-secondary"
                    >
                        <span class="h-4 w-4"><AppIcon name="leaf" /></span
                        >Питомник полного цикла · с 2012 года
                    </div>
                </div>
                <div>
                    <h2
                        class="text-xs font-semibold tracking-[0.18em] text-secondary uppercase"
                    >
                        Покупателям
                    </h2>
                    <nav class="mt-5 flex flex-col items-start gap-1">
                        <Link
                            v-for="link in buyerLinks"
                            :key="link.label"
                            :href="link.href"
                            class="flex min-h-9 items-center text-sm text-white/60 transition-all duration-300 hover:translate-x-1 hover:text-white"
                            >{{ link.label }}</Link
                        >
                    </nav>
                </div>
                <div>
                    <h2
                        class="text-xs font-semibold tracking-[0.18em] text-secondary uppercase"
                    >
                        Питомник
                    </h2>
                    <nav class="mt-5 flex flex-col items-start gap-1">
                        <Link
                            v-for="link in aboutLinks"
                            :key="link.label"
                            :href="link.href"
                            class="flex min-h-9 items-center text-sm text-white/60 transition-all duration-300 hover:translate-x-1 hover:text-white"
                            >{{ link.label }}</Link
                        >
                    </nav>
                </div>
                <div>
                    <h2
                        class="text-xs font-semibold tracking-[0.18em] text-secondary uppercase"
                    >
                        Будем на связи
                    </h2>
                    <a
                        href="tel:+74951284567"
                        class="mt-5 flex min-h-11 w-fit items-center gap-3 text-lg transition-colors duration-300 hover:text-secondary"
                        ><span class="h-5 w-5"><AppIcon name="phone" /></span>+7
                        (495) 128-45-67</a
                    >
                    <a
                        href="mailto:hello@deulino.garden"
                        class="flex min-h-11 w-fit items-center gap-3 text-sm text-white/60 transition-colors duration-300 hover:text-white"
                        ><span class="h-5 w-5"><AppIcon name="mail" /></span
                        >hello@deulino.garden</a
                    >
                    <p class="mt-4 text-sm leading-6 text-white/45">
                        Ежедневно, 09:00–20:00<br />Московская область, Рузский
                        район
                    </p>
                </div>
            </div>
            <div
                class="flex flex-col gap-3 pt-6 text-xs text-white/35 md:flex-row md:items-center md:justify-between"
            >
                <p>© 2026 Питомник растений «Деулино Сад»</p>
                <div class="flex flex-wrap gap-x-5 gap-y-2">
                    <a href="#" class="transition-colors hover:text-white"
                        >Политика конфиденциальности</a
                    ><a href="#" class="transition-colors hover:text-white"
                        >Публичная оферта</a
                    >
                </div>
            </div>
        </div>
    </footer>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import AppIcon from '@/components/AppIcon.vue';
import LogoIcon from '@/components/icons/LogoIcon.vue';

const buyerLinks = [
    { label: 'Каталог растений', href: '/catalog' },
    { label: 'Доставка и оплата', href: '/#delivery' },
    { label: 'Гарантия на растения', href: '/#delivery' },
    { label: 'Вопросы и ответы', href: '/#faq' },
];
const aboutLinks = [
    { label: 'Наша миссия', href: '/#mission' },
    { label: 'Садовый журнал', href: '/#journal' },
    { label: 'Контакты', href: '/contacts' },
    { label: 'Личный кабинет', href: '/profile' },
];
</script>

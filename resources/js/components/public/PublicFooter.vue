<template>
    <footer class="public-footer">
        <Container>
            <div class="public-footer__grid">
                <div>
                    <Link class="public-footer__brand" href="/">
                        <span class="public-footer__logo"><LogoIcon /></span>
                        <span class="public-footer__brand-name">
                            Деулино
                            <span class="public-footer__brand-accent">Сад</span>
                        </span>
                    </Link>
                    <p class="public-footer__description">
                        Выращиваем растения с характером и помогаем им полюбить
                        ваш дом. Из нашего питомника — с заботой о каждом листе.
                    </p>
                    <div class="public-footer__since">
                        <span class="public-footer__since-icon">
                            <Icon name="leaf" />
                        </span>
                        Питомник полного цикла · с 2012 года
                    </div>
                </div>
                <div>
                    <h2 class="public-footer__heading">Покупателям</h2>
                    <nav class="public-footer__nav">
                        <Link
                            v-for="link in buyerLinks"
                            :key="link.label"
                            :href="link.href"
                            class="public-footer__nav-link"
                        >
                            {{ link.label }}
                        </Link>
                    </nav>
                </div>
                <div>
                    <h2 class="public-footer__heading">Питомник</h2>
                    <nav class="public-footer__nav">
                        <Link
                            v-for="link in aboutLinks"
                            :key="link.label"
                            :href="link.href"
                            class="public-footer__nav-link"
                        >
                            {{ link.label }}
                        </Link>
                    </nav>
                </div>
                <div>
                    <h2 class="public-footer__heading">Будем на связи</h2>
                    <a class="public-footer__phone" href="tel:+74951284567">
                        <Icon name="phone" />
                        +7 (495) 128-45-67
                    </a>
                    <a
                        class="public-footer__email"
                        href="mailto:hello@deulino.garden"
                    >
                        <Icon name="mail" />
                        hello@deulino.garden
                    </a>
                    <p class="public-footer__schedule">
                        Ежедневно, 09:00–20:00
                        <br />
                        Московская область, Рузский район
                    </p>
                </div>
            </div>
            <span class="public-footer__developer">Developed by @slxvchik</span>
            <span class="public-footer__divider" />
            <div class="public-footer__bottom">
                <p>© 2026 Питомник растений «Деулино Сад»</p>
                <div class="public-footer__legal">
                    <a class="public-footer__legal-link" href="#">
                        Политика конфиденциальности
                    </a>
                    <a class="public-footer__legal-link" href="#">
                        Публичная оферта
                    </a>
                </div>
            </div>
        </Container>
    </footer>
</template>

<script lang="ts" setup>
import Container from '@/components/Container.vue';
import Icon from '@/components/icons/Icon.vue';
import LogoIcon from '@/components/icons/LogoIcon.vue';
import Link from '@/components/Link.vue';

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

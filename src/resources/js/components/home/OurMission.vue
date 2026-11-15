<template>
    <section id="mission" class="our-mission">
        <Container>
            <div class="our-mission__grid">
                <Reveal direction="right">
                    <div class="our-mission__visual">
                        <div class="our-mission__image-wrap">
                            <img
                                alt="Цветущее растение в оранжерее Деулино"
                                class="our-mission__image"
                                loading="lazy"
                                src="/images/water_lily.png"
                            />
                        </div>
                        <div class="our-mission__stat">
                            <p class="our-mission__stat-value">2 400+</p>
                            <p class="our-mission__stat-label">
                                растений обрели дом в этом году
                            </p>
                        </div>
                    </div>
                </Reveal>
                <Reveal :delay="100" direction="left">
                    <p class="our-mission__eyebrow">Наша миссия</p>
                    <h2 class="our-mission__title">
                        Помогаем людям
                        <br />
                        и растениям
                        <em class="our-mission__title-accent">расти вместе</em>
                    </h2>
                    <p class="our-mission__description">
                        Мы верим, что забота о живом начинается с внимания.
                        Поэтому знаем историю каждого растения и говорим честно
                        об уходе, условиях и возможных сложностях.
                    </p>
                    <ul class="our-mission__principles">
                        <li
                            v-for="(item, index) in principles"
                            :key="item.title"
                            class="our-mission__principle"
                        >
                            <span class="our-mission__principle-number">
                                0{{ index + 1 }}
                            </span>
                            <div>
                                <h3 class="our-mission__principle-title">
                                    {{ item.title }}
                                </h3>
                                <p class="our-mission__principle-text">
                                    {{ item.text }}
                                </p>
                            </div>
                        </li>
                    </ul>
                </Reveal>
            </div>
        </Container>
    </section>
</template>
<script lang="ts" setup>
import Container from '@/components/Container.vue';
import Reveal from '@/components/Reveal.vue';

const principles = [
    {
        title: 'Живые растения, а не конвейер',
        text: 'Выращиваем в собственных оранжереях и отбираем каждый экземпляр вручную.',
    },
    {
        title: 'Экологичность без громких обещаний',
        text: 'Используем возобновляемую энергию, биологическую защиту и перерабатываемую упаковку.',
    },
    {
        title: 'Поддержка на каждом этапе',
        text: 'Делимся знаниями и остаёмся на связи после того, как растение переехало к вам.',
    },
];
</script>

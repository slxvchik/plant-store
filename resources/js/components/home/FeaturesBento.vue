<template>
    <section id="delivery" class="features-bento">
        <Container>
            <Reveal>
                <div class="features-bento__header">
                    <p class="features-bento__eyebrow">Больше, чем доставка</p>
                    <h2 class="features-bento__title">
                        Забота продолжается
                        <br />
                        и после покупки
                    </h2>
                </div>
            </Reveal>
            <div class="features-bento__grid">
                <Reveal class="features-bento__feature">
                    <article class="features-bento__feature-card">
                        <img
                            alt="Садовод заботится о растениях"
                            class="features-bento__feature-image"
                            loading="lazy"
                            src="/images/slide_1.avif"
                        />
                        <div class="features-bento__feature-overlay" />
                        <div class="features-bento__feature-copy">
                            <span class="features-bento__feature-icon">
                                <span class="features-bento__icon">
                                    <Icon name="leaf" />
                                </span>
                            </span>
                            <h3 class="features-bento__feature-title">
                                Подбор с пониманием
                            </h3>
                            <p class="features-bento__feature-text">
                                Учтём освещение, влажность и ваш ритм жизни. Не
                                просто продадим растение — поможем найти именно
                                ваше.
                            </p>
                        </div>
                    </article>
                </Reveal>
                <Reveal :delay="100" class="features-bento__delivery">
                    <article class="features-bento__delivery-card">
                        <span class="features-bento__delivery-icon">
                            <span class="features-bento__icon">
                                <Icon name="truck" />
                            </span>
                        </span>
                        <div class="features-bento__delivery-copy">
                            <p class="features-bento__delivery-title">
                                Бережная доставка
                            </p>
                            <p class="features-bento__delivery-text">
                                Отправляем по всей Московской области.
                            </p>
                        </div>
                    </article>
                </Reveal>
                <Reveal :delay="180" class="features-bento__trust">
                    <article class="features-bento__trust-card">
                        <span class="features-bento__trust-label">
                            Нам доверяют
                        </span>
                        <div>
                            <p class="features-bento__trust-value">
                                12
                                <span>+</span>
                            </p>
                            <p class="features-bento__trust-text">
                                лет выращиваем
                                <br />
                                с любовью
                            </p>
                        </div>
                    </article>
                </Reveal>
                <Reveal :delay="240" class="features-bento__guarantee">
                    <article class="features-bento__guarantee-card">
                        <span class="features-bento__guarantee-icon">
                            <span class="features-bento__icon">
                                <Icon name="shield" />
                            </span>
                        </span>
                        <div>
                            <p class="features-bento__guarantee-title">
                                30 дней гарантии
                            </p>
                            <p class="features-bento__guarantee-text">
                                Остаёмся на связи.
                            </p>
                        </div>
                    </article>
                </Reveal>
            </div>
        </Container>
    </section>
</template>
<script lang="ts" setup>
import Container from '@/components/Container.vue';
import Icon from '@/components/icons/Icon.vue';
import Reveal from '@/components/Reveal.vue';
</script>

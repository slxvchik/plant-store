<template>
    <div class="contacts">
        <section class="contacts__section">
            <Container>
                <nav aria-label="Хлебные крошки" class="contacts__breadcrumbs">
                    <Link class="contacts__breadcrumb-link" href="/">
                        Главная
                    </Link>
                    <span>/</span>
                    <span class="contacts__breadcrumb-current">Контакты</span>
                </nav>

                <Reveal>
                    <div class="contacts__intro">
                        <p class="contacts__eyebrow">Всегда рады помочь</p>
                        <h1 class="contacts__title">
                            Давайте вырастим
                            <br />
                            <em class="contacts__title-accent">
                                что-то прекрасное
                            </em>
                        </h1>
                        <p class="contacts__description">
                            Подберём растение, ответим о доставке или поможем
                            разобраться в уходе. Напишите нам — отвечает живой
                            человек, а не бот.
                        </p>
                    </div>
                </Reveal>

                <div class="contacts__grid">
                    <Reveal direction="right">
                        <div class="contacts__info-card">
                            <div class="contacts__image-wrap">
                                <img
                                    alt="Оранжерея питомника Деулино Сад"
                                    class="contacts__image"
                                    src="/images/slide_2.avif"
                                />
                                <div class="contacts__image-overlay" />
                                <div class="contacts__image-caption">
                                    <p class="contacts__image-title">
                                        Приезжайте в гости
                                    </p>
                                    <p class="contacts__image-text">
                                        Оранжерея открыта для посещения по
                                        записи
                                    </p>
                                </div>
                            </div>
                            <div class="contacts__details">
                                <a
                                    class="contacts__contact"
                                    href="tel:+74951284567"
                                >
                                    <span class="contacts__contact-icon">
                                        <Icon name="phone" />
                                    </span>
                                    <span>
                                        <span class="contacts__contact-label">
                                            Позвонить
                                        </span>
                                        <span class="contacts__contact-value">
                                            +7 (495) 128-45-67
                                        </span>
                                    </span>
                                </a>
                                <a
                                    class="contacts__contact"
                                    href="mailto:hello@deulino.garden"
                                >
                                    <span class="contacts__contact-icon">
                                        <Icon name="mail" />
                                    </span>
                                    <span>
                                        <span class="contacts__contact-label">
                                            Написать
                                        </span>
                                        <span
                                            class="contacts__contact-value contacts__contact-value--email"
                                        >
                                            hello@deulino.garden
                                        </span>
                                    </span>
                                </a>
                                <div class="contacts__contact">
                                    <span class="contacts__contact-icon">
                                        <Icon name="pin" />
                                    </span>
                                    <div>
                                        <p class="contacts__contact-label">
                                            Питомник
                                        </p>
                                        <p
                                            class="contacts__contact-value contacts__contact-value--address"
                                        >
                                            Московская область, Рузский район,
                                            <br />
                                            деревня Деулино
                                        </p>
                                    </div>
                                </div>
                                <div class="contacts__contact">
                                    <span class="contacts__contact-icon">
                                        <Icon name="clock" />
                                    </span>
                                    <div>
                                        <p class="contacts__contact-label">
                                            Время работы
                                        </p>
                                        <p class="contacts__contact-value">
                                            Ежедневно, 09:00–20:00
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </Reveal>

                    <Reveal :delay="100" direction="left">
                        <form
                            class="contacts__form"
                            novalidate
                            @submit.prevent="submitForm"
                        >
                            <p class="contacts__form-eyebrow">Форма связи</p>
                            <h2 class="contacts__form-title">
                                Расскажите, чем помочь
                            </h2>
                            <p class="contacts__form-description">
                                Ответим в течение двух рабочих часов.
                            </p>
                            <div class="contacts__fields">
                                <Input
                                    id="contact-name"
                                    v-model="form.fio"
                                    :error="clientErrors.fio || form.errors.fio"
                                    autocomplete="name"
                                    label="Ваше имя *"
                                    variant="floating"
                                />
                                <div class="contacts__field-row">
                                    <Input
                                        id="contact-phone"
                                        v-model="form.phone"
                                        :error="
                                            clientErrors.phone ||
                                            form.errors.phone
                                        "
                                        autocomplete="tel"
                                        label="Телефон *"
                                        type="tel"
                                        variant="floating"
                                    />
                                    <Input
                                        id="contact-email"
                                        v-model="form.email"
                                        :error="
                                            clientErrors.email ||
                                            form.errors.email
                                        "
                                        autocomplete="email"
                                        label="Электронная почта"
                                        type="email"
                                        variant="floating"
                                    />
                                </div>
                                <Textarea
                                    id="contact-message"
                                    v-model="form.comment"
                                    :error="
                                        clientErrors.comment ||
                                        form.errors.comment
                                    "
                                    label="Ваш вопрос *"
                                    variant="floating"
                                />
                            </div>
                            <Button
                                :disabled="form.processing"
                                class="contacts__submit"
                                type="submit"
                            >
                                {{
                                    form.processing
                                        ? 'Отправляем…'
                                        : 'Отправить сообщение'
                                }}
                                <span
                                    v-if="form.processing"
                                    class="contacts__spinner"
                                />
                                <span v-else class="contacts__submit-icon">
                                    <Icon name="arrow" />
                                </span>
                            </Button>
                            <p class="contacts__policy">
                                Нажимая кнопку, вы соглашаетесь с политикой
                                обработки персональных данных.
                            </p>
                            <Transition name="contacts-success">
                                <div
                                    v-if="submitted"
                                    class="contacts__success"
                                    role="status"
                                >
                                    <span class="contacts__success-icon">
                                        <Icon name="check" />
                                    </span>
                                    Спасибо! Мы получили сообщение и скоро
                                    свяжемся с вами.
                                </div>
                            </Transition>
                        </form>
                    </Reveal>
                </div>
            </Container>
        </section>
    </div>
</template>

<script lang="ts" setup>
import { Link, useForm } from '@inertiajs/vue3';
import { reactive, ref } from 'vue';
import Button from '@/components/Button.vue';
import Container from '@/components/Container.vue';
import Icon from '@/components/icons/Icon.vue';
import Input from '@/components/Input.vue';
import Reveal from '@/components/Reveal.vue';
import Textarea from '@/components/Textarea.vue';
import AppLayout from '@/layouts/AppLayout.vue';

defineOptions({ layout: AppLayout });
const form = useForm({ fio: '', phone: '', email: '', comment: '' });
const clientErrors = reactive<Record<string, string>>({});
const submitted = ref(false);

const validate = (): boolean => {
    Object.keys(clientErrors).forEach((key) => delete clientErrors[key]);

    if (form.fio.trim().length < 2) {
        clientErrors.fio = 'Укажите имя — минимум 2 символа.';
    }

    if (form.phone.replace(/\D/g, '').length < 10) {
        clientErrors.phone = 'Введите телефон с кодом города или оператора.';
    }

    if (form.email && !/^\S+@\S+\.\S+$/.test(form.email)) {
        clientErrors.email = 'Проверьте адрес электронной почты.';
    }

    if (form.comment.trim().length < 10) {
        clientErrors.comment =
            'Опишите вопрос чуть подробнее — минимум 10 символов.';
    }

    return Object.keys(clientErrors).length === 0;
};

const submitForm = (): void => {
    submitted.value = false;

    if (!validate()) {
        return;
    }

    form.post('/callback', {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            submitted.value = true;
        },
    });
};
</script>

<style lang="scss" scoped>
.contacts-success-enter-active {
    @apply transition-all duration-300;
}
.contacts-success-enter-from {
    @apply translate-y-2 opacity-0;
}
.contacts-success-enter-to {
    @apply translate-y-0 opacity-100;
}
.contacts-success-leave-active {
    @apply transition-all duration-200;
}
.contacts-success-leave-to {
    @apply opacity-0;
}
</style>

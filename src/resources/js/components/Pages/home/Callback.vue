<template>
    <section class="bg-bg-2 px-3 py-8 lg:px-20 lg:py-25">
        <div
            class="w-full overflow-hidden rounded-t-xl rounded-tr-4xl rounded-b-xl rounded-bl-4xl"
        >
            <img
                src="/images/water-lily.png"
                alt="Лилия"
                title="Лилия"
                class="h-auto w-full"
            />
        </div>
        <form class="mt-6">
            <h2>Персональная консультация</h2>
            <p>Заголовок</p>
            <Input
                id="callback_fio"
                type="text"
                placeholder="Иван Иванов"
                label="ФИО"
            />
            <Input
                id="callback_email"
                type="email"
                placeholder="example@mail.ru"
                label="Почта"
            />
            <Input
                id="callback_phone"
                type="text"
                placeholder="+7 999 999-99-99"
                label="Телефон"
                error="test"
            />
        </form>
    </section>
</template>

<script setup lang="ts">
import Input from '@/components/Input.vue';
</script>

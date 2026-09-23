<template>
    <section
        class="bg-bg-surface px-3 py-8 md:px-8 md:py-20 xl:px-20 xl:py-25 xl:flex xl:mb-12 xl:flex-row xl:justify-between">
        <div
            class="w-full h-45 overflow-hidden rounded-tl-2xl rounded-tr-[64px] rounded-br-2xl rounded-bl-[64px] md:h-80 md:rounded-tl-3xl md:rounded-tr-[100px] md:rounded-br-3xl md:rounded-bl-[100px] xl:h-125 xl:w-[48%] xl:rounded-tl-4xl xl:rounded-tr-[140px] xl:rounded-br-4xl xl:rounded-bl-[140px]">
            <img src="/images/water-lily.png" alt="Лилия" title="Лилия" class="w-full h-full object-cover" />
        </div>
        <form class="w-full mt-6 xl:w-[48%]">
            <div class="mb-4 xl:mb-6">
                <h2 class="text font-serif font-bold text-accent uppercase mb-2">Персональная консультация</h2>
                <p class="font-sans text-text-muted text-xs md:text-base xl:text-lg">Подскажем по наличию сортов, ценам и
                    доставке.</p>
            </div>
            <Input id="callback_fio" type="text" placeholder="Иван Иванов" label="ФИО" class="mb-2.5" />
            <div class="flex flex-col gap-2.5 mb-4 md:flex-row xl:mb-6">
                <Input id="callback_email" type="email" placeholder="example@mail.ru" label="Почта" />
                <Input id="callback_phone" type="text" placeholder="+7 999 999-99-99" label="Телефон" error="test" />
            </div>
            <div class="flex flex-col gap-2.5 xl:flex-row xl:gap-4 xl:items-center">
                <div>
                    <Button text="Запросить звонок" class="h-11.5" />
                </div>
                <p class="font-sans text-text-muted text-xs md:text-base xl:text-lg">Наш специалист перезвонит вам в течении
                    двух рабочих часов</p>
            </div>
        </form>
    </section>
</template>

<script setup lang="ts">
import Button from '@/components/Button.vue';
import Input from '@/components/Input.vue';
</script>

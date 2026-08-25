<template>
    <section class="bg-bg-3 px-3 py-8 md:px-8 md:py-20 xl:px-20 xl:py-30 xl:flex xl:flex-row">
        <div class="xl:w-[65%]">
            <h2 class="text font-serif font-bold text-accent uppercase">
                Наша миссия
            </h2>
            <p
                class="mt-3 font-sans text-4xl leading-[1.1] font-light whitespace-pre-line text-white sm:text-5xl lg:text-6xl">
                Забота о пространстве для людей, по листочку за раз
            </p>
            <p class="mt-3 font-sans text-white sm:text-lg">
                Наша история началась у чистых, спокойных вод.
            </p>
            <ul class="flex flex-col mb-6 mt-4 gap-2">
                <li v-for="text in [
                    '100 % органическое выращивание без синтетических средств борьбы с вредителями.',
                    'Выращивается на месте в теплицах, работающих на возобновляемых источниках энергии.',
                    'За каждое купленное растение мы высаживаем семена местных полевых цветов.',
                ]" class="flex flex-row gap-2.5">
                    <svg width="14" height="11" viewBox="0 0 14 11" fill="none" xmlns="http://www.w3.org/2000/svg"
                        class="text-accent h-4.5 w-4.5">
                        <path d="M12.9988 1L4.74963 9.2494L1 5.49967" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" />
                    </svg>
                    <p class="text-white">{{ text }}</p>
                </li>
            </ul>
        </div>
        <div class="w-full overflow-hidden rounded-xl xl:w-[30%]">
            <img src="/images/water_lily.png" alt="Лилия" class="w-full h-full object-cover">
        </div>
    </section>
</template>

<script setup lang="ts">
</script>
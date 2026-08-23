<template>
    <!-- Product card -->
    <a
        href="#"
        class="group flex h-fit w-full cursor-pointer flex-col overflow-hidden rounded-xl bg-white"
    >
        <div class="relative overflow-hidden">
            <img
                alt="Monstera Deliciosa"
                title="Monstera Deliciosa"
                class="h-56 w-full object-cover transition-transform duration-500 group-hover:scale-105"
                src="https://images.unsplash.com/photo-1493552152660-f915ab47ae9d?w=400&amp;h=460&amp;fit=crop&amp;auto=format"
            />
            <span
                class="absolute top-3 left-3 cursor-default rounded-full bg-amber-100 px-2.5 py-1 font-sans text-[10px] font-semibold text-amber-800"
            >
                Тег
            </span>
            <button
                @click.prevent
                class="absolute top-3 right-3 flex h-8 w-8 translate-y-1 cursor-pointer items-center justify-center rounded-full bg-white/90 text-main opacity-0 shadow-sm transition-all duration-300 group-hover:translate-y-0 group-hover:opacity-100 hover:bg-white"
                aria-label="Добавить в избранное"
            >
                <HeartIcon class="h-4 w-4" />
            </button>
        </div>
        <div class="flex flex-1 flex-col p-5">
            <p
                class="mb-1 font-sans text-xs font-medium tracking-wide text-gray-400 uppercase"
            >
                Категория
            </p>
            <h3
                class="mb-2 font-sans text-lg leading-snug font-medium text-main"
            >
                Monstera Deliciosa
            </h3>
            <div class="mb-4 flex items-center gap-2">
                <div class="flex gap-0.5">
                    <StarIcon
                        v-for="n in 5"
                        :key="n"
                        class="h-3.5 w-3.5"
                        :class="n === 5 ? 'text-gray-300' : 'text-bright'"
                    />
                </div>
                <span class="text-xs text-gray-400">4.9 (214)</span>
            </div>
            <div class="mt-auto flex items-center justify-between">
                <span class="text-xl font-semibold break-all text-main">
                    38 ₽
                </span>
                <button
                    @click.prevent
                    aria-label="В корзину"
                    class="flex min-w-24 cursor-pointer items-center justify-center gap-1.5 rounded-full bg-btn-light-bg px-4 py-2 text-sm font-medium text-white transition-colors duration-200 hover:bg-btn-light-bg-hover"
                >
                    В корзину
                </button>
            </div>
        </div>
    </a>
    <!-- !Product card -->
</template>

<script setup lang="ts">
import HeartIcon from '@/components/icons/HeartIcon.vue';
import StarIcon from '@/components/icons/StarIcon.vue';
</script>

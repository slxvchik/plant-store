<template>
    <Teleport to="body">
        <Transition
            enter-active-class="transition-opacity duration-300"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition-opacity duration-300"
            leave-to-class="opacity-0"
        >
            <div
                v-if="isCartOpen"
                aria-hidden="true"
                class="fixed inset-0 z-[70] bg-bg-dark/45 backdrop-blur-[2px]"
                @click="isCartOpen = false"
            />
        </Transition>
        <Transition
            enter-active-class="transform-gpu transition-transform duration-500 ease-out"
            enter-from-class="translate-x-full"
            enter-to-class="translate-x-0"
            leave-active-class="transform-gpu transition-transform duration-300 ease-in"
            leave-to-class="translate-x-full"
        >
            <aside
                v-if="isCartOpen"
                aria-label="Корзина"
                aria-modal="true"
                class="fixed inset-y-0 right-0 z-[80] flex h-dvh w-full max-w-md flex-col bg-bg-elevated shadow-2xl dark:bg-bg-night-soft"
                role="dialog"
            >
                <div
                    class="flex items-center justify-between border-b border-text-title/10 px-5 py-5 md:px-7 dark:border-white/10"
                >
                    <div>
                        <p
                            class="text-xs font-semibold tracking-[0.18em] text-primary uppercase dark:text-secondary"
                        >
                            Ваш выбор
                        </p>
                        <h2
                            class="mt-1 font-serif text-3xl text-text-title dark:text-linen"
                        >
                            Корзина
                        </h2>
                    </div>
                    <button
                        aria-label="Закрыть корзину"
                        class="flex h-11 w-11 cursor-pointer items-center justify-center rounded-full bg-bg-surface text-text-title transition-all duration-300 hover:rotate-90 hover:bg-sage-soft dark:bg-white/5 dark:text-white dark:hover:bg-white/10"
                        type="button"
                        @click="isCartOpen = false"
                    >
                        <span class="h-5 w-5"><AppIcon name="close" /></span>
                    </button>
                </div>

                <div
                    v-if="items.length"
                    class="flex-1 space-y-5 overflow-y-auto px-5 py-6 md:px-7"
                >
                    <article
                        v-for="item in items"
                        :key="item.id"
                        class="flex gap-4 border-b border-text-title/10 pb-5 dark:border-white/10"
                    >
                        <img
                            :alt="item.name"
                            :src="item.image"
                            class="h-24 w-20 shrink-0 rounded-2xl object-cover"
                        />
                        <div class="flex min-w-0 flex-1 flex-col">
                            <h3
                                class="font-serif text-lg leading-tight text-text-title dark:text-linen"
                            >
                                {{ item.name }}
                            </h3>
                            <p
                                class="mt-1 text-sm text-text-muted dark:text-white/50"
                            >
                                Взрослое растение · в кашпо
                            </p>
                            <div
                                class="mt-auto flex items-end justify-between gap-3 pt-3"
                            >
                                <div
                                    class="flex h-10 items-center rounded-full border border-text-title/10 dark:border-white/15"
                                >
                                    <button
                                        :aria-label="`Уменьшить количество: ${item.name}`"
                                        class="flex h-10 w-10 cursor-pointer items-center justify-center text-text-muted transition-all duration-300 hover:text-primary dark:text-white/60"
                                        type="button"
                                        @click="updateQuantity(item.id, -1)"
                                    >
                                        <span class="h-4 w-4">
                                            <AppIcon name="minus" />
                                        </span>
                                    </button>
                                    <span
                                        class="w-6 text-center text-sm font-semibold text-text-title dark:text-white"
                                    >
                                        {{ item.quantity }}
                                    </span>
                                    <button
                                        :aria-label="`Увеличить количество: ${item.name}`"
                                        class="flex h-10 w-10 cursor-pointer items-center justify-center text-text-muted transition-all duration-300 hover:text-primary dark:text-white/60"
                                        type="button"
                                        @click="updateQuantity(item.id, 1)"
                                    >
                                        <span class="h-4 w-4">
                                            <AppIcon name="plus" />
                                        </span>
                                    </button>
                                </div>
                                <p
                                    class="font-semibold whitespace-nowrap text-text-title dark:text-linen"
                                >
                                    {{
                                        formatPrice(item.price * item.quantity)
                                    }}
                                </p>
                            </div>
                        </div>
                    </article>
                </div>
                <div
                    v-else
                    class="flex flex-1 flex-col items-center justify-center px-8 text-center"
                >
                    <span
                        class="flex h-20 w-20 items-center justify-center rounded-full bg-sage-soft text-primary dark:bg-primary/25 dark:text-secondary"
                    >
                        <span class="h-9 w-9"><AppIcon name="leaf" /></span>
                    </span>
                    <h3
                        class="mt-6 font-serif text-2xl text-text-title dark:text-linen"
                    >
                        Здесь пока тихо
                    </h3>
                    <p
                        class="mt-2 leading-6 text-text-muted dark:text-white/55"
                    >
                        Добавьте растение, и мы бережно подготовим его к
                        отправке.
                    </p>
                    <Link
                        class="mt-6 flex min-h-11 items-center rounded-full bg-primary px-6 text-sm font-semibold text-white transition-all duration-300 hover:bg-primary-hover"
                        href="/catalog"
                        @click="isCartOpen = false"
                    >
                        Выбрать растение
                    </Link>
                </div>

                <div
                    v-if="items.length"
                    class="border-t border-text-title/10 bg-bg-base px-5 py-5 pb-[max(1.25rem,env(safe-area-inset-bottom))] md:px-7 dark:border-white/10 dark:bg-bg-night"
                >
                    <div class="mb-4 flex items-center justify-between">
                        <span class="text-text-muted dark:text-white/55">
                            Итого
                        </span>
                        <span
                            class="font-serif text-2xl font-semibold text-text-title dark:text-linen"
                        >
                            {{ formatPrice(total) }}
                        </span>
                    </div>
                    <Link
                        class="flex min-h-13 w-full items-center justify-center rounded-full bg-primary px-6 font-semibold text-white shadow-lg shadow-primary/15 transition-all duration-300 hover:-translate-y-0.5 hover:bg-primary-hover"
                        href="/user/cart"
                        @click="isCartOpen = false"
                    >
                        Перейти к оформлению
                    </Link>
                    <p
                        class="mt-3 text-center text-xs text-text-muted dark:text-white/45"
                    >
                        Бесплатная доставка по России от 7 000 ₽
                    </p>
                </div>
            </aside>
        </Transition>
    </Teleport>
</template>

<script lang="ts" setup>
import { Link } from '@inertiajs/vue3';
import { onMounted, onUnmounted } from 'vue';
import AppIcon from '@/components/AppIcon.vue';
import { useBodyScrollLock } from '@/composables/useBodyScrollLock';
import { useCartDrawer } from '@/composables/useCartDrawer';

const { items, isCartOpen, total, updateQuantity, formatPrice } =
    useCartDrawer();
const closeOnEscape = (event: KeyboardEvent): void => {
    if (event.key === 'Escape') {
        isCartOpen.value = false;
    }
};

useBodyScrollLock(isCartOpen);
onMounted(() => window.addEventListener('keydown', closeOnEscape));
onUnmounted(() => window.removeEventListener('keydown', closeOnEscape));
</script>

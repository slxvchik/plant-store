<template>
    <div
        class="relative min-h-dvh w-full overflow-x-clip bg-bg-base text-text-title transition-colors duration-300 dark:bg-bg-night dark:text-linen"
    >
        <Header />
        <Transition
            mode="out-in"
            enter-active-class="transition-all duration-300 ease-out"
            enter-from-class="translate-y-2 opacity-0"
            enter-to-class="translate-y-0 opacity-100"
            leave-active-class="transition-all duration-150 ease-in"
            leave-to-class="opacity-0"
        >
            <main :key="page.url" class="min-h-[60vh] pb-20 lg:pb-0">
                <slot />
            </main>
        </Transition>
        <Footer />
        <MobileNavigation />
        <CartDrawer />
        <NotificationList />
        <Transition
            enter-active-class="transition-opacity duration-200"
            enter-from-class="opacity-0"
            leave-active-class="transition-opacity duration-300"
            leave-to-class="opacity-0"
        >
            <div
                v-if="isThemeTransitioning"
                class="pointer-events-none fixed inset-0 z-[100] bg-bg-base dark:bg-bg-night"
            />
        </Transition>
    </div>
</template>

<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import CartDrawer from '@/components/CartDrawer.vue';
import Footer from '@/components/Footer.vue';
import Header from '@/components/Header.vue';
import MobileNavigation from '@/components/MobileNavigation.vue';
import NotificationList from '@/components/NotificationList.vue';
import { useTheme } from '@/composables/useTheme';

const page = usePage();
const { isThemeTransitioning } = useTheme();
</script>

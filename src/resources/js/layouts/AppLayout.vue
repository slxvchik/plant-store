<template>
    <div class="app-layout">
        <PublicHeader />
        <Transition mode="out-in" name="app-layout-page">
            <main :key="page.url" class="app-layout__main">
                <slot />
            </main>
        </Transition>
        <PublicFooter />
        <MobileNavigation />
        <NotificationList />
    </div>
</template>

<script lang="ts" setup>
import { usePage } from '@inertiajs/vue3';
import NotificationList from '@/components/notification/NotificationList.vue';
import MobileNavigation from '@/components/public/MobileNavigation.vue';
import PublicFooter from '@/components/public/PublicFooter.vue';
import PublicHeader from '@/components/public/PublicHeader.vue';

const page = usePage();
</script>

<style lang="scss" scoped>
.app-layout-page-enter-active {
    @apply transition-all duration-300 ease-out;
}

.app-layout-page-leave-active {
    @apply transition-all duration-150 ease-in;
}

.app-layout-page-enter-from {
    @apply translate-y-2 opacity-0;
}

.app-layout-page-enter-to {
    @apply translate-y-0 opacity-100;
}

.app-layout-page-leave-to {
    @apply opacity-0;
}
</style>

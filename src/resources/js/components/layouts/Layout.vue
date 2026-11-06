<template>
    <div
        class="relative flex min-h-dvh w-full flex-col items-center bg-bg-base"
    >
        <Container>
            <Header />
            <main class="flex-1">
                <slot />
            </main>
            <Footer />
        </Container>
        <NotificationList />
    </div>
</template>

<script setup lang="ts">
import Container from '@/components/Container.vue';
import Footer from '@/components/Footer.vue';
import Header from '@/components/Header.vue';
import NotificationList from '@/components/NotificationList.vue';
</script>

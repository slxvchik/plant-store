<template>
    <header
        class="flex w-full items-center justify-center rounded-2xl border border-b-emerald-200 bg-emerald-100/40 backdrop-blur-md"
    >
        <div class="flex h-10 w-10 items-center justify-center bg-white">
            <img
                src="/icons/logo.jpg"
                alt="Деулино Сад"
                title="Деулино Сад"
                class="object-cover"
            />
        </div>
        <nav>
            <ul>
                <li>
                    <a href="/catalog">Каталог</a>
                </li>
                <li>
                    <a href="/blog">Блог</a>
                </li>
                <li>
                    <a href="/about">О компании</a>
                </li>
            </ul>
        </nav>
        <div>
            <a href="/cart">Корзина</a>
        </div>
    </header>
</template>

<script setup lang="ts"></script>

<style scoped></style>

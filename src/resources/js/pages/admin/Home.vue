<template>
    <div class="space-y-8">
        <div
            class="overflow-hidden rounded-3xl bg-slate-950 px-6 py-8 text-white shadow-xl sm:px-8 sm:py-10"
        >
            <p
                class="text-xs font-semibold tracking-[0.2em] text-emerald-400 uppercase"
            >
                Панель управления
            </p>
            <h1 class="mt-3 text-3xl font-semibold tracking-tight">
                Деулино Сад
            </h1>
            <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-300">
                Каталог, складские единицы, закупки и заказы — в едином рабочем
                пространстве.
            </p>
        </div>
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <a
                href="/admin/products"
                class="group rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:border-emerald-200 hover:shadow-lg"
            >
                <span
                    class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-lg font-semibold text-emerald-700"
                >
                    К
                </span>
                <h2
                    class="mt-5 font-semibold text-slate-900 group-hover:text-emerald-700"
                >
                    Каталог
                </h2>
                <p class="mt-2 text-sm leading-6 text-slate-500">
                    Товары, категории и торговые предложения.
                </p>
                <p class="mt-5 text-xs font-semibold text-emerald-700">
                    Перейти →
                </p>
            </a>
            <a
                href="/admin/product-units"
                class="group rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:border-emerald-200 hover:shadow-lg"
            >
                <span
                    class="flex h-11 w-11 items-center justify-center rounded-xl bg-sky-50 text-lg font-semibold text-sky-700"
                >
                    Е
                </span>
                <h2
                    class="mt-5 font-semibold text-slate-900 group-hover:text-emerald-700"
                >
                    Единицы товара
                </h2>
                <p class="mt-2 text-sm leading-6 text-slate-500">
                    Поштучный учёт, статусы и генерация партий.
                </p>
                <p class="mt-5 text-xs font-semibold text-emerald-700">
                    Перейти →
                </p>
            </a>
            <a
                href="/admin/product-supplies"
                class="group rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:border-emerald-200 hover:shadow-lg"
            >
                <span
                    class="flex h-11 w-11 items-center justify-center rounded-xl bg-violet-50 text-lg font-semibold text-violet-700"
                >
                    П
                </span>
                <h2
                    class="mt-5 font-semibold text-slate-900 group-hover:text-emerald-700"
                >
                    Поставки
                </h2>
                <p class="mt-2 text-sm leading-6 text-slate-500">
                    Приёмка товара и автоматическое создание единиц.
                </p>
                <p class="mt-5 text-xs font-semibold text-emerald-700">
                    Перейти →
                </p>
            </a>
            <a
                href="/admin/orders"
                class="group rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:border-emerald-200 hover:shadow-lg"
            >
                <span
                    class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-50 text-lg font-semibold text-amber-700"
                >
                    З
                </span>
                <h2
                    class="mt-5 font-semibold text-slate-900 group-hover:text-emerald-700"
                >
                    Заказы
                </h2>
                <p class="mt-2 text-sm leading-6 text-slate-500">
                    Обработка заказов и контроль выполнения.
                </p>
                <p class="mt-5 text-xs font-semibold text-emerald-700">
                    Перейти →
                </p>
            </a>
        </div>
    </div>
</template>

<script setup lang="ts">
import AdminLayout from '@/components/layouts/AdminLayout.vue';

defineOptions({
    layout: AdminLayout,
});
</script>

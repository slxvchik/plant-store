<template>
    <Button text="Создать" class="max-w-80 mb-5" />
    <div class="w-full overflow-hidden rounded-lg border border-gray-200 shadow-sm">
        <div
            class="grid grid-cols-4 bg-gray-50 border-b border-gray-200 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
            <div class="p-4">Id</div>
            <div class="p-4">Адрес</div>
            <div class="p-4">Телефон</div>
            <div class="p-4">Действие</div>
        </div>

        <div class="divide-y divide-gray-200 bg-white text-sm text-gray-700">
            <div v-for="n in 2" :key="n" class="grid grid-cols-4 hover:bg-gray-50 transition-colors">
                <div class="p-4 font-medium text-gray-900">#{{ n }}</div>
                <div class="p-4 truncate">ул. Пушкина, д. Колотушкина</div>
                <div class="p-4 whitespace-nowrap">+7 (999) 123-45-67</div>
                <div class="flex p-4 gap-2">
                    <Button text="Редактировать" class="w-fit bg-yellow-400 hover:bg-yellow-500" />
                    <Button text="Удалить" class="w-fit bg-red-400 hover:bg-red-500" />
                </div>
            </div>
        </div>
    </div>
</template>

<script setup type="ts">
import AdminLayout from '@/components/AdminLayout.vue';
import Button from '@/components/Button.vue';

defineOptions({
    layout: AdminLayout,
});
</script>
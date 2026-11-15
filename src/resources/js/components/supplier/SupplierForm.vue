<template>
    <form
        class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
        @submit.prevent="submit"
    >
        <div class="grid gap-5 p-6 sm:grid-cols-2 sm:p-8">
            <Input
                id="supplier-name"
                v-model="form.name"
                :error="form.errors.name"
                label="Название"
                placeholder="ООО «Зелёная грядка»"
                required
                variant="standard"
            />
            <Input
                id="supplier-email"
                v-model="form.email"
                :error="form.errors.email"
                label="Email"
                placeholder="supplier@example.ru"
                type="email"
                variant="standard"
            />
            <Input
                id="supplier-phone"
                v-model="form.phone"
                :error="form.errors.phone"
                label="Телефон"
                placeholder="+7 (999) 123-45-67"
                type="tel"
                variant="standard"
            />
            <Input
                id="supplier-address"
                v-model="form.address"
                :error="form.errors.address"
                label="Адрес"
                placeholder="Город, улица, дом"
                variant="standard"
            />
            <div class="sm:col-span-2">
                <Input
                    id="supplier-comment"
                    v-model="form.comment"
                    :error="form.errors.comment"
                    label="Комментарий"
                    multiline
                    placeholder="Условия сотрудничества, контактное лицо, график поставок"
                    variant="standard"
                />
            </div>
        </div>
        <div
            class="flex flex-col-reverse gap-3 border-t border-slate-100 bg-slate-50 px-6 py-4 sm:flex-row sm:justify-end sm:px-8"
        >
            <Link
                class="inline-flex h-11 items-center justify-center rounded-xl border border-slate-200 bg-white px-5 text-sm font-medium text-slate-600 transition hover:bg-slate-100"
                href="/admin/suppliers"
            >
                Отмена
            </Link>
            <Button
                :disabled="form.processing"
                :text="form.processing ? 'Сохранение…' : submitLabel"
                class="!w-auto !rounded-xl !px-5 !py-2.5 !text-sm"
                secondary
                type="submit"
            />
        </div>
    </form>
</template>

<script lang="ts" setup>
import { Link, useForm } from '@inertiajs/vue3';
import Button from '@/components/Button.vue';
import Input from '@/components/Input.vue';
import type { SupplierFormData } from '@/types/inventory';

const props = withDefaults(
    defineProps<{
        initial: SupplierFormData;
        submitUrl: string;
        method?: 'post' | 'put';
        submitLabel?: string;
    }>(),
    { method: 'post', submitLabel: 'Сохранить поставщика' },
);
const form = useForm<SupplierFormData>({ ...props.initial });
const submit = () => {
    const options = { preserveScroll: true };

    if (props.method === 'put') {
        form.put(props.submitUrl, options);
    } else {
        form.post(props.submitUrl, options);
    }
};
</script>

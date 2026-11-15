<template>
    <form
        class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
        @submit.prevent="submit"
    >
        <div class="space-y-5 p-6 sm:p-8">
            <Input
                id="product-unit-status-name"
                v-model="form.name"
                :error="form.errors.name"
                label="Название статуса"
                placeholder="Например, «Готово к продаже»"
                required
                variant="standard"
            />
            <Input
                id="product-unit-status-comment"
                v-model="form.comment"
                :error="form.errors.comment"
                label="Описание"
                multiline
                placeholder="Когда следует использовать этот статус"
                variant="standard"
            />
            <div
                class="flex items-center gap-3 rounded-xl bg-emerald-50 px-4 py-3 text-sm text-emerald-800"
            >
                <Badge :label="form.name || 'Новый статус'" />
                <span>Цвет значка формируется автоматически.</span>
            </div>
        </div>
        <div
            class="flex justify-end gap-3 border-t border-slate-100 bg-slate-50 px-6 py-4 sm:px-8"
        >
            <Link
                class="inline-flex h-11 items-center rounded-xl border border-slate-200 bg-white px-5 text-sm font-medium text-slate-600 hover:bg-slate-100"
                href="/admin/product-unit-statuses"
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
import Badge from '@/components/Badge.vue';
import Button from '@/components/Button.vue';
import Input from '@/components/Input.vue';
import type { StatusFormData } from '@/types/inventory';

const props = withDefaults(
    defineProps<{
        initial: StatusFormData;
        submitUrl: string;
        method?: 'post' | 'put';
        submitLabel?: string;
    }>(),
    { method: 'post', submitLabel: 'Сохранить статус' },
);
const form = useForm<StatusFormData>({ ...props.initial });
const submit = () => {
    const options = { preserveScroll: true };

    if (props.method === 'put') {
        form.put(props.submitUrl, options);
    } else {
        form.post(props.submitUrl, options);
    }
};
</script>

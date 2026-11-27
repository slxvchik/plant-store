<template>
    <form class="product-unit-status-form" @submit.prevent="submit">
        <div class="product-unit-status-form__body">
            <Input
                id="product-unit-status-name"
                v-model="form.name"
                :error="form.errors.name"
                label="Название статуса"
                placeholder="Например, «Готово к продаже»"
                required
            />
            <Textarea
                id="product-unit-status-comment"
                v-model="form.comment"
                :error="form.errors.comment"
                label="Описание"
                placeholder="Когда следует использовать этот статус"
            />
            <div class="product-unit-status-form__preview">
                <Badge :label="form.name || 'Новый статус'" />
                <span>Цвет значка формируется автоматически.</span>
            </div>
        </div>
        <div class="product-unit-status-form__footer">
            <Link
                class="product-unit-status-form__cancel"
                href="/admin/product-unit-statuses"
            >
                Отмена
            </Link>
            <Button
                :disabled="form.processing"
                :text="form.processing ? 'Сохранение…' : submitLabel"
                auto-width
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
import Textarea from '@/components/Textarea.vue';
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

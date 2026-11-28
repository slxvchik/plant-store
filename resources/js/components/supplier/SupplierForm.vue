<template>
    <form class="supplier-form" @submit.prevent="submit">
        <div class="supplier-form__grid">
            <Input
                id="supplier-name"
                v-model="form.name"
                :error="form.errors.name"
                label="Название"
                placeholder="ООО «Зелёная грядка»"
                required
            />
            <Input
                id="supplier-email"
                v-model="form.email"
                :error="form.errors.email"
                label="Email"
                placeholder="supplier@example.ru"
                type="email"
            />
            <Input
                id="supplier-phone"
                v-model="form.phone"
                :error="form.errors.phone"
                label="Телефон"
                placeholder="+7 (999) 123-45-67"
                type="tel"
            />
            <Input
                id="supplier-address"
                v-model="form.address"
                :error="form.errors.address"
                label="Адрес"
                placeholder="Город, улица, дом"
            />
            <div class="supplier-form__wide">
                <Textarea
                    id="supplier-comment"
                    v-model="form.comment"
                    :error="form.errors.comment"
                    label="Комментарий"
                    placeholder="Условия сотрудничества, контактное лицо, график поставок"
                />
            </div>
        </div>
        <div class="supplier-form__footer">
            <Link class="supplier-form__cancel" href="/admin/suppliers">
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
import Button from '@/components/Button.vue';
import Input from '@/components/Input.vue';
import Textarea from '@/components/Textarea.vue';
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

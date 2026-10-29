import type { FormDataType } from '@inertiajs/core';
import { router, useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { useNotificationStore } from '@/stores/useNotificationStore';

type CrudRoutes = {
    store: () => string;
    update: (id: string) => string;
    destroy: (id: string) => string;
};

type CrudOptions<TForm, TItem> = {
    // default values for form
    createData: () => TForm;
    // values for item edit
    editData: (item: TItem) => TForm;
    routes: CrudRoutes;
    validator?: (field: keyof TForm, value: any) => string | null;
};

export function useAdminCrudForm<
    TForm extends FormDataType<TForm>,
    TItem extends { id: string },
>(options: CrudOptions<TForm, TItem>) {
    const form = useForm<TForm>(options.createData());
    const isFormPopupOpen = ref(false);
    const editingId = ref<string | null>(null);
    const isEditMode = computed(() => editingId.value !== null);
    const notifications = useNotificationStore();

    const validateField = (field: keyof TForm, value: any): string | null => {
        const error = options.validator?.(field, value) ?? null;

        if (error) {
            form.setError(field as any, error)
        } else {
            form.clearErrors(field as any);
        }

        return error;
    };

    const validateForm = (): boolean => {
        let valid = true;

        for (const key of Object.keys(form.data()) as (keyof TForm)[]) {
            if (validateField(key, form[key])) {
                valid = false;
            }
        }

        return valid;
    };

    const openModal = (data: TForm, id: string | null): void => {
        editingId.value = id;
        form.defaults(data).reset().clearErrors();
        isFormPopupOpen.value = true;
    };

    const openCreateModal = (): void => openModal(options.createData(), null);

    const openEditModal = (item: TItem): void =>
        openModal(options.editData(item), item.id);

    const submit = (): void => {
        if (options.validator && !validateForm()) {
            return;
        }

        const id = editingId.value;
        const config = {
            preserveScroll: true,
            onSuccess: () => {
                isFormPopupOpen.value = false;
                form.clearErrors();
            },
            onError: (errors: Record<string, string>) => {
                Object.values(errors).forEach((error) =>
                    notifications.add(error, 'error', 5000),
                );
            },
        };

        if (id === null) {
            form.post(options.routes.store(), config);
        } else {
            form.put(options.routes.update(id), config);
        }
    };

    const destroy = (id: string): void => {
        router.delete(options.routes.destroy(id), { preserveScroll: true });
    };

    return {
        form,
        validateField,
        isFormPopupOpen,
        isEditMode,
        editingId,
        openCreateModal,
        openEditModal,
        submit,
        destroy,
    };
}

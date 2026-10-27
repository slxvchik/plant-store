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
    createData: () => TForm;
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

    const validateField = (
        field: keyof TForm,
        value: any,
    ): string | null => {
        if (!options.validator) {
            return null;
        }

        const currentError: string|null = options.validator(field, value);

        if (currentError) {
            form.setError(field as any, currentError);
        } else {
            form.clearErrors(field as any);
        }

        return currentError;
    };

    const validateForm = (
        data: TForm,
    ): Partial<Record<keyof TForm, string>> => {
        const errs: Partial<Record<keyof TForm, string>> = {};

        for (const key of Object.keys(data) as (keyof TForm)[]) {
            const error = validateField(key, data[key]);

            if (error) {
                errs[key] = error;
            }
        }

        return errs;
    };

    const initialize = (data: TForm): void => {
        form.defaults(data);
        form.reset();
        form.clearErrors();
    };

    const openCreateModal = (): void => {
        editingId.value = null;
        initialize(options.createData());
        isFormPopupOpen.value = true;
    };

    const openEditModal = (item: TItem): void => {
        editingId.value = item.id;
        initialize(options.editData(item));
        isFormPopupOpen.value = true;
    };

    const submit = (): void => {
        const id = editingId.value;
        const request = id === null ? form.post : form.put;
        const url = id === null ? options.routes.store() : options.routes.update(id);

        if (options.validator) {
            const frontendErrors = validateForm(form);
            const hasErrors = Object.keys(frontendErrors).length > 0;

            if (hasErrors) {
                Object.entries(frontendErrors).forEach(([key, val]) => {
                    if (val) {
                        const valStr: string = val as string;
                        form.setError(key as any, valStr);
                        notifications.add(valStr, 'error');
                    }
                });

                return;
            }
        }

        request(url, {
            preserveScroll: true,
            onSuccess: () => {
                isFormPopupOpen.value = false;
                form.clearErrors();
            },
            onError: (errors) => {
                Object.values(errors).map((error) => {
                    notifications.add(error, 'error', 5000);
                });
            },
        });
    };

    const destroy = (id: string): void => {
        router.delete(options.routes.destroy(id), { preserveScroll: true });
    };

    return {
        form,
        validateField,
        validateForm,
        isFormPopupOpen,
        isEditMode,
        editingId,
        openCreateModal,
        openEditModal,
        submit,
        destroy,
    };
}

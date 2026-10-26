import type { FormDataType } from '@inertiajs/core';
import { router, useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

type CrudRoutes = {
    store: () => string;
    update: (id: string) => string;
    destroy: (id: string) => string;
};

type CrudOptions<TForm, TItem> = {
    createData: () => TForm;
    editData: (item: TItem) => TForm;
    routes: CrudRoutes;
};

export function useAdminCrudForm<
    TForm extends FormDataType<TForm>,
    TItem extends { id: string },
>(options: CrudOptions<TForm, TItem>) {
    const form = useForm<TForm>(options.createData());
    const isFormPopupOpen = ref(false);
    const editingId = ref<string | null>(null);
    const isEditMode = computed(() => editingId.value !== null);

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

        request(url, {
            preserveScroll: true,
            onSuccess: () => {
                isFormPopupOpen.value = false;
                form.clearErrors();
            },
        });
    };

    const destroy = (id: string): void => {
        router.delete(options.routes.destroy(id), { preserveScroll: true });
    };

    return {
        form,
        isFormPopupOpen,
        isEditMode,
        editingId,
        openCreateModal,
        openEditModal,
        submit,
        destroy,
    };
}

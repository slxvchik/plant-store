import type { FormDataType } from '@inertiajs/core';
import type { InertiaForm } from '@inertiajs/vue3';

export function useFormValidator<TForm extends FormDataType<TForm>>(
    validator: (field: keyof TForm, value: any) => string | null,
    form: InertiaForm<TForm>,
) {
    const validateField = (field: keyof TForm, value: any): string | null => {
        const error = validator?.(field, value) ?? null;

        if (error) {
            form.setError(field as any, error);
        } else {
            form.clearErrors(field as any);
        }

        return error;
    };

    const validateForm = () => {
        let isValid = true;
        const data = form.data();

        for (const key of Object.keys(data) as Array<keyof TForm & string>) {
            if (validateField(key, form[key])) {
                isValid = false;
            }
        }

        return isValid;
    };

    return { validateField, validateForm };
}

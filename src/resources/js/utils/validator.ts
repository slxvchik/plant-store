import type {
    ValidatorFactory,
    ValidatorFunc,
    ValidatorResponse,
} from '@/types/validator.ts';

const success = (): ValidatorResponse => {
    return {
        success: true,
        errorMessage: null,
    }
}

const error = (errMessage: string): ValidatorResponse => {
    return {
        success: false,
        errorMessage: errMessage,
    }
}

const rulesMap: Record<string, ValidatorFactory | ValidatorFunc> = {
    required: (val: any): ValidatorResponse => {
        const defaultMessage: string = 'Данное поле обязательно для заполнения';

        if (val === undefined || val === null) {
            return error(defaultMessage);
        }

        if (typeof val === 'string') {
            const trimVal: string = val.trim();

            if (trimVal === '' || trimVal === '-') {
                return error(defaultMessage);
            }
        }

        if (Array.isArray(val) && val.length === 0) {
            return error(defaultMessage);
        }

        return success();
    },

    email: (val: any): ValidatorResponse => {
        if (!val) {
            return success();
        }

        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val)) {
            return error('Неверный email');
        }

        return success();
    },

    phone: (val: any): ValidatorResponse => {
        if (!val) {
            return success();
        }

        const hasCorrectStart = val.startsWith('+7') || val.startsWith('7');

        if (!hasCorrectStart) {
            return error('Номер телефона должен начинаться с +7');
        }

        const digits = val.replace(/\D/g, '');

        if (digits.length !== 11) {
            return error('Введите полный номер телефона');
        }

        return success();
    },

    url: (val: any): ValidatorResponse => {
        if (!val) {
            return success();
        }

        if (
            !/^https?:\/\/(www\.)?[-a-zA-Z0-9а-яА-ЯёЁ@:%._+~#=]{1,256}\.[a-zA-Z0-9А-яёЁ()]{1,6}\b([-a-zA-Z0-9А-яёЁ()@:%_+.~#?&\/=]*)$/.test(
                val,
            )
        ) {
            return error(
                'Введите корректный URL-адрес (например, https://example.com). Ссылка должна начинаться с http:// или https:// и не содержать пробелов',
            );
        }

        return success();
    },

    date: (val: any): ValidatorResponse => {
        if (!val) {
            return success();
        }

        const regex = /^(\d{2})\.(\d{2})\.(\d{4})$/;

        if (!regex.test(val)) {
            return error('Введите дату в формате ДД.ММ.ГГГГ');
        }

        const [day, month, year] = val.split('.').map(Number);
        const date = new Date(year, month - 1, day);

        if (
            date.getFullYear() !== year ||
            date.getMonth() !== month - 1 ||
            date.getDate() !== day
        ) {
            return error('Указана несуществующая дата');
        }

        return success();
    },

    positiveNumber: (val: any): ValidatorResponse => {
        if (!val) {
            return success();
        }

        const normalized = String(val).replace(',', '.');

        if (!isNaN(Number(normalized)) && Number(normalized) >= 0) {
            return success();
        }

        return error('Введите корректное положительное число');
    },

    positiveInteger: (val: any): ValidatorResponse => {
        if (!val || /^\d+$/.test(String(val))) {
            return success();
        }

        return error('Введите целое положительное число');
    },

    min:
        (minLen: number): ValidatorFunc =>
        (val: any): ValidatorResponse => {
            if (!val) {
                return success();
            }

            if (typeof val === 'string' && val.length < minLen) {
                return error(`Минимальное количество символов: ${minLen}`);
            }

            return success();
        },

    max:
        (maxLen: number): ValidatorFunc =>
        (val: any): ValidatorResponse => {
            if (!val) {
                return success();
            }

            if (typeof val === 'string' && val.length > maxLen) {
                return error(`Максимальное количество символов: ${maxLen}`);
            }

            return success();
        },
};

export function validator(rules?: string): ValidatorFunc[] {
    if (!rules || typeof rules !== 'string') {
        return [];
    }

    return rules.split('|').map((ruleKey) => {
        const [name, param] = ruleKey.split(':');
        const func = rulesMap[name];

        if (!func) {
            return () => success();
        }

        if (param !== undefined) {
            return (func as ValidatorFactory)(Number(param));
        }

        return func as ValidatorFunc;
    });
}

export function validate(value: any, rules?: string, errorMessage?: string): string|null {
    if (!rules || typeof rules !== 'string') {
        return null;
    }


    const ruleFunctions = validator(rules);

    const failedRule = ruleFunctions
        .map((rule) => rule(value))
        .find((response) => !response.success);

    return failedRule ? (errorMessage ?? failedRule.errorMessage) : null;
}

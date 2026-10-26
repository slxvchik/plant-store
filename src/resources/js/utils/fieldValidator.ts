const fieldValidator = {
    required: (val: any) => {
        if (val === undefined || val === null) {
            return 'Данное поле обязательно для заполнения';
        }

        const trimmedVal = String(val).trim();

        return (
            (trimmedVal !== '' && trimmedVal !== '-') ||
            'Данное поле обязательно для заполнения'
        );
    },

    requiredFile: (val: any) => {
        if (!Array.isArray(val) || val.length === 0) {
            return 'Выберите хотя бы один файл';
        }

        return true;
    },

    email: (val: any) => {
        if (!val) {
            return true;
        }

        return (
            /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val) || 'Введите корректный email'
        );
    },

    phone: (val: any) => {
        if (!val) {
            return true;
        }

        const hasCorrectStart = val.startsWith('+7') || val.startsWith('7');

        if (!hasCorrectStart) {
            return 'Номер телефона должен начинаться с +7';
        }

        const digits = val.replace(/\D/g, '');

        return digits.length === 11 || 'Введите полный номер телефона';
    },

    url: (val: any) => {
        if (!val) {
            return true;
        }

        return (
            /^https?:\/\/(www\.)?[-a-zA-Z0-9А-яёЁ@:%._+~#=]{1,256}\.[a-zA-Z0-9А-яёЁ()]{1,6}\b([-a-zA-Z0-9А-яёЁ()@:%_+.~#?&\/=]*)$/.test(
                val,
            ) ||
            'Введите корректный URL-адрес (например, https://example.com). Ссылка должна начинаться с http:// или https:// и не содержать пробелов'
        );
    },

    date: (val: any) => {
        if (!val) {
            return true;
        }

        const regex = /^(\d{2})\.(\d{2})\.(\d{4})$/;

        if (!regex.test(val)) {
            return 'Введите дату в формате ДД.ММ.ГГГГ';
        }

        const [day, month, year] = val.split('.').map(Number);
        const date = new Date(year, month - 1, day);

        if (
            date.getFullYear() !== year ||
            date.getMonth() !== month - 1 ||
            date.getDate() !== day
        ) {
            return 'Указана несуществующая дата';
        }

        return true;
    },

    positiveNumber: (val: any) => {
        if (!val) {
            return true;
        }

        const normalized = String(val).replace(',', '.');

        return (
            (!isNaN(Number(normalized)) && Number(normalized) >= 0) ||
            'Введите корректное положительное число'
        );
    },

    positiveInteger: (val: any) => {
        if (!val) {
            return true;
        }

        return /^\d+$/.test(String(val)) || 'Введите целое положительное число';
    },

    min: (len: any) => (val: any) =>
        !val || val.length >= len || `Минимальное количество символов: ${len}`,

    max: (len: any) => (val: any) =>
        !val || val.length <= len || `Максимальное количество символов: ${len}`,

    fileMaxSize: (mb: any) => (val: any) => {
        if (!val) {
            return true;
        }

        const maxBytes = mb * 1024 * 1024;
        const files = Array.isArray(val) ? val : [val];

        const invalidFiles = files.filter(
            (file) => file instanceof File && file.size > maxBytes,
        );

        if (invalidFiles.length > 0) {
            const fileListHtml = invalidFiles
                .map(
                    (f) =>
                        `<li>${f.name} (размер: ${(f.size / 1024 / 1024).toFixed(2)} МБ)</li>`,
                )
                .join('');

            return `
                <div>Следующие файлы превышают лимит ${mb} МБ:</div>
                <ul>${fileListHtml}</ul>
            `;
        }

        return true;
    },
};

export const validate = (rulesString: string) => {
    if (!rulesString || typeof rulesString !== 'string') {
        return [];
    }

    return rulesString.split('|').map((ruleKey) => {
        const [name, param] = ruleKey.split(':');

        const func: any = fieldValidator[name as keyof typeof fieldValidator];

        if (!func) {
            console.warn(`Правило "${name}" не найдено в валидаторе`);

            return (): boolean => true;
        }

        return param ? func(Number(param)) : func;
    });
};

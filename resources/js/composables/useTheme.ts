import { ref } from 'vue';

const isDark = ref(false);
const isThemeTransitioning = ref(false);
let initialized = false;

const initializeTheme = (): void => {
    if (initialized || typeof window === 'undefined') {
        return;
    }

    initialized = true;
    let savedTheme: string | null = null;

    try {
        savedTheme = window.localStorage.getItem('deulino-theme');
    } catch {
        savedTheme = null;
    }

    isDark.value = savedTheme
        ? savedTheme === 'dark'
        : window.matchMedia('(prefers-color-scheme: dark)').matches;
    document.documentElement.classList.toggle('dark', isDark.value);
};

const toggleTheme = (): void => {
    if (isThemeTransitioning.value || typeof window === 'undefined') {
        return;
    }

    isThemeTransitioning.value = true;
    window.setTimeout(() => {
        isDark.value = !isDark.value;
        document.documentElement.classList.toggle('dark', isDark.value);

        try {
            window.localStorage.setItem(
                'deulino-theme',
                isDark.value ? 'dark' : 'light',
            );
        } catch {
            return;
        }
    }, 140);
    window.setTimeout(() => {
        isThemeTransitioning.value = false;
    }, 460);
};

export function useTheme() {
    initializeTheme();

    return { isDark, isThemeTransitioning, toggleTheme };
}

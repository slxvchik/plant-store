import { onUnmounted, Ref, watch } from "vue";

export function useBodyScrollLock(isLockedRef: Ref<boolean>) {
    const noScrollClass = 'no-scroll';

    watch(isLockedRef, (newValue) => {
        if (newValue) {
            document.documentElement.classList.add(noScrollClass);
        } else {
            document.documentElement.classList.remove(noScrollClass);
        }
    }, { immediate: true });

    onUnmounted(() => {
        document.documentElement.classList.remove(noScrollClass);
    });
}
import { onUnmounted, watch } from 'vue';
import type { Ref } from 'vue';

export function useBodyScrollLock(isLockedRef: Ref<boolean>): void {
    const noScrollClass = 'no-scroll';

    watch(
        isLockedRef,
        (isLocked) => {
            document.documentElement.classList.toggle(noScrollClass, isLocked);
        },
        { immediate: true },
    );

    onUnmounted(() => {
        document.documentElement.classList.remove(noScrollClass);
    });
}

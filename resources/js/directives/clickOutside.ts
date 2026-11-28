import type { ObjectDirective } from 'vue';

interface HTMLElementWithClickOutside extends HTMLElement {
    _clickOutsideEvent?: (event: MouseEvent) => void;
}

export const clickOutside: ObjectDirective<HTMLElementWithClickOutside, (event: MouseEvent) => void> = {
    mounted(el, binding) {
        el._clickOutsideEvent = (event: MouseEvent) => {
            const target = event.target as Node;

            if (!(el === event.target || el.contains(target))) {
                binding.value(event);
            }
        };
        document.addEventListener('click', el._clickOutsideEvent);
    },
    unmounted(el) {
        if (el._clickOutsideEvent) {
            document.removeEventListener('click', el._clickOutsideEvent);
            delete el._clickOutsideEvent;
        }
    },
};

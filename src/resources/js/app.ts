import { createInertiaApp, router } from '@inertiajs/vue3';
import { createPinia } from 'pinia';
import { createApp, h } from 'vue';
import { useNotificationStore } from '@/stores/useNotificationStore';
import type { Flash } from '@/types/flash';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';
const pinia = createPinia();

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    progress: { color: '#4B5563' },
    setup({ el, App, props, plugin }) {
        if (!el) {
            console.error('Inertia root element not found.');

            return;
        }

        const app = createApp({ render: () => h(App, props) });
        app.use(plugin);
        app.use(pinia);

        router.on('success', (event) => {
            const flash = event.detail.page.props.flash as Flash | undefined;

            if (flash?.message) {
                useNotificationStore().add(
                    flash.message,
                    flash.type ?? 'success',
                );
            }
        });

        app.mount(el);
    },
});

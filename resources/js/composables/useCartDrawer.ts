import { computed, ref } from 'vue';
import { useNotificationStore } from '@/stores/useNotificationStore.ts';

export type DrawerCartItem = {
    id: string;
    name: string;
    price: number;
    image: string;
    quantity: number;
};

const items = ref<DrawerCartItem[]>([]);
const isCartOpen = ref(false);

export function useCartDrawer() {
    const notificationStore = useNotificationStore();

    const itemCount = computed(() =>
        items.value.reduce((total, item) => total + item.quantity, 0),
    );
    const total = computed(() =>
        items.value.reduce((sum, item) => sum + item.price * item.quantity, 0),
    );

    const addToCart = (product: Omit<DrawerCartItem, 'quantity'>): void => {
        const existingItem = items.value.find((item) => item.id === product.id);

        if (existingItem) {
            existingItem.quantity += 1;
        } else {
            items.value.push({ ...product, quantity: 1 });
        }

        notificationStore.add(
            `${product?.name} добавлен в корзину`,
            'success',
            5000,
        );
    };

    const updateQuantity = (id: string, change: number): void => {
        const item = items.value.find((cartItem) => cartItem.id === id);

        if (!item) {
            return;
        }

        item.quantity += change;

        if (item.quantity <= 0) {
            items.value = items.value.filter((cartItem) => cartItem.id !== id);
        }
    };

    const formatPrice = (price: number): string =>
        new Intl.NumberFormat('ru-RU', {
            style: 'currency',
            currency: 'RUB',
            maximumFractionDigits: 0,
        }).format(price);

    return {
        items,
        isCartOpen,
        itemCount,
        total,
        addToCart,
        updateQuantity,
        formatPrice,
    };
}

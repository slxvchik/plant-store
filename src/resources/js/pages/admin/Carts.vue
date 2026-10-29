<template>
    <div class="flex flex-col gap-5">
        <h1 class="text-4xl text-text-title">Корзина</h1>
        <div class="flex gap-5">
            <div v-if="cart" class="max-w-80">
                <Button
                    text="Добавить товар"
                    secondary
                    @click="openCreateProductModal"
                />
            </div>
            <div class="max-w-80">
                <Button
                    text="Создать корзину"
                    secondary
                    @click="openCreateCartModal"
                />
            </div>
        </div>
        <div v-if="!cart" class="flex max-w-160 items-end gap-5">
            <Input
                id="cartId"
                v-model="cartIdFilter"
                placeholder="Id корзины"
                label="Id корзины"
                class="w-full"
            />
            <Button text="Найти" secondary @click="findCart" />
        </div>
    </div>
    <div v-if="cart" class="mt-5 flex flex-col gap-2 text-sm text-gray-600">
        <span
            >Id корзины: <b class="text-gray-900">#{{ cart.cartId }}</b></span
        >
        <span>
            Пользователь:
            <b class="text-gray-900">{{ cart.userId ?? 'Гость' }}</b>
        </span>
    </div>
    <div
        v-if="cart"
        class="mt-5 w-full overflow-hidden rounded-lg border border-gray-200 shadow-sm"
    >
        <div
            class="grid grid-cols-6 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold tracking-wider text-gray-500 uppercase"
        >
            <div class="p-4">Товар</div>
            <div class="p-4">SKU</div>
            <div class="p-4">Цена</div>
            <div class="p-4">Количество</div>
            <div class="p-4">Доступно</div>
            <div class="p-4">Действие</div>
        </div>
        <div class="divide-y divide-gray-200 bg-white text-sm text-gray-700">
            <div
                v-for="cartLine in cart.cartLines"
                :key="`${cartLine.product.productId}:${cartLine.product.offerId}`"
                class="grid grid-cols-6 transition-colors hover:bg-gray-50"
            >
                <div class="truncate p-4 font-medium text-gray-900">
                    {{ cartLine.product.name }}
                </div>
                <div class="truncate p-4">{{ cartLine.product.sku }}</div>
                <div class="p-4 whitespace-nowrap">
                    {{ (cartLine.product.price / 100).toFixed(2) }} ₽
                </div>
                <div class="p-4">{{ cartLine.quantity }}</div>
                <div class="p-4">{{ cartLine.availableQuantity }}</div>
                <div class="flex gap-2 p-4">
                    <Button
                        text="Удалить"
                        class="w-fit bg-red-400 hover:bg-red-500"
                        @click="destroyCartLine(cartLine)"
                    />
                </div>
            </div>
            <div
                v-if="cart.cartLines.length === 0"
                class="p-4 text-center text-gray-500"
            >
                Корзина пуста
            </div>
        </div>
    </div>
    <div v-else class="mt-5 text-sm text-gray-500">
        Введите Id корзины для просмотра содержимого.
    </div>

    <Popup v-model:open="isProductFormPopupOpen" title="Добавить товар">
        <form
            class="flex w-full flex-col gap-5"
            @submit.prevent="submitProductForm"
        >
            <Input
                id="productId"
                v-model="productForm.productId"
                placeholder="Id товара"
                label="Id товара"
                :error="productForm.errors.productId"
                @update:modelValue="
                    validateProductField('productId', productForm.productId)
                "
            />
            <Input
                id="offerId"
                v-model="productForm.offerId"
                placeholder="Id предложения"
                label="Id предложения"
                :error="productForm.errors.offerId"
                @update:modelValue="
                    validateProductField('offerId', productForm.offerId)
                "
            />
            <Input
                id="quantity"
                v-model="productForm.quantity"
                type="number"
                placeholder="Количество"
                label="Количество"
                :error="productForm.errors.quantity"
                @update:modelValue="
                    validateProductField('quantity', productForm.quantity)
                "
            />
            <Button
                type="submit"
                secondary
                :disabled="productForm.processing"
                text="Добавить"
                class="relative left-[50%] max-w-80 translate-x-[-50%]"
            />
        </form>
    </Popup>

    <Popup v-model:open="isCartFormPopupOpen" title="Создать корзину">
        <form
            class="flex w-full flex-col gap-5"
            @submit.prevent="submitCartForm"
        >
            <Input
                id="userId"
                v-model="cartForm.userId"
                placeholder="Id пользователя"
                label="Пользователь (необязательно)"
                :error="cartForm.errors.userId"
                @update:modelValue="
                    validateCartField('userId', cartForm.userId)
                "
            />
            <Button
                type="submit"
                secondary
                :disabled="cartForm.processing"
                text="Создать"
                class="relative left-[50%] max-w-80 translate-x-[-50%]"
            />
        </form>
    </Popup>
</template>

<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';
import Button from '@/components/Button.vue';
import Input from '@/components/Input.vue';
import AdminLayout from '@/components/layouts/AdminLayout.vue';
import Popup from '@/components/Popup.vue';
import { useAdminCrudForm } from '@/composables/useAdminCrudForm';
import AdminCarts from '@/routes/admin/carts';
import type { Cart, CartLine } from '@/types/cart';
import { validate } from '@/utils/validator.ts';

defineOptions({ layout: AdminLayout });
const props = defineProps<{ cart: Cart | null }>();

const cartIdFilter = ref(props.cart?.cartId ?? '');

const findCart = (): void => {
    router.get(
        AdminCarts.list.url(),
        { cartId: cartIdFilter.value },
        { preserveScroll: true },
    );
};

type ProductLineForm = {
    productId: string;
    offerId: string;
    quantity: number;
};
type CartLineItem = CartLine & { id: string };
const createProductData = (): ProductLineForm => ({
    productId: '',
    offerId: '',
    quantity: 1,
});
const productValidator = (field: keyof ProductLineForm, value: any) => {
    switch (field) {
        case 'productId':
            return validate(value, 'required', 'Id товара обязателен');
        case 'offerId':
            return validate(value, 'required', 'Id предложения обязательно');
        case 'quantity':
            return validate(
                value,
                'required|positiveInteger',
                'Введите корректное количество',
            );
        default:
            return null;
    }
};
const {
    form: productForm,
    validateField: validateProductField,
    isFormPopupOpen: isProductFormPopupOpen,
    openCreateModal: openCreateProductModal,
    submit: submitProductForm,
} = useAdminCrudForm<ProductLineForm, CartLineItem>({
    createData: createProductData,
    editData: (cartLine) => ({
        productId: cartLine.product.productId,
        offerId: cartLine.product.offerId,
        quantity: cartLine.quantity,
    }),
    routes: {
        store: () =>
            props.cart
                ? AdminCarts.save.url(props.cart.cartId)
                : AdminCarts.list.url(),
        update: () => AdminCarts.list.url(),
        destroy: () => AdminCarts.list.url(),
    },
    validator: productValidator,
});

type CartForm = { userId: string | null };
type CartItem = Cart & { id: string };
const createCartData = (): CartForm => ({ userId: null });
const cartValidator = () => null;
const {
    form: cartForm,
    validateField: validateCartField,
    isFormPopupOpen: isCartFormPopupOpen,
    openCreateModal: openCreateCartModal,
    submit: submitCartForm,
} = useAdminCrudForm<CartForm, CartItem>({
    createData: createCartData,
    editData: (cart) => ({ userId: cart.userId }),
    routes: {
        store: () => AdminCarts.store.url(),
        update: () => AdminCarts.list.url(),
        destroy: () => AdminCarts.list.url(),
    },
    validator: cartValidator,
});

const destroyCartLine = (cartLine: CartLine): void => {
    if (!props.cart) {
        return;
    }

    router.delete(
        AdminCarts.delete.url([
            props.cart.cartId,
            cartLine.product.productId,
            cartLine.product.offerId,
        ]),
        {
            preserveScroll: true,
            data: { userId: props.cart.userId },
        },
    );
};
</script>

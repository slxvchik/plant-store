<template>
    <div class="products-index">
        <AdminPageHeader
            description="Управляйте карточками товаров, предложениями и видимостью в каталоге."
            eyebrow="Каталог"
            title="Товары"
        >
            <template #actions>
                <Link
                    :href="AdminProducts.create.url()"
                    class="products-index__create"
                >
                    Создать товар
                </Link>
            </template>
        </AdminPageHeader>
        <Table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Активность</th>
                    <th class="products-index__cell--actions">Действия</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="product in productsPage.items" :key="product.id">
                    <td class="products-index__id">
                        #{{ product.id.slice(0, 8) }}
                    </td>
                    <td class="products-index__name">{{ product.name }}</td>
                    <td>
                        <Badge
                            :label="product.active ? 'Активен' : 'Скрыт'"
                            :tone="product.active ? 'success' : 'neutral'"
                        />
                    </td>
                    <td>
                        <div class="products-index__actions">
                            <Link
                                :href="
                                    AdminRoutes.products.show.url(product.id)
                                "
                                class="products-index__open"
                            >
                                Открыть
                            </Link>
                            <Button
                                auto-width
                                danger
                                ghost
                                small
                                text="Удалить"
                                type="button"
                                @click="deleteProduct(product.id)"
                            />
                        </div>
                    </td>
                </tr>
                <tr v-if="productsPage.items.length === 0">
                    <td class="products-index__empty" colspan="4">
                        Товары ещё не созданы.
                    </td>
                </tr>
            </tbody>
            <template #pagination>
                <Pagination :pagination="pagination" />
            </template>
        </Table>
    </div>
</template>
<script lang="ts" setup>
import { Link, router } from '@inertiajs/vue3';
import { computed } from 'vue';
import AdminPageHeader from '@/components/admin/AdminPageHeader.vue';
import Badge from '@/components/Badge.vue';
import Button from '@/components/Button.vue';
import Pagination from '@/components/Pagination.vue';
import Table from '@/components/Table.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import AdminRoutes from '@/routes/admin';
import AdminProducts from '@/routes/admin/products';
import type { Product } from '@/types';
import type { Page } from '@/types/pagination.ts';
import { getPaginationFromPageResponse } from '@/utils/getPaginationFromPageResponse.ts';

defineOptions({ layout: AdminLayout });
const props = defineProps({
    productsPage: { type: Object as () => Page<Product>, required: true },
});
const pagination = computed(() =>
    getPaginationFromPageResponse(props.productsPage),
);
const deleteProduct = (productId: string) => {
    router.delete(AdminProducts.destroy.url(productId), {});
};
</script>

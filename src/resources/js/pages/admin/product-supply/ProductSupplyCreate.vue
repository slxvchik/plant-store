<template>
    <div class="product-supply-create">
        <AdminPageHeader
            back-url="/admin/product-supplies"
            description="После сохранения система автоматически создаст фактическое количество единиц товара."
            eyebrow="Закупки"
            title="Новая поставка"
        />
        <form class="product-supply-create__layout" @submit.prevent="submit">
            <div class="product-supply-create__form-card">
                <div class="product-supply-create__grid">
                    <Select
                        v-model="form.supplierId"
                        :error="form.errors.supplierId"
                        :items="supplierOptions"
                        label="Поставщик"
                        required
                    />
                    <Select
                        v-model="form.offerId"
                        :error="form.errors.offerId"
                        :items="offerOptions"
                        label="Товар / предложение"
                    />
                    <Select
                        v-model="form.warehouseId"
                        :error="form.errors.warehouseId"
                        :items="warehouseOptions"
                        label="Склад размещения"
                        required
                    />
                    <Select
                        v-model="form.initialProductUnitStatusId"
                        :error="form.errors.initialProductUnitStatusId"
                        :items="statusOptions"
                        label="Начальный статус"
                        required
                    />
                    <Input
                        v-model="form.declaredQuantity"
                        :error="form.errors.declaredQuantity"
                        :min="1"
                        label="Заявленное количество"
                        required
                        type="number"
                    />
                    <Input
                        v-model="form.actualQuantity"
                        :error="form.errors.actualQuantity"
                        :min="0"
                        hint="Столько записей будет создано."
                        label="Фактическое количество"
                        required
                        type="number"
                    />
                    <Input
                        v-model="unitPriceRubles"
                        :error="form.errors.unitPurchasePriceInKopecks"
                        :min="0"
                        :step="0.01"
                        label="Цена за единицу, ₽"
                        type="number"
                    />
                    <Input
                        v-model="totalPriceRubles"
                        :error="form.errors.totalPurchasePriceInKopecks"
                        :min="0"
                        :step="0.01"
                        label="Общая стоимость, ₽"
                        type="number"
                    />
                    <div class="product-supply-create__wide">
                        <Button
                            v-if="calculatedTotal !== null"
                            class="product-supply-create__calculate"
                            style-type="link"
                            type="button"
                            @click="fillCalculatedTotal"
                        >
                            Рассчитать сумму: {{ formatMoney(calculatedTotal) }}
                        </Button>
                        <Checkbox
                            v-model="form.misGraded"
                            description="Состав или количество отличается от сопроводительных документов"
                            text="Пересорт"
                        />
                    </div>
                    <div class="product-supply-create__wide">
                        <Textarea
                            v-model="form.comment"
                            :error="form.errors.comment"
                            label="Комментарий"
                            placeholder="Номер накладной, особенности приёмки, расхождения"
                        />
                    </div>
                </div>
            </div>
            <aside class="product-supply-create__aside">
                <div class="product-supply-create__summary">
                    <p class="product-supply-create__summary-label">
                        Будет сгенерировано
                    </p>
                    <p class="product-supply-create__quantity">
                        {{ form.actualQuantity || 0 }}
                        <span>шт.</span>
                    </p>
                    <div class="product-supply-create__details">
                        <div>
                            <p class="product-supply-create__detail-label">
                                Товар
                            </p>
                            <p class="product-supply-create__detail-value">
                                {{ selectedOffer }}
                            </p>
                        </div>
                        <div>
                            <p class="product-supply-create__detail-label">
                                Склад
                            </p>
                            <p class="product-supply-create__detail-value">
                                {{ selectedWarehouse }}
                            </p>
                        </div>
                        <div>
                            <p class="product-supply-create__detail-label">
                                Сумма
                            </p>
                            <p class="product-supply-create__detail-value">
                                {{
                                    formatMoney(
                                        form.totalPurchasePriceInKopecks,
                                    )
                                }}
                            </p>
                        </div>
                    </div>
                </div>
                <Button
                    :disabled="form.processing"
                    :text="
                        form.processing
                            ? 'Создание поставки…'
                            : 'Создать поставку и единицы'
                    "
                    secondary
                    type="submit"
                />
                <p class="product-supply-create__note">
                    Поставка и все единицы будут сохранены в одной транзакции.
                </p>
            </aside>
        </form>
    </div>
</template>
<script lang="ts" setup>
import { useForm } from '@inertiajs/vue3';
import { computed } from 'vue';
import AdminPageHeader from '@/components/admin/AdminPageHeader.vue';
import Button from '@/components/Button.vue';
import Checkbox from '@/components/Checkbox.vue';
import Input from '@/components/Input.vue';
import Select from '@/components/Select.vue';
import Textarea from '@/components/Textarea.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import type {
    ProductOption,
    ProductUnitStatus,
    Supplier,
} from '@/types/inventory.ts';
import type { Warehouse } from '@/types/warehouse.ts';

defineOptions({ layout: AdminLayout });
const props = defineProps<{
    products: ProductOption[];
    suppliers: Supplier[];
    warehouses: Warehouse[];
    statuses: ProductUnitStatus[];
}>();
type SupplyForm = {
    supplierId: string;
    offerId: string | null;
    warehouseId: string;
    initialProductUnitStatusId: string;
    declaredQuantity: number;
    actualQuantity: number;
    unitPurchasePriceInKopecks: number | null;
    totalPurchasePriceInKopecks: number | null;
    comment: string;
    misGraded: boolean;
};
const form = useForm<SupplyForm>({
    supplierId: '',
    offerId: null,
    warehouseId: '',
    initialProductUnitStatusId: '',
    declaredQuantity: 1,
    actualQuantity: 1,
    unitPurchasePriceInKopecks: null,
    totalPurchasePriceInKopecks: null,
    comment: '',
    misGraded: false,
});
const supplierOptions = computed(() =>
    props.suppliers.map((supplier) => ({
        value: supplier.id,
        label: supplier.name,
    })),
);
const offerOptions = computed(() =>
    props.products.flatMap((product) =>
        product.offers.map((offer) => ({
            value: offer.id,
            label: `${product.name} — ${offer.sku || offer.id.slice(0, 8)}`,
        })),
    ),
);
const warehouseOptions = computed(() =>
    props.warehouses.map((warehouse) => ({
        value: warehouse.id,
        label: warehouse.address,
    })),
);
const statusOptions = computed(() =>
    props.statuses.map((status) => ({ value: status.id, label: status.name })),
);
const unitPriceRubles = computed({
    get: () =>
        form.unitPurchasePriceInKopecks === null
            ? null
            : form.unitPurchasePriceInKopecks / 100,
    set: (value: number | null) => {
        form.unitPurchasePriceInKopecks =
            value === null ? null : Math.round(value * 100);
    },
});
const totalPriceRubles = computed({
    get: () =>
        form.totalPurchasePriceInKopecks === null
            ? null
            : form.totalPurchasePriceInKopecks / 100,
    set: (value: number | null) => {
        form.totalPurchasePriceInKopecks =
            value === null ? null : Math.round(value * 100);
    },
});
const calculatedTotal = computed(() =>
    form.unitPurchasePriceInKopecks === null
        ? null
        : form.unitPurchasePriceInKopecks * form.actualQuantity,
);
const fillCalculatedTotal = () => {
    form.totalPurchasePriceInKopecks = calculatedTotal.value;
};
const selectedOffer = computed(
    () =>
        offerOptions.value.find((offer) => offer.value === form.offerId)
            ?.label ?? 'Не выбран',
);
const selectedWarehouse = computed(
    () =>
        props.warehouses.find((warehouse) => warehouse.id === form.warehouseId)
            ?.address ?? 'Не выбран',
);
const formatMoney = (value: number | null) =>
    value === null
        ? 'Не указана'
        : `${new Intl.NumberFormat('ru-RU').format(value / 100)} ₽`;
const submit = () => form.post('/admin/product-supplies');
</script>

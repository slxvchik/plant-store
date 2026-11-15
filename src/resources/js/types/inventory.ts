export type Supplier = {
    id: string;
    name: string;
    phone: string | null;
    email: string | null;
    address: string | null;
    comment: string | null;
};

export type ProductUnitStatus = {
    id: string;
    name: string;
    comment: string | null;
};

export type ProductUnit = {
    id: string;
    productSupplyId: string | null;
    offerId: string | null;
    warehouseId: string;
    reserved: boolean;
    sowingDate: string | null;
    productUnitStatusId: string;
    comments: string;
    qrCode: string | null;
};

export type ProductSupply = {
    id: string;
    supplierId: string | null;
    offerId: string | null;
    productUnitIds: string[];
    declaredQuantity: number;
    actualQuantity: number;
    unitPurchasePriceInKopecks: number | null;
    totalPurchasePriceInKopecks: number | null;
    comment: string;
    misGraded: boolean;
    createdAt: string;
    updatedAt: string | null;
};

export type OfferOption = {
    id: string;
    sku: string;
    formFactor: string | null;
    size: string | null;
};

export type ProductOption = {
    id: string;
    name: string;
    offers: OfferOption[];
};

export type ProductUnitFilters = {
    offerId: string | null;
    warehouseId: string | null;
    productUnitStatusId: string | null;
    productSupplyId: string | null;
};

export type SupplierFormData = {
    name: string;
    phone: string | null;
    email: string | null;
    address: string | null;
    comment: string | null;
};

export type StatusFormData = {
    name: string;
    comment: string | null;
};

export type ProductUnitFormData = {
    productSupplyId: string | null;
    offerId: string | null;
    warehouseId: string;
    reserved: boolean;
    sowingDate: string | null;
    productUnitStatusId: string;
    comments: string;
    qrCode: string | null;
};

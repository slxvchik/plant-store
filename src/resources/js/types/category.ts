export type Category = {
    id: string;
    parent: Category | null;
    alias: string;
    sort: number;
    name: string;
    active: boolean;
};

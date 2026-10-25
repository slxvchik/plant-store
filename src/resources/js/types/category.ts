export type Category = {
    id: string;
    parent?: Category;
    alias: string;
    sort: bigint;
    name: string;
    active: boolean;
}

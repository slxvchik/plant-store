export type User = {
    id: string;
    firstName: string;
    lastName: string | null;
    email: string;
    emailConfirmed: boolean;
    phone: string;
    imageId: string | null;
    roles: string[];
    createdAt: string;
    updatedAt: string;
};

export type UserFormState = {
    firstName: string;
    lastName: string;
    email: string;
    phone: string;
    password: string;
    emailConfirmed: boolean;
    roles: string[];
};

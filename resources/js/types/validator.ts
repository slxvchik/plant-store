export type ValidatorResponse = {
    success: boolean;
    errorMessage: string | null;
};

export type ValidatorFunc = (value: any) => ValidatorResponse;
export type ValidatorFactory = (param: number) => ValidatorFunc;

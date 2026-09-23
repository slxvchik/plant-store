import { twMerge } from "tailwind-merge";

export function twClassMerge(...inputs: Array<string>) {
    return twMerge(inputs.join(' '));
}
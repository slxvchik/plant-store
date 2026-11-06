export type StorefrontProduct = {
    id: string;
    name: string;
    latinName: string;
    category: string;
    price: number;
    oldPrice?: number;
    image: string;
    tag?: string;
    rating: number;
    reviews: number;
    light: 'Тень' | 'Полутень' | 'Яркий свет';
    size: 'Компактное' | 'Среднее' | 'Крупное';
    description: string;
    inStock?: boolean;
};

export const storefrontProducts: StorefrontProduct[] = [
    {
        id: 'monstera-deliciosa',
        name: 'Монстера деликатесная',
        latinName: 'Monstera deliciosa',
        category: 'Комнатные растения',
        price: 3890,
        oldPrice: 4490,
        image: '/images/slide_1.avif',
        tag: 'Выбор садовода',
        rating: 4.9,
        reviews: 124,
        light: 'Полутень',
        size: 'Крупное',
        description:
            'Выразительная монстера с резными листьями и развитой корневой системой.',
    },
    {
        id: 'ficus-lyrata',
        name: 'Фикус лировидный',
        latinName: 'Ficus lyrata',
        category: 'Комнатные растения',
        price: 5290,
        image: '/images/slide_2.avif',
        tag: 'Новинка',
        rating: 4.8,
        reviews: 86,
        light: 'Яркий свет',
        size: 'Крупное',
        description:
            'Скульптурное растение с крупными фактурными листьями для светлого интерьера.',
    },
    {
        id: 'calathea-orbifolia',
        name: 'Калатея орбифолия',
        latinName: 'Calathea orbifolia',
        category: 'Декоративно-лиственные',
        price: 2790,
        image: '/images/water_lily.png',
        rating: 4.9,
        reviews: 63,
        light: 'Полутень',
        size: 'Среднее',
        description:
            'Нежные серебристо-зелёные листья создают спокойный природный акцент.',
    },
    {
        id: 'olive-tree',
        name: 'Олива европейская',
        latinName: 'Olea europaea',
        category: 'Деревья',
        price: 6490,
        oldPrice: 6990,
        image: '/images/slide_2.avif',
        tag: 'Редкий сорт',
        rating: 5,
        reviews: 41,
        light: 'Яркий свет',
        size: 'Крупное',
        description:
            'Средиземноморское настроение, серебристая крона и неспешный рост.',
    },
    {
        id: 'zamioculcas',
        name: 'Замиокулькас',
        latinName: 'Zamioculcas zamiifolia',
        category: 'Комнатные растения',
        price: 2190,
        image: '/images/blog_1.png',
        rating: 4.7,
        reviews: 98,
        light: 'Тень',
        size: 'Среднее',
        description: 'Неприхотливое растение с плотными глянцевыми листьями.',
    },
    {
        id: 'philodendron',
        name: 'Филодендрон сканденс',
        latinName: 'Philodendron scandens',
        category: 'Ампельные растения',
        price: 1890,
        image: '/images/slide_1.avif',
        tag: 'Легкий уход',
        rating: 4.8,
        reviews: 72,
        light: 'Полутень',
        size: 'Компактное',
        description:
            'Гибкие побеги и бархатные листья для полок и подвесных кашпо.',
    },
    {
        id: 'strelitzia',
        name: 'Стрелитция Николая',
        latinName: 'Strelitzia nicolai',
        category: 'Декоративно-лиственные',
        price: 4590,
        image: '/images/slide_2.avif',
        rating: 4.9,
        reviews: 55,
        light: 'Яркий свет',
        size: 'Крупное',
        description:
            'Архитектурное тропическое растение для просторных солнечных комнат.',
    },
    {
        id: 'peperomia',
        name: 'Пеперомия арбузная',
        latinName: 'Peperomia argyreia',
        category: 'Комнатные растения',
        price: 1490,
        image: '/images/water-lily.png',
        tag: 'Компактное',
        rating: 4.6,
        reviews: 39,
        light: 'Полутень',
        size: 'Компактное',
        description:
            'Миниатюрное растение с узорчатыми листьями для рабочего стола.',
        inStock: false,
    },
];

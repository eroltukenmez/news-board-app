export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at?: string;
    feed: {
        sources:string[],
        categories:string[],
    };
}

export interface News {
    title:string
    content:string
    image:string
    date:string
    categories:string[]
    tags:string[]
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
    app_name: string
    news_sources: {[source:string]:string}
};

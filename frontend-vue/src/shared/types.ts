export interface IChannel {
    id: number;
    title: string;
    user_id: number;
}

export interface IUser {
    id: number;
    name: string;
}

export interface IMessage {
    id: number;
    content: string;
    author: string;
    created_at: string;
}

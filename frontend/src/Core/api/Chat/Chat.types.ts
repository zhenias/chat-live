import ResponseTypes, {ResponsePaginatorTypes} from '../Response.types';

export default interface ChatTypes {
  id: number,
  name: string,
  is_group: boolean,
  created_by: {
    id: number,
    name: string,
    photo_url?: string|null,
  }
}

export default interface ChatTypesResponse extends ResponseTypes {
  data: ChatTypes[]
}

export interface ChatMessageTypes {
  id: number,
  chat_id: number,
  user_id: number,
  message: string,
  created_at: string,
  updated_at: string,
  user: {
    id: number,
    name: string,
    photo_url: string|null,
  }
}

export interface ChatMessageResponse extends ResponsePaginatorTypes {
  data: ChatMessageTypes[]
}

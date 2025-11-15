import ResponseTypes from '../Response.types';

// {
//   "id": 2,
//   "name": "Verlie Rippin",
//   "is_group": false,
//   "created_by": {
//   "id": 1,
//     "name": "Dump",
//     "photo_url": "http:\/\/127.0.0.1:8000\/storage\/photos\/Rx3g7HkySVEmjx604iQs8LhX5RdV8PuRBVYS7HG2.png"
// }
// },
export default interface ChatResponse {
  id: number,
  name: string,
  is_group: boolean,
  created_by: {
    id: number,
    name: string,
    photo_url: string|null,
  }
}

export default interface ChatTypes extends ResponseTypes {
  data: ChatResponse[]
}

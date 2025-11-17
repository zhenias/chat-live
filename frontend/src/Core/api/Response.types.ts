export default interface ResponseTypes {
  status: string,
  message: string,
  data: {},
}

export interface ResponsePaginatorLinksTypes {
  url: string|null,
  label: string,
  page: number|null,
  active: boolean
}

export interface ResponsePaginatorTypes {
  current_page: number,
  data: {},
  first_page_url: string|null,
  from: number,
  last_page: number,
  last_page_url: string|null,
  links: ResponsePaginatorLinksTypes[],
  next_page_url: string|null,
  path: string,
  per_page: number,
  prev_page_url: string|null,
  to: number,
  total: number,
}

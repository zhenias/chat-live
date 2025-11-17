export default interface LoginWithPasswordResponse {
  token_type: string;
  expires_in: number;
  access_token: string;
  refresh_token: string;
}

export default interface TokenDataResponse {
  access_token: string;
  refresh_token: string;
  expires_in: number;
}

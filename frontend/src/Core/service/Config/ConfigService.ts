import EnvironmentsLocal from '../../../environments/environments.local';

export class ConfigService extends EnvironmentsLocal {
  override url: string = 'http://127.0.0.1:8000';
  override apiUrl: string = this.url + "/api";

  override clientId: string = '019a7e94-0b5d-7303-b9e8-78fc9e62438e';
  override clientSecret: string = 'OuRlKumNo7433hcCwttGEbmZ8gYgwghU7Pwl5Lka';
}

import pick from 'lodash/pick';
import values from 'lodash/values';

export type ValidationError = [message: string];

export type ValidationErrors = Record<string, ValidationError>;

export class Errors {
  private errors: ValidationErrors;

  constructor() {
    this.errors = {};
  }

  get(field: string | string[]): string | string[] | undefined {
    if (!Array.isArray(field)) return this.errors[field]?.[0];

    return values(pick(this.errors, field)).flat();
  }

  has(field: string): boolean {
    return Object.prototype.hasOwnProperty.call(this.errors, field);
  }

  all(): ValidationErrors {
    return this.errors;
  }

  record(errors?: ValidationErrors): void {
    if (typeof errors !== 'undefined') this.errors = errors;
  }

  clear(field?: string | string[]): void {
    if (Array.isArray(field)) {
      field.forEach((item) => delete this.errors[item]);
      return;
    }

    if (field) {
      const { [field]: discard, ...rest } = this.errors;
      this.errors = { ...rest };
      return;
    }

    this.errors = {};
  }

  any(): boolean {
    return !!Object.keys(this.errors).length;
  }
}

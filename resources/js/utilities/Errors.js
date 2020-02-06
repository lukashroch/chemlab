import pick from 'lodash/pick';
import values from 'lodash/values';

class Errors {
  constructor() {
    this.errors = {};
  }

  get(field) {
    if (!Array.isArray(field)) field = [field];

    return values(pick(this.errors, field)).flat();
  }

  has(field) {
    return Object.prototype.hasOwnProperty.call(this.errors, field);
  }

  record(errors) {
    if (typeof errors !== 'undefined') this.errors = errors;
  }

  clear(field) {
    if (Array.isArray(field)) {
      field.forEach(item => delete this.errors[item]);
      return;
    }

    if (field) {
      delete this.errors[field];
      return;
    }

    this.errors = {};
  }

  any() {
    return Object.keys(this.errors).length > 0;
  }
}

export default Errors;

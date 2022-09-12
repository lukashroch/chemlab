import cloneDeep from 'lodash/cloneDeep';
import pick from 'lodash/pick';

import apiSvc from '@/services/api.service';
import store from '@/store';

import { Errors } from './errors';

export default class {
  constructor(data, config = {}) {
    this.originalData = cloneDeep(data);
    this.originalKeys = Object.keys(data);

    this.errors = new Errors();

    this.config = {
      multipart: false,
      resetOnSubmit: true,
      ...config,
    };

    this.assign(data);
  }

  assign(source) {
    return this.assignTo(this, source);
  }

  assignTo(target, source) {
    const obj = target;

    this.originalKeys.forEach((key) => {
      if (typeof source[key] === 'undefined') {
        obj[key] = this.originalData[key];
        return;
      }

      if (Object.prototype.toString.call(this.originalData[key]) === '[object Object]') {
        if (source[key] === null) obj[key] = { ...this.originalData[key] };
        else {
          const keys = Object.keys(this.originalData[key]);
          obj[key] = keys.length ? pick(source[key], keys) : { ...source[key] };
        }

        return;
      }

      obj[key] = source[key];
    });

    return obj;
  }

  update(source) {
    this.originalKeys.forEach((key) => {
      if (!(key in source)) return;

      if (Object.prototype.toString.call(this.originalData[key]) === '[object Object]') {
        const keys = Object.keys(this.originalData[key]);
        this[key] = keys.length ? pick(source[key], keys) : { ...source[key] };
        return;
      }

      this[key] = source[key];
    });
  }

  settings(field, value) {
    if (typeof value === 'undefined') return this.config[field];

    this.config[field] = value;
  }

  data() {
    if (this.settings('multipart') === false) return this.assignTo({}, this);

    const data = new FormData();

    this.originalKeys.forEach((key) => {
      if (Array.isArray(this[key])) {
        this[key].forEach((value) => data.append(`${key}[]`, value === null ? '' : value));
      } else data.append(key, this[key] === null ? '' : this[key]);
    });

    return data;
  }

  load(data) {
    this.reset();
    this.assign(data);
  }

  hasErrors() {
    return this.errors.any();
  }

  reset() {
    this.assign(this.originalData);
    this.errors.clear();
  }

  async post(url, config = {}) {
    return this.submit('post', url, config);
  }

  async get(url, config = {}) {
    return this.submit('get', url, config);
  }

  async patch(url, config = {}) {
    return this.submit('patch', url, config);
  }

  async put(url, config = {}) {
    return this.submit('put', url, config);
  }

  async submit(method, url, config = {}) {
    const { withErr, ...rest } = config;
    const loadStr = `form-${url}`;
    await store.dispatch('loading/add', loadStr);

    return new Promise((resolve, reject) => {
      const formData = this.data();

      // Spoof PUT/PATCH methods for Laravel
      if (this.settings('multipart') === true && ['put', 'patch'].includes(method)) {
        formData.append('_method', method);
        method = 'post';
      }

      apiSvc
        .request(url, method, formData, { withErr: true, ...rest })
        .then((res) => {
          const { data } = res;
          this.onSuccess(data);
          resolve(data);
        })
        .catch((err) => {
          this.onFail(err);

          if (withErr) reject(err.response?.data);
        })
        .finally(() => store.dispatch('loading/remove', loadStr));
    });
  }

  onSuccess() {
    if (this.settings('resetOnSubmit') === true) this.reset();
  }

  onFail(err) {
    const { response: { status, data = {} } = {} } = err;
    if (status === 422 && 'errors' in data) this.errors.record(data.errors);
  }
}

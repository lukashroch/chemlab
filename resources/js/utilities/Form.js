import cloneDeep from 'lodash/cloneDeep';
import pick from 'lodash/pick';
import Errors from './Errors';
import store from '../store';
import apiSvc from '../services/api.service';

export default class {
  constructor(data, config = {}) {
    this.originalData = cloneDeep(data);
    this.originalKeys = Object.keys(data);

    this.errors = new Errors();

    this.config = {
      status: null,
      multipart: false,
      resetOnSubmit: true,
      ...config
    };

    this.assign(data);
  }

  assign(source) {
    return this.assignTo(this, source);
  }

  assignTo(target, source) {
    const obj = target;

    this.originalKeys.forEach(key => {
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

  settings(field, value) {
    if (typeof value === 'undefined') return this.config[field];

    this.config[field] = value;
  }

  data() {
    if (this.settings('multipart') === false) {
      return this.assignTo({}, this);
    }

    const data = new FormData();

    this.originalKeys.forEach(key => {
      if (Array.isArray(this[key])) {
        this[key].forEach(value => data.append(`${key}[]`, value === null ? '' : value));
      } else data.append(key, this[key] === null ? '' : this[key]);
    });

    return data;
  }

  load(data, status) {
    this.reset();
    this.settings('status', status);
    this.assign(data);
  }

  canSubmit() {
    return !this.errors.any();
  }

  reset() {
    this.assign(this.originalData);
    this.errors.clear();
  }

  post(url, config = {}) {
    return this.submit('post', url, config);
  }

  get(url, config = {}) {
    return this.submit('get', url, config);
  }

  patch(url, config = {}) {
    return this.submit('patch', url, config);
  }

  put(url, config = {}) {
    return this.submit('put', url, config);
  }

  submit(method, url, config = {}) {
    const { withErr, ...rest } = config;
    const loadStr = `form-${url}`;
    store.commit('loading/add', loadStr);

    return new Promise((resolve, reject) => {
      const data = this.data();

      // Spoof PUT/PATCH methods for Laravel
      if (this.settings('multipart') === true && ['put', 'patch'].includes(method)) {
        data.append('_method', method);
        method = 'post';
      }

      apiSvc
        .request(url, method, data, { withErr: true, ...rest })
        .then(res => {
          this.onSuccess(res.data);
          resolve(res.data);
        })
        .catch(err => {
          this.onFail(err);

          if (withErr) reject(err.response.data);
        })
        .finally(() => store.commit('loading/remove', loadStr));
    });
  }

  onSuccess() {
    if (this.settings('resetOnSubmit') === true) this.reset();
  }

  onFail(err) {
    const { response: res } = err;
    if (res && res.status === 422 && 'errors' in res.data) this.errors.record(res.data.errors);
  }
}

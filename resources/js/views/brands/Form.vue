<template>
  <div class="tab-pane active">
    <form @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">
      <div class="card-body">
        <div class="form-group form-row">
          <label for="name" class="col-md-3 col-form-label">{{ $t('common.name') }}</label>
          <div class="col-md-9 col-lg-6">
            <input
              id="name"
              v-model="form.name"
              type="text"
              name="name"
              class="form-control"
              :placeholder="$t('common.name')"
            />
            <error :msg="form.errors.get('name')"></error>
          </div>
        </div>
        <div class="form-group form-row">
          <label for="surname" class="col-md-3 col-form-label">{{
            $t('brands.url.product')
          }}</label>
          <div class="col-md-9 col-lg-6">
            <input
              id="url_product"
              v-model="form.url_product"
              type="text"
              name="url_product"
              class="form-control"
              :placeholder="$t('brands.url.product')"
            />
            <error :msg="form.errors.get('url_product')"></error>
          </div>
        </div>
        <div class="form-group form-row">
          <label for="surname" class="col-md-3 col-form-label">{{ $t('brands.url.sds') }}</label>
          <div class="col-md-9 col-lg-6">
            <input
              id="url_sds"
              v-model="form.url_sds"
              type="text"
              name="url_sds"
              class="form-control"
              :placeholder="$t('brands.url.sds')"
            />
            <error :msg="form.errors.get('url_sds')"></error>
          </div>
        </div>
        <div class="form-group form-row">
          <label for="surname" class="col-md-3 col-form-label">{{
            $t('brands.parse_callback')
          }}</label>
          <div class="col-md-9 col-lg-6">
            <input
              id="parse_callback"
              v-model="form.parse_callback"
              type="text"
              name="parse_callback"
              class="form-control"
              :placeholder="$t('brands.parse_callback')"
            />
            <error :msg="form.errors.get('parse_callback')"></error>
          </div>
        </div>
        <div class="form-group form-row">
          <label for="description" class="col-form-label col-md-3">{{
            $t('common.description')
          }}</label>
          <div class="col-md-9 col-lg-6">
            <textarea
              id="description"
              v-model="form.description"
              name="description"
              class="form-control"
              rows="4"
              :placeholder="$t('common.description')"
            ></textarea>
            <error :msg="form.errors.get('description')"></error>
          </div>
        </div>
      </div>
      <submit-footer :disabled="form.errors.any()"></submit-footer>
    </form>
  </div>
</template>

<script>
import Form from '../../utilities/Form';
import FormMixin from '../generic/FormMixin';

export default {
  name: 'Form',

  mixins: [FormMixin],

  data() {
    return {
      form: new Form({
        id: null,
        name: null,
        url_product: null,
        url_sds: null,
        parse_callback: null,
        description: null
      })
    };
  }
};
</script>

<style scoped></style>

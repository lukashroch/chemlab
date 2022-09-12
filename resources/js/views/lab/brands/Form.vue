<template>
  <div class="tab-pane active">
    <form @keydown="form.errors.clear($event.target.name)" @submit.prevent="onSubmit">
      <div class="card-body">
        <div class="form-group form-row">
          <label class="col-md-3 col-form-label" for="name">{{ $t('common.name') }}</label>
          <div class="col-md-9 col-lg-6">
            <input
              id="name"
              v-model="form.name"
              class="form-control"
              name="name"
              :placeholder="$t('common.name')"
              type="text"
            />
            <error :msg="form.errors.get('name')"></error>
          </div>
        </div>
        <div class="form-group form-row">
          <label class="col-md-3 col-form-label" for="url_product">{{
            $t('brands.url.product')
          }}</label>
          <div class="col-md-9 col-lg-6">
            <input
              id="url_product"
              v-model="form.url_product"
              class="form-control"
              name="url_product"
              :placeholder="$t('brands.url.product')"
              type="text"
            />
            <error :msg="form.errors.get('url_product')"></error>
          </div>
        </div>
        <div class="form-group form-row">
          <label class="col-md-3 col-form-label" for="url_sds">{{ $t('brands.url.sds') }}</label>
          <div class="col-md-9 col-lg-6">
            <input
              id="url_sds"
              v-model="form.url_sds"
              class="form-control"
              name="url_sds"
              :placeholder="$t('brands.url.sds')"
              type="text"
            />
            <error :msg="form.errors.get('url_sds')"></error>
          </div>
        </div>
        <div class="form-group form-row">
          <label class="col-md-3 col-form-label" for="parse_callback">{{
            $t('brands.parse_callback')
          }}</label>
          <div class="col-md-9 col-lg-6">
            <input
              id="parse_callback"
              v-model="form.parse_callback"
              class="form-control"
              name="parse_callback"
              :placeholder="$t('brands.parse_callback')"
              type="text"
            />
            <error :msg="form.errors.get('parse_callback')"></error>
          </div>
        </div>
        <div class="form-group form-row">
          <label class="col-form-label col-md-3" for="description">{{
            $t('common.description')
          }}</label>
          <div class="col-md-9 col-lg-6">
            <textarea
              id="description"
              v-model="form.description"
              class="form-control"
              name="description"
              :placeholder="$t('common.description')"
              rows="4"
            ></textarea>
            <error :msg="form.errors.get('description')"></error>
          </div>
        </div>
      </div>
      <submit-footer :disabled="form.hasErrors()"></submit-footer>
    </form>
  </div>
</template>

<script>
import FormMixin from '@/views/generic/FormMixin';
import Form from '@/utilities/Form';

export default {
  name: 'BrandForm',

  mixins: [FormMixin],

  data() {
    return {
      form: new Form({
        id: null,
        name: null,
        url_product: null,
        url_sds: null,
        parse_callback: null,
        description: null,
      }),
    };
  },
};
</script>

<style lang="scss" scoped></style>

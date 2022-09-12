<template>
  <div class="tab-pane active">
    <form @keydown="form.errors.clear($event.target.name)" @submit.prevent="onSubmit">
      <div class="card-body">
        <div class="form-group form-row">
          <label class="col-md-3 col-form-label" for="name">{{
            $t('common.title_internal')
          }}</label>
          <div class="col-md-9 col-lg-6">
            <input
              id="name"
              v-model="form.name"
              class="form-control"
              :disabled="isEdit"
              name="name"
              :placeholder="$t('common.title_internal')"
              type="text"
            />
            <error :msg="form.errors.get('name')"></error>
          </div>
        </div>
        <div class="form-group form-row">
          <label class="col-md-3 col-form-label" for="display_name">{{ $t('common.title') }}</label>
          <div class="col-md-9 col-lg-6">
            <input
              id="display_name"
              v-model="form.display_name"
              class="form-control"
              name="display_name"
              :placeholder="$t('common.title')"
              type="text"
            />
            <error :msg="form.errors.get('display_name')"></error>
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
import Form from '@/utilities/Form';
import FormMixin from '@/views/generic/FormMixin';

export default {
  mixins: [FormMixin],

  data() {
    return {
      form: new Form({
        id: null,
        name: null,
        display_name: null,
        description: null,
      }),
    };
  },
};
</script>

<style lang="scss" scoped></style>

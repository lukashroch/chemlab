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
        <hr />
        <div class="form-group">
          <label class="col-form-label" for="permissions">{{ $t('permissions.title') }}</label>
          <div id="permissions" class="form-row">
            <div v-for="(pModule, key) in refs.permissions" :key="key" class="col-md-4 px-3 mb-3">
              <div class="border rounded p-3">
                <h6>{{ key === 'general' ? $t('common.misc') : $t(`${key}.index`) }}</h6>
                <div
                  v-for="perm in pModule"
                  :key="perm.id"
                  class="custom-control custom-checkbox mb-2"
                >
                  <input
                    :id="`permission_${perm.id}`"
                    v-model="form.permissions"
                    class="custom-control-input"
                    :disabled="!can(perm.name)"
                    name="permissions"
                    type="checkbox"
                    :value="perm.id"
                  />
                  <label class="custom-control-label" :for="`permission_${perm.id}`">{{
                    perm.display_name
                  }}</label>
                </div>
              </div>
            </div>
          </div>
          <error :msg="form.errors.get('permissions')"></error>
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
  mixins: [FormMixin],

  data() {
    return {
      form: new Form({
        id: null,
        name: null,
        display_name: null,
        description: null,
        permissions: [],
      }),
    };
  },

  methods: {
    toForm(data) {
      const { permissions } = data;
      const obj = {
        ...data,
        permissions:
          permissions && Array.isArray(permissions) ? permissions.map((item) => item.id) : [],
      };

      this.form.load(obj);
    },
  },
};
</script>

<style lang="scss" scoped></style>

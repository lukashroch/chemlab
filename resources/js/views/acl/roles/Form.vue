<template>
  <div class="tab-pane active">
    <form @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">
      <div class="card-body">
        <div class="form-group form-row">
          <label for="name" class="col-md-3 col-form-label">{{
            $t('common.title_internal')
          }}</label>
          <div class="col-md-9 col-lg-6">
            <input
              id="name"
              v-model="form.name"
              type="text"
              name="name"
              class="form-control"
              :placeholder="$t('common.title_internal')"
              :disabled="isEdit"
            />
            <error :msg="form.errors.get('name')"></error>
          </div>
        </div>
        <div class="form-group form-row">
          <label for="display_name" class="col-md-3 col-form-label">{{ $t('common.title') }}</label>
          <div class="col-md-9 col-lg-6">
            <input
              id="display_name"
              v-model="form.display_name"
              type="text"
              name="display_name"
              class="form-control"
              :placeholder="$t('common.title')"
            />
            <error :msg="form.errors.get('display_name')"></error>
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
        <hr />
        <div class="form-group">
          <label for="permissions" class="col-form-label">{{ $t('permissions.title') }}</label>
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
                    type="checkbox"
                    name="permissions"
                    class="custom-control-input"
                    :value="perm.id"
                    :disabled="!can(perm.name)"
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
import Form from '../../../utilities/Form';
import FormMixin from '../../generic/FormMixin';

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

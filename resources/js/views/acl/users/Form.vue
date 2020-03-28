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
          <label for="surname" class="col-md-3 col-form-label">{{ $t('common.email') }}</label>
          <div class="col-md-9 col-lg-6">
            <input
              id="email"
              v-model="form.email"
              type="text"
              name="email"
              class="form-control"
              :placeholder="$t('common.email')"
            />
            <error :msg="form.errors.get('email')"></error>
          </div>
        </div>
        <div class="form-group">
          <label for="roles" class="col-md-3 col-form-label text-left">{{
            $t('roles.index')
          }}</label>
          <div class="form-row">
            <div v-for="team in refs.teams" :key="team.id" class="col-md-4 px-3 mb-3">
              <div class="border rounded p-3">
                <h6>{{ team.display_name }}</h6>
                <div
                  v-for="role in team.roles"
                  :key="role.id"
                  class="custom-control custom-checkbox mb-2"
                >
                  <input
                    :id="`role_${team.id}_${role.id}`"
                    v-model="form.roles[team.name]"
                    type="checkbox"
                    class="custom-control-input"
                    :value="role.name"
                  />
                  <label :for="`role_${team.id}_${role.id}`" class="custom-control-label">{{
                    role.display_name
                  }}</label>
                </div>
              </div>
            </div>
            <error :msg="form.errors.get('roles')"></error>
          </div>
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
  name: 'Form',

  mixins: [FormMixin],

  data() {
    return {
      form: new Form({
        id: null,
        name: null,
        email: null,
        roles: {},
      }),
    };
  },
};
</script>

<style lang="scss" scoped></style>

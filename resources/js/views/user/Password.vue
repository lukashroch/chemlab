<template>
  <div class="container-center">
    <div class="card component-center">
      <div class="card-header">
        <h6 class="mt-4">{{ $t('users.password.change') }}</h6>
      </div>
      <form @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">
        <div class="card-body">
          <div class="form-group">
            <label v-t="'users.password.current'" for="password_current"></label>
            <input
              id="password_current"
              v-model="form.password_current"
              type="password"
              name="password_current"
              class="form-control"
              :placeholder="$t('users.password.current')"
            />
            <error :msg="form.errors.get('password_current')"></error>
          </div>
          <div class="form-group">
            <label v-t="'users.password.new'" for="password"></label>
            <input
              id="password"
              v-model="form.password"
              type="password"
              name="password"
              class="form-control"
              :placeholder="$t('users.password.new')"
            />
            <error :msg="form.errors.get('password')"></error>
          </div>
          <div class="form-group">
            <label v-t="'users.password.confirmation'" for="password_confirmation"></label>
            <input
              id="password_confirmation"
              v-model="form.password_confirmation"
              type="password"
              name="password_confirmation"
              class="form-control"
              :placeholder="$t('users.password.confirmation')"
            />
            <error :msg="form.errors.get('password_confirmation')"></error>
          </div>
        </div>
        <submit-footer
          :disabled="form.hasErrors()"
          :title="$t('users.password.change')"
        ></submit-footer>
      </form>
    </div>
  </div>
</template>

<script>
import Form from '../../utilities/Form';
import Error from '../../components/forms/Error';
import SubmitFooter from '../../components/forms/SubmitFooter.vue';

export default {
  name: 'Profile',

  components: { Error, SubmitFooter },

  data() {
    return {
      form: new Form({
        password_current: null,
        password: null,
        password_confirmation: null
      })
    };
  },

  methods: {
    async onSubmit() {
      await this.form.post('profile/password');
      this.$router.push({ name: 'profile' });
      this.$toasted.success(this.$t(`users.password.changed`));
    }
  }
};
</script>

<style lang="scss" scoped>
.container-center {
  width: 100%;
  display: flex;
  justify-content: center;
}

.component-center {
  width: 30rem;
}
</style>

<template>
  <div class="card">
    <div class="card-header">
      <h6 class="mt-4">{{ $t('profile.settings._') }}</h6>
    </div>
    <div class="card-body">
      <div class="form-group form-row">
        <label class="col-form-label col-sm-5 col-md-4">{{ $t('common.name') }}</label>
        <div class="col-sm-7 col-md-4">
          <div class="form-control-plaintext">{{ profile.name }}</div>
        </div>
      </div>
      <div class="form-group form-row">
        <label class="col-form-label col-sm-5 col-md-4">{{ $t('common.email') }}</label>
        <div class="col-sm-7 col-md-4">
          <div class="form-control-plaintext">{{ profile.email }}</div>
        </div>
      </div>
      <div class="form-group form-row">
        <label class="col-form-label col-sm-5 col-md-4">{{ $t('users.password.change') }}</label>
        <div class="col-sm-7 col-md-4">
          <div class="form-control-plaintext">
            <router-link tag="a" :to="{ name: 'profile.password' }"
              >{{ $t('users.password.change') }}
            </router-link>
          </div>
        </div>
      </div>
      <div class="form-group form-row">
        <label class="col-form-label col-sm-5 col-md-4">{{ $t('profile.settings.lang') }}</label>
        <div class="col-sm-7 col-md-4">
          <select
            id="lang"
            v-model="form.lang"
            name="lang"
            class="form-control custom-select"
            @change="update($event.target.name)"
          >
            <option v-for="(lang, key) in langs" :key="key" :value="key">
              {{ lang }}
            </option>
          </select>
        </div>
      </div>
      <div class="form-group form-row">
        <label class="col-form-label col-sm-5 col-md-4">{{ $t('profile.settings.listing') }}</label>
        <div class="col-sm-7 col-md-4">
          <select
            id="listing"
            v-model="form.listing"
            name="listing"
            class="form-control custom-select"
            @change="update($event.target.name)"
          >
            <option v-for="number in [10, 25, 50, 100]" :key="number" :value="number">
              {{ number }}
            </option>
          </select>
        </div>
      </div>
    </div>
    <hr />
    <div v-if="socials.length">
      <h6 class="mt-4">{{ $t('profile.socials._') }}</h6>
      <ul class="list-group">
        <li
          v-for="(social, idx) in socials"
          v-show="socials.length"
          :key="idx"
          class="list-group-item list-group-item-action align-items-center justify-content-between d-flex"
        >
          <div :class="`h4 text-capitalize my-0 text-${social.provider}`">
            <span :class="`fab fa-fw fa-${social.provider}`"></span>
            {{ social.provider }}
          </div>
          <div>
            <button class="btn btn-outline-danger" @click="unlink(social.provider)">
              <span class="fas fa-fw fa-unlink"></span>
              {{ $t('profile.socials.unlink') }}
            </button>
          </div>
        </li>
      </ul>
      <hr />
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import Form from '../../utilities/Form';

export default {
  name: 'Profile',

  data() {
    return {
      form: {
        lang: null,
        listing: null
      },
      langs: {
        cs: this.$t('profile.settings.langs.cs'),
        en: this.$t('profile.settings.langs.en')
      },
      socials: []
    };
  },

  computed: mapGetters('user', ['profile']),

  watch: {
    profile: {
      handler(val) {
        const { settings, socials } = val;
        this.form = new Form({ ...settings });
        this.socials = socials;
      },
      immediate: true
    }
  },

  methods: {
    ...mapActions('user', ['request']),

    async update(name) {
      await this.request({ key: name, value: this.form[name] });

      if (name === 'lang') this.$i18n.locale = this.form[name];

      this.$toasted.success(this.$t('profile.settings.saved'));
    },

    async unlink(provider) {
      if (!confirm(this.$t('profile.msg.social_unlink', { provider }))) {
        return;
      }
      await this.$http.delete(`profile/socials/${provider}`);
      this.socials = this.socials.filter(item => item.provider !== provider);
      this.$toasted.success(this.$t('profile.msg.social_unlinked', { provider }));
    }
  }
};
</script>

<style lang="scss" scoped></style>

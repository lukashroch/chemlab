<template>
  <div v-if="profile" class="card">
    <div class="card-header">
      <h6 class="mt-4">{{ $t('profile.settings._') }}</h6>
    </div>
    <div class="card-body">
      <div class="row mb-3">
        <label class="col-form-label col-sm-5 col-md-4">{{ $t('common.name') }}</label>
        <div class="col-sm-7 col-md-4">
          <div class="form-control-plaintext">{{ profile.name }}</div>
        </div>
      </div>
      <div class="row mb-3">
        <label class="col-form-label col-sm-5 col-md-4">{{ $t('common.email') }}</label>
        <div class="col-sm-7 col-md-4">
          <div class="form-control-plaintext">{{ profile.email }}</div>
        </div>
      </div>
      <div class="row mb-3">
        <label class="col-form-label col-sm-5 col-md-4">{{ $t('users.password.change') }}</label>
        <div class="col-sm-7 col-md-4">
          <div class="form-control-plaintext">
            <router-link :to="{ name: 'profile.password' }">
              <a>{{ $t('users.password.change') }}</a>
            </router-link>
          </div>
        </div>
      </div>
      <div class="row mb-3">
        <label class="col-form-label col-sm-5 col-md-4">{{ $t('profile.settings.lang') }}</label>
        <div class="col-sm-7 col-md-4">
          <select
            id="lang"
            v-model="form.lang"
            class="form-select"
            name="lang"
            @change="updateProfile($event.target.name)"
          >
            <option v-for="(lang, key) in langs" :key="key" :value="key">
              {{ lang }}
            </option>
          </select>
        </div>
      </div>
      <div class="row mb-3">
        <label class="col-form-label col-sm-5 col-md-4">{{ $t('profile.settings.listing') }}</label>
        <div class="col-sm-7 col-md-4">
          <select
            id="listing"
            v-model="form.listing"
            class="form-select"
            name="listing"
            @change="updateProfile($event.target.name)"
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
          v-for="social in socials"
          v-show="socials.length"
          :key="social.provider"
          class="list-group-item list-group-item-action align-items-center justify-content-between d-flex"
        >
          <div :class="`h4 text-capitalize my-0 text-${social.provider}`">
            <span :class="`fab fa-fw fa-${social.provider}`"></span>
            {{ social.provider }}
          </div>
          <div>
            <button class="btn btn-outline-danger" @click="unlink(social.provider)">
              <span class="fas fa-unlink"></span>
              {{ $t('profile.socials.unlink') }}
            </button>
          </div>
        </li>
      </ul>
      <hr />
    </div>
  </div>
</template>

<script lang="ts">
import { mapActions, mapState } from 'pinia';
import { defineComponent } from 'vue';

import { useMessages, useUser } from '@/stores';
import { createForm } from '@/util';

export default defineComponent({
  name: 'UserProfile',

  data() {
    return {
      form: createForm({
        lang: null,
        listing: null,
      }),
      langs: {
        cs: this.$t('profile.settings.langs.cs'),
        en: this.$t('profile.settings.langs.en'),
      },
      socials: [] as { provider: string }[],
    };
  },

  computed: mapState(useUser, ['profile']),

  watch: {
    profile: {
      handler(val) {
        const { settings, socials } = val;
        this.form.load({ ...settings });
        this.socials = socials;
      },
      immediate: true,
    },
  },

  methods: {
    ...mapActions(useUser, ['update']),

    async updateProfile(name: 'lang' | 'listing') {
      await this.update(name, this.form[name]);

      if (name === 'lang') this.$i18n.locale = this.form[name];

      useMessages().success(this.$t('profile.settings.saved'));
    },

    async unlink(provider: string) {
      if (!confirm(this.$t('profile.msg.social_unlink', { provider }))) {
        return;
      }
      await this.$http.delete(`profile/socials/${provider}`);
      this.socials = this.socials.filter((item) => item.provider !== provider);
      useMessages().success(this.$t('profile.msg.social_unlinked', { provider }));
    },
  },
});
</script>

<style lang="scss" scoped></style>

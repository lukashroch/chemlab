<template>
  <layout v-if="entryLoaded" v-bind="{ id, entry }">
    <div class="tab-pane active">
      <form @keydown="clearError" @submit.prevent="submit">
        <div class="card-body">
          <div class="row mb-3">
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
          <div class="row mb-3">
            <label class="col-md-3 col-form-label" for="surname">{{ $t('common.email') }}</label>
            <div class="col-md-9 col-lg-6">
              <input
                id="email"
                v-model="form.email"
                class="form-control"
                name="email"
                :placeholder="$t('common.email')"
                type="text"
              />
              <error :msg="form.errors.get('email')"></error>
            </div>
          </div>
          <div>
            <label class="h6" for="roles">{{ $t('roles.index') }}</label>
            <div id="roles" class="row">
              <div v-for="team in refs.teams" :key="team.id" class="col-md-4 px-3 mb-3">
                <div class="border rounded p-3">
                  <h6>{{ team.display_name }}</h6>
                  <div v-for="role in team.roles" :key="role.id" class="form-check mb-2">
                    <input
                      :id="`role_${team.id}_${role.id}`"
                      v-model="form.roles[team.name]"
                      class="form-check-input"
                      type="checkbox"
                      :value="role.name"
                    />
                    <label class="form-check-label" :for="`role_${team.id}_${role.id}`">
                      {{ role.display_name }}
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <error :msg="form.errors.get('roles')"></error>
          </div>
        </div>
        <submit-footer :disabled="form.hasErrors()"></submit-footer>
      </form>
    </div>
  </layout>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

import { formMixin } from '@/components/entry';
import { createForm } from '@/util';

export default defineComponent({
  name: 'UserForm',

  mixins: [formMixin],

  data() {
    return {
      form: createForm({
        id: null,
        name: null,
        email: null,
        roles: {},
      }),
    };
  },
});
</script>

<style lang="scss" scoped></style>

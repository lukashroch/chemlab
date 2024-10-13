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
  </layout>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

import { formMixin } from '@/components/entry';
import { createForm } from '@/util';

export default defineComponent({
  name: 'CategoryForm',

  mixins: [formMixin],

  data() {
    return {
      form: createForm({
        id: null,
        name: null,
        description: null,
      }),
    };
  },
});
</script>

<style lang="scss" scoped></style>

<template>
  <div class="card-footer">
    <div class="row justify-content-center">
      <div class="col-auto">
        <button
          class="btn btn-success px-3 py-2"
          :disabled="disabled || isLoading"
          :title="title"
          type="submit"
        >
          <span class="fa-fw" :class="icon"></span> {{ title }}
        </button>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { mapGetters } from 'vuex';

export default defineComponent({
  name: 'SubmitFooter',

  props: {
    title: {
      type: String,
      default() {
        return this.$t('common.save');
      },
    },
    icon: {
      type: String,
      default: 'fas fa-save',
    },
    disabled: {
      type: Boolean,
      default: false,
    },
  },

  computed: mapGetters('loading', ['isLoading']),
});
</script>

<style lang="scss" scoped></style>

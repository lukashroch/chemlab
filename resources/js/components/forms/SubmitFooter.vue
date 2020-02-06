<template>
  <div class="card-footer">
    <div class="row justify-content-center">
      <div class="col-auto">
        <button
          type="submit"
          class="btn btn-success px-3 py-2"
          :title="title"
          :disabled="disabled || isLoading"
        >
          <span class="fa-fw" :class="icon"></span> {{ title }}
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
  name: 'SubmitFooter',

  props: {
    title: {
      type: String,
      default() {
        return this.$t('common.save');
      }
    },
    icon: {
      type: String,
      default: 'fas fa-save'
    },
    disabled: {
      type: Boolean,
      default: false
    }
  },

  computed: mapGetters('loading', ['isLoading'])
};
</script>

<style scoped></style>

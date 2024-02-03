<template>
  <div class="card-footer">
    <div class="row justify-content-center">
      <div class="col-auto">
        <button
          class="btn btn-success px-3 py-2"
          :disabled="disabled || isAppLoading"
          :title="internalTitle"
          type="submit"
        >
          <span class="fa-fw" :class="icon"></span> {{ internalTitle }}
        </button>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { computed, defineComponent } from 'vue';
import { useI18n } from 'vue-i18n';

export default defineComponent({
  name: 'SubmitFooter',

  props: {
    title: {
      type: String,
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

  setup(props) {
    const { t } = useI18n();
    const internalTitle = computed(() => props.title ?? t('common.save'));

    return {
      internalTitle,
    };
  },
});
</script>

<style lang="scss" scoped></style>

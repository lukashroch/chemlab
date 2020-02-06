<template>
  <modal name="toolbar-status" height="auto">
    <div class="modal-header bg-primary">
      <h4 class="modal-title">{{ $t('common.status.change') }}</h4>
      <close name="toolbar-status"></close>
    </div>
    <form @submit.prevent="onSubmit">
      <div class="modal-body">
        <div class="form-group form-row">
          <label for="selected" class="col-12 col-sm-9 col-lg-7 col-form-label"
            >{{ $t('common.records.selected') }}
            <error :msg="form.errors.get('items')"></error>
          </label>
          <div id="selected" class="col-12 col-sm-3 col-lg-2">
            <span class="form-control text-center fw6">{{
              form.items.length ? form.items.length : $t('common.none')
            }}</span>
          </div>
        </div>
        <div class="form-group form-row">
          <label for="status" class="col-12 col-sm-auto col-lg-3 col-form-label">{{
            $t('common.status.new')
          }}</label>
          <div class="col-12 col-sm col-lg-6">
            <select
              id="status"
              v-model="form.status"
              name="status"
              :title="$t('common.status.title')"
              class="form-control custom-select"
            >
              <option v-for="(value, key) in options" :key="key" :value="key">{{ value }}</option>
            </select>
            <error :msg="form.errors.get('status')"></error>
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <div>
          <button type="submit" class="btn btn-primary" :title="$t('common.submit')">
            <span class="fas fa-fw fa-save"></span>
            {{ $t('common.submit') }}
          </button>
        </div>
      </div>
    </form>
  </modal>
</template>

<script>
import ModalMixin from './ModalMixin';
import Form from '../../utilities/Form';

export default {
  name: 'StatusModal',

  mixins: [ModalMixin],

  props: {
    field: {
      type: Object,
      required: true
    }
  },

  data() {
    const obj = {
      items: this.selected
    };
    obj[this.field.name] = this.field.default;

    return {
      form: new Form(obj)
    };
  },

  methods: {
    async onSubmit() {
      await this.form.post(`${this.$route.meta.module}/${this.field.name}`);
      this.$toasted.success(this.$t('common.status.updated'));
      this.$emit('action', 'draw');
      this.$modal.hide('toolbar-status');
    }
  }
};
</script>

<style scoped></style>

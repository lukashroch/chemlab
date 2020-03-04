<template>
  <modal :name="name" height="auto" :scrollable="true" :pivot-y="0.25">
    <div class="modal-header">
      <h4 class="modal-title">{{ $t('chemicals.items.move') }}</h4>
      <close :name="name"></close>
    </div>
    <form @submit.prevent="onSubmit">
      <div class="modal-body">
        <div class="form-group form-row justify-content-center">
          <div class="col-8 p-3 border-bottom">
            {{ $t('common.records.selected') }}:
            <span class="border rounded mx-3 px-3 p-2">{{
              form.items.length ? form.items.length : $t('common.none')
            }}</span>
            <error :msg="form.errors.get('items')"></error>
          </div>
        </div>
        <div class="form-group form-row justify-content-center">
          <div class="col-8">
            <label for="store_id">{{ $t('stores.title') }}</label>
            <select
              id="store_id"
              v-model="form.store_id"
              name="store_id"
              class="form-control custom-select"
              @change="form.errors.clear('store_id')"
            >
              <option v-for="option in options" :key="option.id" :value="option.id">
                {{ option.name }}
              </option>
            </select>
            <error :msg="form.errors.get('store_id')"></error>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" @click.stop="close()">
          <span class="fas fa-fw fa-times" :title="$t('common.cancel')"></span>
          {{ $t('common.cancel') }}
        </button>
        <button type="submit" class="btn btn-primary" :disabled="form.hasErrors()">
          <span class="fas fa-fw fa-exchange-alt" :title="$t('common.action.move')"></span>
          {{ $t('common.action.move') }}
        </button>
      </div>
    </form>
  </modal>
</template>

<script>
import Form from '../../utilities/Form';
import Error from '../forms/Error';
import ModalMixin from './ModalMixin';
import ListModalMixin from './ListModalMixin';

export default {
  name: 'ChemicalMove',

  components: { Error },

  mixins: [ModalMixin, ListModalMixin],

  data() {
    return {
      form: new Form({
        store_id: null,
        items: this.selected
      })
    };
  },

  methods: {
    async onSubmit() {
      await this.form.post(`chemical-items/move`);
      this.$toasted.success(this.$t('common.msg.multi.moved'));
      this.$emit('action', 'draw');
      this.close();
    }
  }
};
</script>

<style lang="scss"></style>

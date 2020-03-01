<template>
  <div class="form-row form-group">
    <label class="col-md-2 col-form-label">{{ `${title}` }}</label>
    <div class="col-md-10">
      <div class="form-row">
        <div v-for="(choice, idx) in choices" :key="idx" class="col-md-6">
          <div class="custom-control custom-checkbox">
            <input
              :id="name + '_' + idx"
              v-model="selected"
              type="checkbox"
              class="custom-control-input"
              :name="name"
              :value="choice"
              @change="update()"
            />
            <label class="custom-control-label" :for="name + '_' + idx">{{ choice }}</label>
          </div>
        </div>
        <div class="col-md-6">
          <div class="input-group">
            <label class="col-form-label sr-only" :for="`${name}_ext`"></label>
            <div class="input-group-prepend">
              <span class="input-group-text">{{ $t('common.other') }}</span>
            </div>
            <input
              :id="`${name}_ext`"
              v-model="custom"
              type="text"
              class="form-control"
              :name="`${name}_ext`"
              @input="update()"
            />
          </div>
        </div>
      </div>
      <error :msg="error"></error>
    </div>
  </div>
</template>

<script>
import error from './Error';

export default {
  name: 'MultiCheckbox',

  components: { error },

  props: {
    name: {
      type: String,
      required: true
    },
    title: {
      type: String,
      required: true
    },
    error: {
      type: Array,
      default() {
        return [];
      }
    },
    value: {
      type: Array,
      default() {
        return [];
      }
    },
    choices: {
      type: Array,
      required: true
    }
  },

  data() {
    const arrayVals = [];
    let inputVal = '';

    Object.keys(this.value).forEach(key => {
      const item = this.value[key];
      if (this.question.options.includes(item)) arrayVals.push(item);
      else inputVal = item;
    });

    return {
      selected: arrayVals,
      custom: inputVal
    };
  },

  methods: {
    update() {
      const output = this.selected.slice();
      if (this.custom) output.push(this.custom);

      this.$emit('input', output);
      this.$emit('change', output);
    }
  }
};
</script>

<style lang="scss" scoped></style>

<template>
  <div class="tab-pane active">
    <form @keydown="form.errors.clear($event.target.name)" @submit.prevent="onSubmit">
      <div class="card-body">
        <div class="form-group form-row">
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
        <div class="form-group form-row">
          <label class="col-md-3 col-form-label" for="abbr_name">{{
            $t('stores.abbr_name')
          }}</label>
          <div class="col-md-9 col-lg-6">
            <input
              id="abbr_name"
              v-model="form.abbr_name"
              class="form-control"
              name="abbr_name"
              :placeholder="$t('stores.abbr_name')"
              type="text"
            />
            <error :msg="form.errors.get('abbr_name')"></error>
          </div>
        </div>
        <div class="form-group form-row">
          <label class="col-md-3 col-form-label" for="parent_id">{{ $t('stores.parent') }}</label>
          <div class="col-md-9 col-lg-6">
            <select
              id="parent_id"
              v-model="form.parent_id"
              class="form-control custom-select"
              name="parent_id"
              @change="form.errors.clear('parent_id')"
            >
              <option v-for="store in refs.stores" :key="store.id" :value="store.id">
                {{ store.name }}
              </option>
            </select>
            <error :msg="form.errors.get('parent_id')"></error>
          </div>
        </div>
        <div class="form-group form-row">
          <label class="col-md-3 col-form-label" for="team_id">{{ $t('teams.title') }}</label>
          <div class="col-md-9 col-lg-6">
            <select
              id="team_id"
              v-model="form.team_id"
              class="form-control custom-select"
              name="team_id"
              @change="form.errors.clear('team_id')"
            >
              <option v-for="team in refs.teams" :key="team.id" :value="team.id">
                {{ team.name }}
              </option>
            </select>
            <error :msg="form.errors.get('team_id')"></error>
          </div>
        </div>
        <div class="form-group form-row">
          <label class="col-md-3 col-form-label" for="store_temp">{{ $t('stores.temp._') }}</label>
          <div class="col col-lg-3">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <span class="fas fa-fw fa-temperature-low"></span>
                </span>
                <label class="control-label sr-only" for="temp_min">{{
                  $t('stores.temp.min')
                }}</label>
              </div>
              <input
                id="temp_min"
                v-model="form.temp_min"
                class="form-control"
                name="temp_min"
                :placeholder="$t('stores.temp.min')"
                type="number"
              />
              <div class="input-group-append">
                <span class="input-group-text">°C</span>
              </div>
            </div>
            <error :msg="form.errors.get('temp_min')"></error>
          </div>
          <div class="col col-lg-3">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <span class="fas fa-fw fa-temperature-high"></span>
                </span>
                <label class="control-label sr-only" for="temp_max">{{
                  $t('stores.temp.max')
                }}</label>
              </div>
              <input
                id="temp_max"
                v-model="form.temp_max"
                class="form-control"
                name="temp_max"
                :placeholder="$t('stores.temp.max')"
                type="number"
              />
              <div class="input-group-append">
                <span class="input-group-text">°C</span>
              </div>
            </div>
            <error :msg="form.errors.get('temp_max')"></error>
          </div>
        </div>
        <div class="form-group form-row">
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
</template>

<script>
import FormMixin from '@/views/generic/FormMixin';
import Form from '@/utilities/Form';

export default {
  name: 'StoreForm',

  mixins: [FormMixin],

  data() {
    return {
      form: new Form({
        id: null,
        name: null,
        abbr_name: null,
        parent_id: null,
        team_id: null,
        description: null,
        temp_min: null,
        temp_max: null,
      }),
    };
  },
};
</script>

<style lang="scss" scoped></style>

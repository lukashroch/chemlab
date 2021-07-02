<template>
  <div class="tab-pane active">
    <form @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">
      <div class="card-body">
        <div class="form-group form-row">
          <label for="name" class="col-md-3 col-form-label">{{ $t('common.name') }}</label>
          <div class="col-md-9 col-lg-6">
            <input
              id="name"
              v-model="form.name"
              type="text"
              name="name"
              class="form-control"
              :placeholder="$t('common.name')"
            />
            <error :msg="form.errors.get('name')"></error>
          </div>
        </div>
        <div class="form-group form-row">
          <label for="abbr_name" class="col-md-3 col-form-label">{{
            $t('stores.abbr_name')
          }}</label>
          <div class="col-md-9 col-lg-6">
            <input
              id="abbr_name"
              v-model="form.abbr_name"
              type="text"
              name="abbr_name"
              class="form-control"
              :placeholder="$t('stores.abbr_name')"
            />
            <error :msg="form.errors.get('abbr_name')"></error>
          </div>
        </div>
        <div class="form-group form-row">
          <label for="parent_id" class="col-md-3 col-form-label">{{ $t('stores.parent') }}</label>
          <div class="col-md-9 col-lg-6">
            <select
              id="parent_id"
              v-model="form.parent_id"
              name="parent_id"
              class="form-control custom-select"
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
          <label for="team_id" class="col-md-3 col-form-label">{{ $t('teams.title') }}</label>
          <div class="col-md-9 col-lg-6">
            <select
              id="team_id"
              v-model="form.team_id"
              name="team_id"
              class="form-control custom-select"
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
          <label for="store_temp" class="col-md-3 col-form-label">{{ $t('stores.temp._') }}</label>
          <div class="col col-lg-3">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <span class="fas fa-fw fa-temperature-low"></span>
                </span>
                <label for="temp_min" class="control-label sr-only">{{
                  $t('stores.temp.min')
                }}</label>
              </div>
              <input
                id="temp_min"
                v-model="form.temp_min"
                type="number"
                name="temp_min"
                class="form-control"
                :placeholder="$t('stores.temp.min')"
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
                <label for="temp_max" class="control-label sr-only">{{
                  $t('stores.temp.max')
                }}</label>
              </div>
              <input
                id="temp_max"
                v-model="form.temp_max"
                type="number"
                name="temp_max"
                class="form-control"
                :placeholder="$t('stores.temp.max')"
              />
              <div class="input-group-append">
                <span class="input-group-text">°C</span>
              </div>
            </div>
            <error :msg="form.errors.get('temp_max')"></error>
          </div>
        </div>
        <div class="form-group form-row">
          <label for="description" class="col-form-label col-md-3">{{
            $t('common.description')
          }}</label>
          <div class="col-md-9 col-lg-6">
            <textarea
              id="description"
              v-model="form.description"
              name="description"
              class="form-control"
              rows="4"
              :placeholder="$t('common.description')"
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
import Form from '../../../utilities/Form';
import FormMixin from '../../generic/FormMixin';

export default {
  name: 'Form',

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

<template>
  <layout v-if="entryLoaded" v-bind="{ id, entry }">
    <div class="tab-pane active" role="tabpanel">
      <table class="table table-hover">
        <tbody>
          <tr>
            <th>{{ $t('chemicals.name') }}</th>
            <td colspan="3">{{ entry.name }}</td>
          </tr>
          <tr>
            <th>{{ $t('chemicals.iupac') }}</th>
            <td colspan="3">{{ entry.iupac }}</td>
          </tr>
          <tr>
            <th>{{ $t('chemicals.synonym') }}</th>
            <td colspan="3">{{ entry.synonym }}</td>
          </tr>
          <tr>
            <th>{{ $t('chemicals.brand.id') }}</th>
            <td v-if="entry.brand && entry.catalog_id">
              <a
                :href="entry.brand.url_product.replace(':id', entry.catalog_id)"
                rel="noopener"
                target="_blank"
              >
                {{ entry.catalog_id }} <span class="fas fa-external-link-alt"></span>
              </a>
            </td>
            <td v-else>
              {{ entry.catalog_id }}
            </td>
            <th>{{ $t('chemicals.brand._') }}</th>
            <td>{{ entry.brand ? entry.brand.name : $t('common.not.defined') }}</td>
          </tr>
          <tr>
            <th>{{ $t('chemicals.cas') }}</th>
            <td>{{ entry.cas }}</td>
            <th>{{ $t('chemicals.pubchem._') }}</th>
            <td>
              <a
                v-for="id in pubchemIds"
                :key="id"
                :href="$t('chemicals.pubchem.url', { id })"
                rel="noopener"
                target="_blank"
              >
                {{ id }} <span class="fas fa-external-link-alt"></span>
              </a>
            </td>
          </tr>
          <tr>
            <th>{{ $t('chemicals.mw') }}</th>
            <td>{{ entry.mw }}</td>
            <th>{{ $t('chemicals.formula') }}</th>
            <td v-html="entry.formula ? entry.formula.replace(/(\d+)/g, '<sub>$1</sub>') : ''"></td>
          </tr>
          <tr>
            <th>{{ $t('chemicals.chemspider._') }}</th>
            <td colspan="3">
              <a
                v-for="id in chemspiderIds"
                :key="id"
                :href="$t('chemicals.chemspider.url', { id })"
                rel="noopener"
                target="_blank"
              >
                {{ id }} <span class="fas fa-external-link-alt"></span>
              </a>
            </td>
          </tr>
          <tr>
            <th>{{ $t('common.description') }}</th>
            <td colspan="3">{{ entry.description }}</td>
          </tr>
        </tbody>
      </table>
      <table class="table table-hover">
        <tbody>
          <tr>
            <th>{{ $t('msds.sds._') }}</th>
            <td>
              <a
                v-if="entry.brand"
                :href="entry.brand.url_sds.replace(':id', entry.catalog_id)"
                rel="noopener"
                target="_blank"
              >
                <span class="fas fa-file-pdf"></span> {{ $t('msds.sds.vendor') }}
              </a>
              <span v-else>
                {{ $t('common.not.available') }}
              </span>
            </td>
          </tr>
          <tr>
            <th>{{ $t('msds.symbol') }}</th>
            <td>
              <img
                v-for="item in entry.symbol"
                :key="item"
                :alt="item"
                height="80"
                :src="`/images/ghs/${item}.gif`"
                :title="item"
                width="80"
              />
            </td>
            <th>{{ $t('msds.signal_word') }}</th>
            <td>
              {{ entry.signal_word || $t('common.not.defined') }}
            </td>
          </tr>
          <tr>
            <th>{{ $t('msds.h_abbr') }}</th>
            <td colspan="3">
              <template v-if="entry.h.length">
                <p v-for="item in entry.h" :key="item" class="mb-0">{{ $t(`msds.h.${item}`) }}</p>
              </template>
              <template v-else>
                <p class="mb-0">{{ $t('common.not.defined') }}</p>
              </template>
            </td>
          </tr>
          <tr>
            <th>{{ $t('msds.p_abbr') }}</th>
            <td colspan="3">
              <template v-if="entry.p.length">
                <p v-for="item in entry.p" :key="item" class="mb-0">{{ $t(`msds.p.${item}`) }}</p>
              </template>
              <template v-else>
                <p class="mb-0">{{ $t('common.not.defined') }}</p>
              </template>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <template #addons>
      <items :chemical-id="id"></items>
    </template>
  </layout>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

import { showMixin } from '@/components/entry';

import Items from './Items.vue';

export default defineComponent({
  name: 'ChemicalDetail',

  components: { Items },

  mixins: [showMixin],

  computed: {
    pubchemIds() {
      return this.entry.pubchem ? this.entry.pubchem.split(';') : [];
    },

    chemspiderIds() {
      return this.entry.chemspider ? this.entry.chemspider.split(';') : [];
    },
  },

  /* filters: {
    formula: function(value) {
      if (!value) return '';
      return value.replace(/(\d+)/g, '<sub>$1</sub>');
    }
  } */
});
</script>

<style lang="scss" scoped></style>

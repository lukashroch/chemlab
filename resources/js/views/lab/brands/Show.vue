<template>
  <div class="tab-pane active" role="tabpanel">
    <table class="table table-hover">
      <tbody>
        <tr>
          <th>{{ $t('common.name') }}</th>
          <td>{{ entry.name }}</td>
        </tr>
        <tr>
          <th>{{ $t('brands.url.product') }}</th>
          <td>{{ entry.url_product }}</td>
        </tr>
        <tr>
          <th>{{ $t('brands.url.sds') }}</th>
          <td>{{ entry.url_sds }}</td>
        </tr>
        <tr>
          <th>{{ $t('brands.parse_callback') }}</th>
          <td>{{ entry.parse_callback }}</td>
        </tr>
        <tr>
          <th>{{ $t('common.description') }}</th>
          <td>{{ entry.description }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import ShowMixin from '../../generic/ShowMixin';

export default {
  mixins: [ShowMixin]
};
</script>

<style scoped></style>

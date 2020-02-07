<template>
  <div class="tab-pane active" role="tabpanel">
    <table class="table table-hover">
      <tbody>
        <tr>
          <th>{{ $t('common.name') }}</th>
          <td>{{ entry.name }}</td>
        </tr>
        <tr>
          <th>{{ $t('stores.abbr_name') }}</th>
          <td>{{ entry.abbr_name }}</td>
        </tr>
        <tr>
          <th>{{ $t('stores.parent') }}</th>
          <td v-if="entry.parent">
            <router-link
              tag="a"
              :title="entry.parent.tree_name"
              :to="{ name: `${module}.show`, params: { id: entry.parent.id } }"
            >
              {{ entry.parent.tree_name }}
            </router-link>
          </td>
          <td v-else>
            {{ $t('common.none') }}
          </td>
        </tr>
        <tr>
          <th>{{ $t('teams.title') }}</th>
          <td v-if="entry.team">
            <router-link
              tag="a"
              :title="entry.team.display_name"
              :to="{ name: `teams.show`, params: { id: entry.team.id } }"
            >
              {{ entry.team.display_name }}
            </router-link>
          </td>
          <td v-else>
            {{ $t('common.none') }}
          </td>
        </tr>
        <tr>
          <th>{{ $t('stores.temp._') }}</th>
          <td>{{ $t('stores.temp.int', { min: entry.temp_min, max: entry.temp_max }) }}</td>
        </tr>
        <tr>
          <th>{{ $t('common.description') }}</th>
          <td>{{ entry.description }}</td>
        </tr>
        <tr>
          <th>{{ $t('stores.children') }}</th>
          <td class="p-0">
            <div class="list-group list-group-flush">
              <router-link
                v-for="child in entry.children"
                :key="child.id"
                class="list-group-item list-group-item-action"
                tag="a"
                :title="child.tree_name"
                :to="{ name: `stores.show`, params: { id: child.id } }"
              >
                <span class="fas fa-fw fa-angle-double-right"></span>
                {{ child.tree_name }}
              </router-link>
            </div>
          </td>
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

<template>
  <layout v-if="entryLoaded" v-bind="{ id, entry }">
    <div></div>
  </layout>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

import { showMixin } from '@/components/entry';

export default defineComponent({
  mixins: [showMixin],
});
</script>

<style lang="scss" scoped></style>

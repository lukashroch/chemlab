<template>
  <nav aria-label="pagination">
    <ul class="pagination justify-content-center">
      <li class="page-item" :class="{ disabled: meta.current_page === 1 }">
        <a class="page-link" href="#" tabindex="-1" @click="paginate(1)">{{
          $t('pagination.first')
        }}</a>
      </li>
      <li class="page-item" :class="{ disabled: meta.current_page === 1 }">
        <a
          class="page-link"
          href="#"
          tabindex="-1"
          @click="paginate(meta.current_page > 1 ? meta.current_page - 1 : 0)"
          >{{ $t('pagination.previous') }}</a
        >
      </li>
      <li class="page-item" :class="{ disabled: meta.current_page === meta.last_page }">
        <a
          class="page-link"
          href="#"
          tabindex="-1"
          @click="
            paginate(meta.current_page < meta.last_page ? meta.current_page + 1 : meta.last_page)
          "
          >{{ $t('pagination.next') }}</a
        >
      </li>
      <li class="page-item" :class="{ disabled: meta.current_page === meta.last_page }">
        <a class="page-link" href="#" tabindex="-1" @click="paginate(meta.last_page)">
          {{ $t('pagination.last') }}
        </a>
      </li>
    </ul>
  </nav>
</template>

<script>
export default {
  name: 'Pagination',

  props: { meta: { type: Object, required: true } },

  methods: {
    paginate(page = 1) {
      this.$emit('paginate', page);
    }
  }
};
</script>

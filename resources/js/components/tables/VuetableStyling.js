export default {
  table: {
    tableClass: 'table table-sm table-striped table-hover',
    loadingClass: 'loading',
    ascendingIcon: 'fas fa-sort-up',
    descendingIcon: 'fas fa-sort-down',
    ascendingClass: 'sorting_asc',
    descendingClass: 'sorting_desc',
    sortableIcon: '',
    detailRowClass: 'vuetable-detail-row',
    handleIcon: 'fas fa-bar',
    /* renderIcon: function(classes, options) {
            return `<span class="${classes.join(' ')}"></span>`
        }, */
    tableBodyClass: 'px-3',
    tableHeaderClass: 'px-3'
  },
  pagination: {
    wrapperClass: 'pagination',
    activeClass: 'text-white bg-primary',
    disabledClass: 'disabled',
    pageClass: 'page-item page-link btn',
    linkClass: 'page-link',
    icons: {
      first: '',
      prev: '',
      next: '',
      last: ''
    },
    paginationClass: ''
  },
  info: {}
};

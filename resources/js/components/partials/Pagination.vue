<template>
  <nav aria-label="Pagination">
    <ul class="pagination">
      <li class="page-item" :class="{ disabled: previous === null }">
        <a class="page-link" @click="changePage(previous)" href="#" aria-label="Previous">
          <span aria-hidden="true">&laquo;</span>
        </a>
      </li>
      <li class="page-item" :class="{ disabled: next === null }">
        <a class="page-link" @click="changePage(next)" href="#" aria-label="Next">
          <span aria-hidden="true">&raquo;</span>
        </a>
      </li>
    </ul>
  </nav>
</template>

<script>
export default {
  name: "DefaultPagination",
  props: {
    next: null,
    previous: null,
    count: null,
  },
  created() {

  },
  methods: {
    changePage(page) {
      this.$emit('page-changed', page);
    },
  },
};
</script>

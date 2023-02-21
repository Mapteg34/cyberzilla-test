<template>
  <b-row>
    <b-col>
      <b-pagination-nav
          v-model="value.page"
          :number-of-pages="totalPages"
          :link-gen="linkGen"
          use-router
      />
    </b-col>
    <b-col>
      <b-form
          inline
          style="display: flex; justify-content: flex-end"
      >
        <label>На странице:</label>
        <b-form-select
            id="perPageSelect"
            v-model="value.perPage"
            :options="perPageVariants"
        />
      </b-form>
    </b-col>
  </b-row>
</template>

<script>

export default {
  props: {
    value: {
      type: Object,
      required: true,
    },
    perPageVariants: {
      type: Array,
      required: false,
      default: () => [
        {value: 1, text: "1"},
        {value: 10, text: "10"},
        {value: 20, text: "20"},
        {value: 50, text: "50"},
        {value: 100, text: "100"},
        {value: 200, text: "200"},
        {value: 500, text: "500"},
      ],
    },
    linkGen: {
      type: Function,
      required: true,
    },
  },
  computed: {
    totalPages() {
      if (this.value.totalItems <= 0) {
        return 1;
      }

      if (this.value.perPage <= 0) {
        return 1;
      }

      return Math.ceil(this.value.totalItems / this.value.perPage);
    },
  },
};
</script>

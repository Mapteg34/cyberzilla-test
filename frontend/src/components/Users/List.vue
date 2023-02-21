<template>
  <b-container fluid>
    <b-row>
      <b-col>
        <b-button-toolbar class="mb-3">
          <b-button-group class="ml-auto">
            <b-button to="add">
              <b-icon icon="plus"/>
              Добавить
            </b-button>
          </b-button-group>
        </b-button-toolbar>
      </b-col>
    </b-row>
    <b-row>
      <b-col>
        <b-table
            ref="table"
            striped
            hover
            :items="itemsProvider"
            :fields="fields"
            :busy.sync="isBusy"
            :per-page="pagination.perPage"
            :current-page="pagination.page"
            :sort-by.sync="sortBy"
            :sort-desc.sync="sortDesc"
        >
          <template #cell(actions)="row">
            <b-button-toolbar>
              <b-button-group class="ml-auto">
                <b-button :to="{path:`${row.item.id}`}">
                  <b-icon icon="search"/>
                </b-button>
                <b-button @click="doDelete(row.item.id)">
                  <b-icon icon="trash"/>
                </b-button>
              </b-button-group>
            </b-button-toolbar>
          </template>
          <template #table-busy>
            <div class="text-center text-danger my-2">
              <b-spinner class="align-middle"/>
              <strong>Загрузка данных...</strong>
            </div>
          </template>
        </b-table>
      </b-col>
    </b-row>
    <pagination
        v-model="pagination"
        :link-gen="paginationLinkGen"
    />
  </b-container>
</template>

<script>
export default {
  data() {
    return {
      fields: [
        {
          key: "id",
          label: "Id",
        },
        {
          key: "email",
          label: "Email",
        },
        {
          key: "name",
          label: "Name",
        },
        {
          key: "phone",
          label: "Phone",
        },
        {
          key: "created_at",
          label: "Добавлен",
          formatter(value) {
            return window.formatDatetime(value);
          },
        },
        {
          key: "updated_at",
          label: "Изменен",
          formatter(value) {
            return window.formatDatetime(value);
          },
        },
        {
          key: "actions",
          label: "",
        },
      ],
      isBusy: false,
      sortBy: this.$route.query.sortBy ?? null,
      sortDesc: this.$route.query.sortDesc === "true",
      pagination: {
        page: parseInt(this.$route.query.page ?? 1),
        perPage: parseInt(this.$route.query.perPage ?? 10),
        totalItems: 0,
      },
    };
  },
  watch: {
    "$route.query": {
      handler(query) {
        if (!query.page || !query.perPage) {
          this.$router.replace({query: this.getQueryParams({})}).catch(() => {
          });
        }
      },
      deep: true,
      immediate: true,
    },
  },
  methods: {
    getQueryParams(options) {
      const params = Object.assign({
        page: this.pagination.page,
        perPage: this.pagination.perPage,
        sortBy: this.sortBy,
        sortDesc: this.sortDesc,
      }, options);

      return Object.fromEntries(Object.entries(params).filter(([, v]) => v != null && !!v));
    },
    itemsProvider(ctx) {
      this.isBusy = true;

      const query = this.getQueryParams(ctx);

      this.$router.push({query}).catch(() => {
      });

      return this.axios.get("/admin-api/users", {params: query})
          .then(async ({data}) => {
            this.pagination.totalItems = data.meta.total;

            return data.data;
          })
          .finally(async () => {
            this.isBusy = false;
          });
    },
    paginationLinkGen(page) {
      return "?" + (new URLSearchParams(this.getQueryParams({page}))).toString();
    },
    refreshTable() {
      this.$refs.table.refresh();
    },
    doDelete(id) {
      this.axios.delete(`/admin-api/users/${id}`).then(async () => {
        this.$alertify.success("Данные удалены");
        this.refreshTable();
      });
    },
  },
};
</script>

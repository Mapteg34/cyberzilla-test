<template>
  <div>
    <b-button-toolbar class="mb-3">
      <b-button-group class="ml-auto">
        <b-button to="../list">
          <b-icon icon="list"/>
          Список
        </b-button>
        <b-button to="../add">
          <b-icon icon="plus"/>
          Добавить
        </b-button>
        <b-button @click="doDelete()">
          <b-icon icon="trash"/>
          Удалить
        </b-button>
      </b-button-group>
    </b-button-toolbar>
    <b-overlay :show="!item">
      <b-table
          :stacked="true"
          :items="rows"
          :fields="fields"
      >
      </b-table>
    </b-overlay>
    <b-overlay :show="!item">
      <b-row>
        <b-col><h4>Платежи</h4></b-col>
      </b-row>
      <b-row>
        <b-col>
          <b-table
              ref="table"
              striped
              hover
              :items="paymentsProvider"
              :fields="paymentsFields"
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
    </b-overlay>
  </div>
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
      ],
      paymentsFields: [
        {
          key: "id",
          label: "Id",
        },
        {
          key: "sum",
          label: "Сумма",
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
      ],
      item: null,
      isBusy: false,
      pagination: {
        page: parseInt(this.$route.query.page ?? 1),
        perPage: parseInt(this.$route.query.perPage ?? 10),
        totalItems: 0,
      },
      sortBy: this.$route.query.sortBy ?? null,
      sortDesc: this.$route.query.sortDesc === "true",
    };
  },
  computed: {
    rows() {
      if (!this.item) {
        return [];
      }

      return [this.item];
    },
  },
  mounted() {
    this.refreshData();
  },
  methods: {
    refreshData() {
      const id = parseInt(this.$route.params.id);

      this.axios.get(`/admin-api/users/${id}`).then(async ({data}) => {
        this.item = data.data;
      });
    },
    onDeleted() {

    },
    doDelete() {
      const id = parseInt(this.$route.params.id);

      this.axios.delete(`/admin-api/users/${id}`).then(async () => {
        this.$alertify.success("Данные удалены");
        this.$router.push("../list");
      });
    },
    getQueryParams(options) {
      const params = Object.assign({
        page: this.pagination.page,
        perPage: this.pagination.perPage,
        sortBy: this.sortBy,
        sortDesc: this.sortDesc,
      }, options);

      return Object.fromEntries(Object.entries(params).filter(([, v]) => v != null && !!v));
    },
    paymentsProvider(ctx) {
      this.isBusy = true;

      const query = this.getQueryParams(ctx);

      this.$router.push({query}).catch(() => {
      });

      const id = parseInt(this.$route.params.id);

      return this.axios.get(`/admin-api/users/${id}/payments`, {params: query})
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
  },
};
</script>

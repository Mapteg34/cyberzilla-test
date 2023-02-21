<template>
  <div>
    <b-button-toolbar class="mb-3">
      <b-button-group class="ml-auto">
        <b-button to="list">
          <b-icon icon="list"/>
          Список
        </b-button>
      </b-button-group>
    </b-button-toolbar>
    <b-overlay :show="request">
      <b-form
          autocomplete="off"
          @submit="submit"
      >
        <b-form-group
            label="Email"
            label-for="email"
        >
          <b-form-input
              id="email"
              v-model="form.email"
              type="text"
              placeholder="Введите email"
              required
              :state="errors.email ? false : null"
              autocomplete="off"
          />
          <b-form-invalid-feedback>
            <ul>
              <li
                  v-for="error in errors.email"
                  :key="error"
              >
                {{ error }}
              </li>
            </ul>
          </b-form-invalid-feedback>
        </b-form-group>
        <b-form-group
            label="Пароль"
            label-for="password"
        >
          <b-form-input
              id="password"
              v-model="form.password"
              type="password"
              placeholder="Введите пароль"
              required
              :state="errors.password ? false : null"
              autocomplete="new-password"
          />
          <b-form-invalid-feedback>
            <ul>
              <li
                  v-for="error in errors.password"
                  :key="error"
              >
                {{ error }}
              </li>
            </ul>
          </b-form-invalid-feedback>
        </b-form-group>

        <b-form-group
            label="Name"
            label-for="name"
        >
          <b-form-input
              id="name"
              v-model="form.name"
              type="text"
              placeholder="Введите имя"
              required
              :state="errors.name ? false : null"
              autocomplete="off"
          />
          <b-form-invalid-feedback>
            <ul>
              <li
                  v-for="error in errors.name"
                  :key="error"
              >
                {{ error }}
              </li>
            </ul>
          </b-form-invalid-feedback>
        </b-form-group>

        <b-form-group
            label="Phone"
            label-for="phone"
        >
          <b-form-input
              id="phone"
              v-model="form.phone"
              type="text"
              placeholder="Введите phone"
              required
              :state="errors.phone ? false : null"
              autocomplete="off"
          />
          <b-form-invalid-feedback>
            <ul>
              <li
                  v-for="error in errors.phone"
                  :key="error"
              >
                {{ error }}
              </li>
            </ul>
          </b-form-invalid-feedback>
        </b-form-group>

        <b-button
            type="submit"
            variant="primary"
        >
          Сохранить
        </b-button>
      </b-form>
    </b-overlay>
  </div>
</template>

<script>
export default {
  data() {
    return {
      form: {
        email: null,
        password: null,
        name: null,
        phone: null,
      },
      errors: {},
      request: false,
    };
  },
  methods: {
    submit(event) {
      event.preventDefault();

      if (this.request) {
        return;
      }

      this.request = true;

      this.axios.post("/admin-api/users", {...this.form})
          .then(async ({data}) => {
            this.$alertify.success("Запись добавлена");
            this.$router.push({path: `${data.data.id}`});
          })
          .catch(async ({response}) => {
            if (response.status === 422) {
              this.errors = response.data.errors;
            }
            this.$alertify.error(response.data.message);
          })
          .finally(async () => {
            this.request = false;
          });

    },
  },
};
</script>

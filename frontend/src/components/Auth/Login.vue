<template>
    <div class="d-flex justify-content-center">
        <b-form @submit="submit">
            <h2 class="text-center">
                Вход в систему
            </h2>
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
            <div class="d-flex justify-content-center">
                <b-button
                    type="submit"
                    variant="primary"
                >
                    Войти
                </b-button>
            </div>
        </b-form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            form: {
                email: null,
                password: null,
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

            let redirect;

            if (this.$auth.transitionPrev && this.$auth.transitionPrev.fullPath !== "/login") {
                redirect = this.$auth.transitionPrev.fullPath;
            } else {
                redirect = "/";
            }

            this.$auth
                .login({
                    data: {...this.form},
                    redirect,
                })
                .then(async () => {
                    this.$alertify.success("Вы успешно вошли в систему, добро пожаловать");
                })
                .catch(async ({error}) => {
                    if (this.$formValidation.isValidationRpcResponse(error)) {
                        this.errors = this.$formValidation.parse(error.data);
                    }
                    this.$alertify.error(error.message);
                })
                .finally(() => {
                    this.request = false;
                });
        },
    },
};
</script>

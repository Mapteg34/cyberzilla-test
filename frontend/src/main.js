import Vue from "vue";

import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";
import "./assets/app.scss";

import App from "./App.vue";
import router from "./router";
import {BootstrapVue, BootstrapVueIcons} from "bootstrap-vue";
import axios from "axios";
import VueAxios from "vue-axios";
import auth from "@websanova/vue-auth/src/v2.js";
import driverAuthBearer from "@websanova/vue-auth/src/drivers/auth/bearer.js";
import driverHttpAxios from "@websanova/vue-auth/dist/drivers/http/axios.1.x.esm.js";
import driverRouterVueRouter from "@websanova/vue-auth/src/drivers/router/vue-router.2.x.js";
import Alertify from "./Alertify";

/** @property tz */
const moment = require("moment-timezone");

Vue.use(VueAxios, axios);
Vue.use(Alertify);

Vue.use(auth, {
    plugins: {
        http: Vue.axios,
        router: router,
    },
    drivers: {
        http: driverHttpAxios,
        auth: driverAuthBearer,
        router: driverRouterVueRouter,
    },
    options: {
        authRedirect: "/login",
        notFoundRedirect: {name: "user-account"},
        loginData: {
            url: "/admin-api/auth/login",
            fetchUser: false,
        },
        refreshData: {
            url: "/admin-api/auth/refresh",
            interval: 60 * 10,
        },
        fetchData: {
            url: "/admin-api/auth/user",
        },
    },
});

Vue.use(BootstrapVue)
Vue.use(BootstrapVueIcons)

Vue.config.productionTip = false;

Vue.component("Pagination", require("./components/Tool/Pagination.vue").default);

const formatDatetime = window.formatDatetime = function (
    value,
    format = "DD.MM.YYYY HH:mm:ss",
    timezone = "Europe/Moscow",
) {
    if (typeof value === "string" || typeof value === "number") {
        return moment.tz(value, timezone).format(format);
    }

    throw "Invalid dateTime value";
};

Vue.filter("formatDatetime", formatDatetime);

window.app = new Vue({
    router,
    render: h => h(App),
}).$mount("#app")

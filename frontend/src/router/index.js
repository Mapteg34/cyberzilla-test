import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

const routes = [
    {
        path: "/",
        redirect: "users",
        component: {template: "<router-view></router-view>"},
        meta: {auth: true, title: "Главная"},
        children: [
            {
                path: "users",
                component: {template: "<router-view></router-view>"},
                redirect: "users/list",
                meta: {title: "Пользователи", dontDisplayChildren: true},
                children: [
                    {
                        path: "list",
                        component: () => import("./../components/Users/List"),
                        meta: {title: "Список"},
                    },
                    {
                        path: "add",
                        component: () => import("./../components/Users/Add"),
                        meta: {title: "Добавление"},
                    },
                    {
                        path: ":id",
                        component: {template: "<router-view></router-view>"},
                        redirect: ":id/view",
                        meta: {title: "Пользователь"},
                        children: [
                            {
                                path: "view",
                                component: () => import("./../components/Users/View"),
                                meta: {title: "Просмотр"},
                            },
                        ],
                    },
                ],
            },
        ],
    },
    {
        path: "/login",
        component: () => import("@/components/Auth/Login"),
        meta: {
            auth: false,
        },
    },
];

const router = new VueRouter({
    mode: "history",
    base: process.env.BASE_URL,
    routes,
});

export default router;

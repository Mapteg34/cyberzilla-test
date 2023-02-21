<template>
    <b-navbar
        toggleable="lg"
        type="dark"
        variant="primary"
        class="px-2"
    >
        <b-navbar-toggle target="nav-collapse" />
        <b-collapse
            id="nav-collapse"
            is-nav
        >
            <b-navbar-nav>
                <template v-for="item in items">
                    <b-nav-item
                        v-if="!item.children"
                        :key="item.path"
                        :to="`/${item.path}`"
                    >
                        {{
                            item.name
                        }}
                    </b-nav-item>
                    <b-nav-item-dropdown
                        v-else
                        :key="item.path"
                    >
                        <template #button-content>
                            <em>{{ item.name }}</em>
                        </template>
                        <b-dropdown-item
                            v-for="child in item.children"
                            :key="child.path"
                            :data="child"
                            :to="`/${item.path}/${child.path}`"
                        >
                            {{ child.name }}
                        </b-dropdown-item>
                    </b-nav-item-dropdown>
                </template>
            </b-navbar-nav>
            <b-navbar-nav class="ml-auto">
                <b-nav-item-dropdown
                    v-if="$auth.check()"
                    right
                >
                    <template #button-content>
                        <em>{{ $auth.user().email }}</em>
                    </template>
                    <b-dropdown-item
                        href="javascript:void(0)"
                        @click.prevent="$auth.logout().catch(()=>{}); $router.replace('/login');"
                    >
                        Выйти
                    </b-dropdown-item>
                </b-nav-item-dropdown>
            </b-navbar-nav>
        </b-collapse>
    </b-navbar>
</template>

<script>
export default {
    computed: {
        items() {
            const mapRoute = (route) => {
                if (route.meta && Object.prototype.hasOwnProperty.call(route.meta, "auth")) {
                    if (!route.meta.auth && this.$auth.check()) {
                        return null;
                    }
                    if (route.meta.auth && route.meta.auth !== true && !this.$auth.check(route.meta.auth)) {
                        return null;
                    }
                }
                if (route.meta && route.meta.exclude_from_navigation) {
                    return null;
                }
                let children = null;
                if (route.children && !route.meta.dontDisplayChildren) {
                    children = route.children.map(mapRoute).filter((route) => !!route);
                    if (children.length <= 0) {
                        children = null;
                    }
                }
                return {
                    name: route.meta.title,
                    path: route.path,
                    children,
                };
            };
            return this.$router.options.routes.map(mapRoute).filter((route) => !!route).shift().children;
        },
    }
}
</script>

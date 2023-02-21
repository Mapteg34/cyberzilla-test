<template>
    <b-breadcrumb :items="breadcrumbs" />
</template>

<script>
export default {
    computed: {
        breadcrumbs() {
            const items = [];
            this.$route.matched.forEach((route) => {
                if (!route.meta
                    ||
                    !Object.prototype.hasOwnProperty.call(route.meta, "title")
                    ||
                    !route.meta.title
                ) {
                    return;
                }

                let path = route.path;

                if (path === "") {
                    path = "/";
                }

                for (let paramName in this.$route.params) {
                    if (!Object.prototype.hasOwnProperty.call(this.$route.params, paramName)) continue;
                    path = path.replace(":" + paramName, this.$route.params[paramName]);
                }

                items.push({
                    text: route.meta.title,
                    to: path,
                });
            });

            return items;
        },
    }
}
</script>

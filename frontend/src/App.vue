<template>
    <div>
        <navigation v-if="$auth.ready() && $auth.check()" />
        <bread-crumbs v-if="$auth.ready() && $auth.check()" />
        <b-container
            id="app"
            fluid
        >
            <b-row
                v-if="!$auth.ready()"
                class="justify-content-center"
            >
                <b-overlay
                    :show="true"
                    :opacity="0.5"
                >
                    <b-col
                        style="padding:20px;"
                        class="text-center"
                    >
                        Ожидайте, идет загрузка приложения
                    </b-col>
                </b-overlay>
            </b-row>
            <b-row
                v-if="$auth.ready()"
                fluid
            >
                <b-col>
                    <router-view />
                </b-col>
            </b-row>
        </b-container>
    </div>
</template>
<script>
import BreadCrumbs from "./components/Tool/BreadCrumbs";
import Navigation from "./components/Tool/Navigation";

export default {
    components: {Navigation, BreadCrumbs},
}
</script>

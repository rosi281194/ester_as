<template>
    <div class="wrapper">
        <div class="main-panel">
            <Menu></Menu>
            <div class="content">
                <b-container>
                    <slot/>
                </b-container>
            </div>
            <footer class="footer">
                <div class="container-fluid">
                    <div class="copyright float-right">
                        ©2021, por <a href="#">Rouse</a>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</template>

<script>
import Menu from "./Menu.vue";

export default {
    components: {
        Menu
    },
    data() {
        return {}
    },
    methods: {},
    props: {
        title: String
    },
}
</script>

<template>
    <div id="container">
        <slot/>
    </div>
</template>

<script>
import MainMenuMobile from "./menu/MainMenuMobile";
import MainMenu from "./menu/MainMenu";
import axios from "axios";

export default {
    components: {
        MainMenu,
        MainMenuMobile
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

import Vue from 'vue'
import {createInertiaApp} from '@inertiajs/vue2'
import {BootstrapVue, IconsPlugin} from 'bootstrap-vue'

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

import '../css/all.css'
import '../css/main.css'

// Optionally install the BootstrapVue icon components plugin

// InertiaProgress.init()
// Vue.use(require('vue-moment'));

createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', {eager: true})
        return pages[`./Pages/${name}.vue`]
    },
    setup({el, App, props, plugin}) {
        Vue.use(plugin)
        Vue.use(BootstrapVue)
        Vue.use(IconsPlugin)
        new Vue({
            render: h => h(App, props),
        }).$mount(el)
    },
})

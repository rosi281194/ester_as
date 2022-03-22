<template>
    <b-navbar toggleable="lg" type="dark" variant="rose">
        <b-container>
            <b-navbar-brand href="#">Ester</b-navbar-brand>
            <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

            <b-collapse id="nav-collapse" is-nav>
                <b-navbar-nav>
                    <template v-for="(link, key) in menue">
                        <template v-if="getPermission(link.role)">
                            <li :class="'nav-item '+((getUrl() === link.url)?'active':'')">
                                <inertia-link
                                    :href="link.url"
                                    :key="key"
                                    class="nav-link"
                                >
                                    <span>{{ link.label }}</span>
                                </inertia-link>
                            </li>
                        </template>
                    </template>
                </b-navbar-nav>

                <!-- Right aligned nav items -->
                <b-navbar-nav class="ml-auto">
                    <li class="nav-item">
                        <inertia-link href="/logout" method="post" class="nav-link">
                            <span>Salir</span>
                        </inertia-link>
                    </li>
                </b-navbar-nav>
            </b-collapse>
        </b-container>
    </b-navbar>
</template>

<script>
export default {
    data() {
        return {
            menue: [
                {
                    label: 'Asistencia',
                    url: '/',
                    role: 'user',
                }, {
                    label: 'Personas',
                    url: '/persona',
                    role: 'user',
                }, {
                    label: 'Escuadron',
                    url: '/escuadron',
                    role: 'admin',
                }, {
                    label: 'Usuarios',
                    url: '/users',
                    role: 'admin',
                }, {
                    label: 'Reporte',
                    url: '/reporte',
                    role: 'user',
                },
                {
                    label: 'Recaudacion',
                    url: '/recaudacion',
                    role: 'user',
                },{
                    label: 'Total',
                    url: '/totalaporte',
                    role: 'user',
                },
            ],

        };
    },
    methods: {
        getPermission(role) {
            let value = false;
            for (const key in this.$page.props.rolesP) {
                if (key === role) {
                    if (this.$page.props.rolesP[key].includes(this.$page.props.user.role)) {
                        value = true;
                        break;
                    }
                }
            }
            return value;
        },
        getUrl() {
            return window.location.pathname;
        }
    }
};
</script>

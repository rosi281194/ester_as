<template>
    <b-navbar toggleable="lg" type="dark" variant="rose">
        <b-container>
            <b-navbar-brand href="#">Ester AS</b-navbar-brand>
            <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

            <b-collapse id="nav-collapse" is-nav>
                <b-navbar-nav>
                        <template v-for="(link, key) in menu">
                            <template v-if="getPermission(link.role)">
                                <li :class="'nav-item '+(($page.url === link.url ||$page.url === link.url2)?'active':'')">
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
            menu: [
                {
                    label: 'Asistencia',
                    url: '/',
                    role: 'admin',
                },{
                    label: 'Personas',
                    url: '/',
                    role: 'admin',
                },{
                    label: 'Usuarios',
                    url: '/',
                    role: 'admin',
                },{
                    label: 'Reporte',
                    url: '/',
                    role: 'admin',
                },
            ],
        };
    },
    methods: {
        getPermission(role) {
            let value = false;
            for (const key in this.$page.props.roles) {
                if (key == role) {
                    if (this.$page.props.roles[key].includes(this.$page.props.user.role)) {
                        value = true;
                        break;
                    }
                }
            }
            return value;
        }
    }
};
</script>

<template>
    <div class="container">
        <div class="row justify-content-sm-center">
            <div class="col-sm-8 col-md-6 col-lg-5">
                <div class="card mt-5">
                    <div class="card-body text-center">
                        <div class="mb-4">
                            <i class="feather icon-unlock auth-icon"></i>
                        </div>
                        <h3 class="mb-4">Ingresar</h3>
                        <b-alert variant="danger" dismissible :show="Object.values(errors).length > 0">
                            <div v-for="(value,key) in errors">
                                {{ key }}: {{ value }}
                            </div>
                        </b-alert>
                        <form class="form-horizontal m-t-20" @submit.prevent="submit">
                            <div class="input-group mb-3">
                                <b-form-input
                                    id="username"
                                    v-model="form.username"
                                    placeholder="Usuario"
                                    trim
                                    type="text"
                                ></b-form-input>
                            </div>
                            <div class="input-group mb-4">
                                <b-form-input
                                    id="password"
                                    v-model="form.password"
                                    placeholder="Contraseña"
                                    trim
                                    type="password"
                                ></b-form-input>
                            </div>
                            <div class="form-group text-left">
                                <div class="checkbox checkbox-fill d-inline">
                                    <input id="remember" v-model="form.remember" type="checkbox">
                                    <label for="remember" class="cr">
                                        Remember Me
                                    </label>
                                </div>
                            </div>
                            <div class="form-group text-center m-t-10">
                                <!-- /.col -->
                                <div class="col-12">
                                    <loading-button :loading="sending" class="btn btn-primary shadow-2 mb-4"
                                                    type="submit" :text="'Ingresar'" :textLoad="'Ingresando'">Login
                                    </loading-button>
                                </div>
                                <!-- /.col -->
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import LoadingButton from '../Shared/LoadingButton.vue'
import { router } from '@inertiajs/vue2'

export default {
    components: {
        LoadingButton,
    },
    props: {
        errors: Object,
    },
    data() {
        return {
            sending: false,
            form: {
                username: '',
                password: '',
                remember: null,
            },
        }
    },
    methods: {
        submit() {
            const data = {
                username: this.form.username,
                password: this.form.password,
                remember: this.form.remember,
            }

            router.post('/login', data, {
                onStart: () => this.sending = true,
                onFinish: () => this.sending = false,
            })
        },
    },
}
</script>

<template>
    <div>
        <b-modal
            :id="id"
            :title="(isNew)?titulo1:titulo2"
            @show="reset"
            @hidden="reset"
            @ok="handleOk">
            <form @submit.stop.prevent="enviar">
                <b-alert dismissible :show="errors.length">
                    {{ errors }}
                </b-alert>
                <template v-for="(item,key) in form">
                    <b-form-group
                        :label="item.label"
                        :label-for="key"
                        :state="item.state"
                        :invalid-feedback="item.stateText"
                        v-if="['text','password','date','textarea','email','select'].includes(item.type)"
                    >
                        <b-input
                            :type="item.type"
                            :placeholder="item.label"
                            v-model="item.value"
                            :id="key"
                            :state="item.state"
                            v-if="['text','password','date','email'].includes(item.type)"
                        ></b-input>
                        <b-form-select
                            v-if="item.type==='select'"
                            v-model="item.value"
                            :options="roles"
                        >
                            <template #first>
                                <b-form-select-option :value="null">Seleccione una opcion</b-form-select-option>
                            </template>
                        </b-form-select>
                    </b-form-group>
                    <b-checkbox
                        v-if="item.type==='bool'"
                        v-model="item.value"
                        :id="key"
                        :state="item.state"
                    >{{ item.label }}
                    </b-checkbox>
                </template>
            </form>
            <template #modal-footer="{ ok, cancel }">
                <b-button variant="outline-primary" @click="cancel()">
                    Cancel
                </b-button>
                <loading-button :loading="sending" variant="primary"
                                @click.native="ok()" :text="'Guardar'" :textLoad="'Guardando'">Guardar
                </loading-button>
            </template>
        </b-modal>
    </div>
</template>

<script>
import axios from "axios";
import LoadingButton from '../Shared/LoadingButton.vue'

export default {
    props: {
        isNew: Boolean,
        id: String,
        itemRow: Object,
        roles: Array
    },
    components: {
        LoadingButton
    },
    data() {
        return {
            sending: false,
            boton1: "Nuevo",
            boton2: "Modificar",
            titulo1: "Nuevo Usuario",
            titulo2: "Modificar Usuario",
            form: {
                username: {
                    label: 'Usuario',
                    value: "",
                    type: "text",
                    state: null,
                    stateText: null
                }, password: {
                    label: 'Contraseña',
                    value: "",
                    type: "password",
                    state: null,
                    stateText: null
                }, role: {
                    label: 'Rol',
                    value: "",
                    type: "select",
                    state: null,
                    stateText: null
                }, activo: {
                    label: 'Activo?',
                    value: "",
                    type: "bool",
                    state: null,
                    stateText: null
                }

            },
            idForm: null,
            errors: Array
        }
    },
    methods: {
        reset() {
            this.limpiar();

            if (this.isNew) {
                if ('id' in this.itemRow) {
                    this.idForm = null;
                }
                Object.keys(this.form).forEach(key => {
                    this.form[key].value = "";
                })
            } else {
                if ('id' in this.itemRow) {
                    this.idForm = this.itemRow['id'];
                }
                Object.keys(this.form).forEach(key => {
                    if (['activo'].includes(key)) {
                        this.form[key].value = (this.itemRow[key] == 1);
                    } else {
                        this.form[key].value = this.itemRow[key];
                    }
                })
            }
        },
        limpiar() {
            Object.keys(this.form).forEach(key => {
                this.form[key].state = null;
                this.form[key].stateText = null;
            })
            this.errors = [];
        },
        handleOk(bvModalEvt) {
            // Prevent modal from closing
            bvModalEvt.preventDefault();
            this.enviar();
        },
        enviar() {
            this.sending = true;
            this.limpiar();
            let user = new FormData();
            if (this.idForm) {
                user.append('id', this.idForm);
            }
            Object.keys(this.form).forEach(key => {
                if (this.form[key].value != null) {
                    if (['activo'].includes(key)) {
                        user.append(key, this.form[key].value ? '1' : '0');
                    } else {
                        user.append(key, this.form[key].value);
                    }
                }
            })
            axios.post('/user', user, {headers: {'Content-Type': 'multipart/form-data'}})
                .then(({data}) => {
                    if (data["status"] === 0) {
                        this.$bvModal.hide(this.id)
                        this.$inertia.get(data["path"])
                    }
                    Object.keys(this.form).forEach(key => {
                        if (key in data.errors) {
                            this.form[key].state = false;
                            this.form[key].stateText = data.errors[key][0];
                        } else {
                            this.form[key].state = true;
                            this.form[key].stateText = "";
                        }
                    })
                })
                .catch(error => {
                    // handle error
                    this.errors = error
                    console.log(error);
                })
                .finally(() => {
                    this.sending = false;
                })

        }
    },
}
</script>

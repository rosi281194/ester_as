<template>
    <div class="row">
        <div class="col">
            <div class="row">
                <div class="col-sm-12">
                    <h4 class="header-title m-t-0 m-b-20">{{ titulo }}</h4>
                </div>
            </div>
            <b-modal
                :id="id"
                :title="titulo"
                @hidden="limpiar"
                @ok="handleOk">
                <p>Asistencia de <strong>{{itemRow.nombre}} {{itemRow.apellido}}</strong></p>
                <b-alert dismissible :show="errores.length">
                    {{ errors }}
                </b-alert>
                <template #modal-footer="{ ok, cancel }">
                    <b-button variant="outline-primary" @click="cancel()">
                        Cancel
                    </b-button>
                    <loading-button :loading="sending" variant="primary"
                                    @click.native="ok()" :text="'Guardar'" :textLoad="'Guardando'">Guardar
                    </loading-button>
                </template>
            </b-modal>

            <div class="row m-b-20">
                <div class="col">
                    <b-table
                        striped
                        hover
                        responsive
                        :items="personas"
                        :fields="fields"
                        show-empty
                        small
                    >
                        <template #empty="scope">
                            <p class="text-center">{{ textoVacio }}</p>
                        </template>
                        <template v-slot:cell(escuadron)="data">
                            {{ getEscuadron(data.value) }}
                        </template>
                        <template v-slot:cell(fechaNacimiento)="data">
                            {{ data.value | moment("DD/MM/YYYY") }}
                        </template>
                        <template v-slot:cell(Acciones)="row">
                            <div class="row-actions">
                                <b-button v-b-modal="id" variant="default" @click="loadModal(row)">
                                    {{ boton1 }}
                                </b-button>
                            </div>
                        </template>
                    </b-table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Layout from '@/Shared/Layout'
import LoadingButton from '@/Shared/LoadingButton'
import axios from "axios";

export default {
    layout: Layout,
    props: {
        personas: Array,
        escuadrones: Array,
        errors: Object,
    },
    components: {
        LoadingButton
    },
    data() {
        return {
            sending: false,
            isNew: true,
            id: "modalAsistencia",
            boton1: "Asistencia",
            titulo: 'Asistencia',
            textoVacio: 'No existen Personas',
            fields:
                [
                    'nombre',
                    'apellido',
                    'escuadron',
                    'Acciones'
                ],
            itemRow: {},
            errores:{}
        }
    },
    methods: {
        loadModal(item = null) {
            this.itemRow = item.item;
        },
        getEscuadron(id) {
            let data = '';
            for (const key in this.escuadrones) {
                if (this.escuadrones[key].id === id) {
                    data = this.escuadrones[key].nombre;
                    break;
                }
            }
            return data;
        },
        limpiar() {
            this.itemRow = {};
            this.errores = {};
        },
        handleOk(bvModalEvt) {
            // Prevent modal from closing
            bvModalEvt.preventDefault();
            this.enviar();
        },
        enviar() {
            this.sending = true;
            let user = new FormData();
            if (this.itemRow) {
                user.append('id', this.itemRow.id);
            }
            axios.post('/', user, {headers: {'Content-Type': 'multipart/form-data'}})
                .then(({data}) => {
                    if (data["status"] === 0) {
                        this.$bvModal.hide(this.id)
                        this.$inertia.get(data["path"])
                    }
                    if (data.errors) {
                       this.errores = data.errors;
                    }
                    this.limpiar();
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
    }
}
</script>


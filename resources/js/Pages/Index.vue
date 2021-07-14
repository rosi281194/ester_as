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
                <b-col  class="my-1">
                    <b-form-group
                        label=""
                        label-for="filter-input"
                        label-align-sm="right"
                        label-size="sm"
                        class="mb-0"
                    >
                        <b-input-group size="sm">
                            <b-form-input
                                id="filter-input"
                                v-model="filter"
                                type="search"
                                placeholder="Buscar Nombre"
                            ></b-form-input>

                                <b-button :disabled="!filter" @click="filter = ''" variant="primary">Limpiar</b-button>
                        </b-input-group>
                    </b-form-group>
                </b-col>


                <div class="col-12">
                    <b-card title="Lista ester" >
                    <b-table
                        striped
                        hover
                        responsive
                        :items="personas"
                        :fields="fields"
                        :current-page="currentPage"
                        :per-page="perPage"
                        :filter="filter"
                        :filter-included-fields="filterOn"
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
                    </b-card>
                    <b-col  class="my-1">
                        <b-pagination
                            v-model="currentPage"
                            :total-rows="totalRows"
                            :per-page="perPage"
                            align="fill"
                            size="sm"
                            class="my-0"
                        ></b-pagination>
                    </b-col>
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
                    'ci',
                    'Acciones'
                ],
            itemRow: {},
            totalRows: 1,
            currentPage: 1,
            perPage: 5,
            errores:{},
            filter: null,
            filterOn: [],
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
    ,
    mounted() {
        // Set the initial number of items
        this.totalRows = this.personas.length
    }
}
</script>


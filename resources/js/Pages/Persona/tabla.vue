<template>
    <div class="row">
        <div class="col">
            <div class="row">
                <div class="col-sm-12">
                    <h4 class="header-title m-t-0 m-b-20">{{ titulo }}</h4>
                </div>
            </div>
            <div class="row m-b-20 m-t-10">
                <div class="col">
                    <b-button v-b-modal="'personaModal'" @click="loadModal()" variant="primary">{{ boton1 }}</b-button>
                    <Form :isNew="isNew" id="personaModal" :itemRow="itemRow" :escuadron="escuadron"></Form>
                </div>
            </div>

            <div class="row m-b-20">
                <div class="col">
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
                    </div>
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
                                <b-button v-b-modal="'personaModal'" variant="default" @click="loadModal(false,row)">
                                    {{ boton2 }}
                                </b-button>
                                <b-button class="btn-danger" @click="borrar(row.item.id)">
                                    {{ boton3 }}
                                </b-button>
                            </div>
                        </template>
                    </b-table>
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
import Layout from '../Shared/Layout.vue'
import Form from './form.vue'
import moment from 'moment';

export default {
    layout: Layout,
    props: {
        personas: Array,
        escuadron: Object,
        errors: Object,
    },
    components: {
        Form,
    },
    data() {
        return {
            isNew: true,
            boton1: "Nuevo",
            boton2: "Modificar",
            boton3: "Borrar",
            titulo: 'Personas',
            textoVacio: 'No existen Personas',
            fields:
                [
                    'nombre',
                    'apellido',
                    'ci',
                    'fechaNacimiento',
                    'Acciones'
                ],
            itemRow: {},
            totalRows: 1,
            currentPage: 1,
            perPage: 5,
            filter: null,
            filterOn: [],
        }
    },
    methods: {
        loadModal(isNew = true, item = null) {
            this.isNew = isNew;
            this.itemRow = {};
            if (!isNew) {
                this.itemRow = item.item;
            }
        },
        borrar(id) {
            this.$inertia.delete(`persona/${id}`, {
                onBefore: () => confirm('Esta seguro?'),
            })
        },
        getEscuadron(id) {
            let data = '';
            Object.keys(this.escuadron).forEach(
                key => {
                    if (this.escuadron[key].value == id) {
                        data = this.escuadron[key].text;
                    }
                }
            )
            return data;
        },
    },
    mounted() {
        // Set the initial number of items
        this.totalRows = this.personas.length
    }
}
</script>


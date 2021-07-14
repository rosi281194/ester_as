<template>
    <div class="row">
        <div class="col">
            <div class="row">
                <div class="col-sm-12">
                    <h4 class="header-title m-t-0 m-b-20">Reporte</h4>
                </div>
            </div>
            <div class="row m-b-20">
                <div class="col">


                    <b-card title="Cantidad" sub-title="cantidad de asistencia por escuadron">
                    <b-table
                        striped
                        hover
                        responsive
                        :items="cantidad"
                        :fields="fields2"
                        show-empty
                        small
                    >

                        <template #empty="scope">
                            <p class="text-center">{{ textoVacio }}</p>
                        </template>

                    </b-table>
                    </b-card>
                    <b-card title="Nuevas ester" sub-title="Detalle de personas nuevas el dia de hoy">
                        <b-table
                            striped
                            hover
                            responsive
                            :items="nuevos"
                            :fields="fields3"
                            show-empty
                            small
                        >

                            <template #empty="scope">
                                <p class="text-center">{{ textoVacio }}</p>
                            </template>
                            <template v-slot:cell(escuadron)="data">
                                {{ getEscuadron(data.value) }}
                            </template>
                        </b-table>
                    </b-card>
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
        cantidad : Array,
        nuevos : Array,
        errors: Object,
    },
    components: {
        LoadingButton
    },
    data() {
        return {
            textoVacio: 'No existen Personas',
            fields:
                [
                    'nombre',
                    'apellido',
                    'escuadron',
                    'total',
                ],
            fields3:
                [
                    'nombre',
                    'apellido',
                    'telefono',
                    'Edad',


                ],
            fields2:
                [
                    'escuadronNombre',
                    'total',
                ],
        }
    },
    methods: {
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
    }
}
</script>


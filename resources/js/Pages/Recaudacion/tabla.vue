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
                    <b-button v-b-modal="'escuadronModal'" @click="loadModal()" variant="primary">{{ boton1 }}</b-button>
                    <FormUser :isNew="isNew" id="escuadronModal" :itemRow="itemRow"></FormUser>
                </div>
            </div>

            <div class="row m-b-20">
                <div class="col">
                    <b-table
                        striped
                        hover
                        responsive
                        :items="escuadron"
                        :fields="fields"
                        show-empty
                        small
                    >
                        <template #empty="scope">
                            <p class="text-center">{{ textoVacio }}</p>
                        </template>
                        <template v-slot:cell(Acciones)="row">
                            <div class="row-actions">
                                <b-button v-b-modal="'escuadronModal'" variant="default" @click="loadModal(false,row)">
                                    {{ boton2 }}
                                </b-button>
                                <b-button class="btn-danger" @click="borrar(row.item.id)">
                                    {{ boton3 }}
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
import Layout from '../Shared/Layout.vue'
import FormUser from './form.vue'

export default {
    layout: Layout,
    props: {
        escuadron: Array,
        errors: Object,
    },
    components: {
        FormUser,
    },
    data() {
        return {
            isNew: true,
            boton1: "Nuevo",
            boton2: "Modificar",
            boton3: "Borrar",
            titulo: 'Recaudacion',
            textoVacio: 'No existen Dato',
            idModal: 'userModal',
            fields:
                [
                    'nombre',
                    'montoBs',
                    'montoSus'
                ],
            itemRow: {}
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
            this.$inertia.delete(`recaudacion/${id}`, {
                onBefore: () => confirm('Esta seguro?'),
            })
        }
    }
}
</script>


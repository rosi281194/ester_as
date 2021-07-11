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
                        <template v-slot:cell(activo)="data">
                            {{ (data.value === 1) ? "Si" : "No" }}
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
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Layout from '@/Shared/Layout'
import Form from './form'

export default {
    layout: Layout,
    props: {
        personas: Array,
        escuadron: Array,
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
            idModal: 'userModal',
            fields:
                [
                    'nombre',
                    'apellido',
                    'ci',
                    'fechaNacimiento',
                    'Acciones'
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
            this.$inertia.delete(`persona/${id}`, {
                onBefore: () => confirm('Esta seguro?'),
            })
        },
        getEscuadron(id) {
            let rol = '';
            Object.keys(this.escuadron).forEach(
                key => {
                    if (this.escuadron[key].value == id) {
                        rol = this.escuadron[key].text;
                    }
                }
            )
            return rol;
        },
    }
}
</script>


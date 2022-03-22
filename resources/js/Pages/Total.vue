<template>
    <div class="row">
        <div class="col">
            <div class="row">
                <div class="col-sm-12">
                    <h4 class="header-title m-t-0 m-b-20">Reporte</h4>
                    <div>
                        <b-card class="text-center">
                            <h1 class="display-1">{{total}}</h1>

                        </b-card>
                    </div>
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
        total: Number,
        errors: Object,
    },
    components: {
        LoadingButton
    },
    data() {
        return {
            textoVacio: '',
            timer:''

        }
    },
    methods: {
    fetchData(){
        this.$inertia.reload();
    }
    },
    created() {

        this.timer = setInterval(this.fetchData, 10000);

    }
}


</script>


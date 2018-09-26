<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <line-chart :chart-data="data" :height="100" :options="{responsive: true, maintainAspectRation: true}"></line-chart>
            </div>
        </div>
    </div>
</template>


<script>
    import LineChart from './LineChart.js'
    export default {
    // регистрируем компонент
        components: {
            LineChart
        },
        data: function () {
            return {
                data: []
            }
        },
        mounted() {
            this.update();
        },
        methods: {
            update: function () {

                axios.get('/data-chart').then((responce) => {
                    this.data = responce.data;
                });
            }
        }
    }
</script>

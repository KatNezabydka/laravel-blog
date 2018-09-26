<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <pie-chart :chart-data="data" :height="100" :options="{responsive: true, maintainAspectRation: true}"></pie-chart>
            </div>
        </div>
    </div>
</template>


<script>
    import PieChart from './PieChart.js'
    export default {
    // регистрируем компонент
        components: {
            PieChart
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

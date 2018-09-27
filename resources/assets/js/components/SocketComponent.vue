<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <line-chart :chart-data="data" :height="100" :options="{responsive: true, maintainAspectRation: true}"></line-chart>
                <input type="checkbox" v-model="realtime"> realtime
                <input type="text" v-model="label">
                <input type="text" v-model="sale">
                <button @click="sendData" class="btn btn-primary btn-xs text mt-1 mh-100">Обновить</button>
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
                data: [],
                realtime: false,
                label: "",
                sale: 500
            }
        },
        mounted() {
            //добавляем клиент для связи с сервером
            var socket = io('http://localhost:3000');
            //событие, которое нужно отлавливать - название канала, : , пространство имен
            //далее присваиваем значение для графика, который вернул нам сервер
            //bind - делаем привязку, чтобы работало   this.data
            socket.on("news-action:App\\Events\\NewEvent", function (data) {
                //в событии result это ключ
                this.data = data.result
            }.bind(this));
            this.update();
        },
        methods: {
            update: function () {

                axios.get('/socket-chart').then((response) => {
                    this.data = response.data;
                });
            },
            sendData: function () {
                axios({
                    method: 'get',
                    url: '/socket-chart',
                    params: {
                        label: this.label,
                        sale: this.sale,
                        realtime: this.realtime
                    }
                }).then((response) => {
                    this.data = response.data;
            });
            }
        }
    }
</script>

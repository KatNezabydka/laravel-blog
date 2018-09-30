<template>
    <div class="container">
        <hr>
        <div class="row">
            <div class="col-sm-12">
                <textarea class="form-control" rows="10" readonly="">{{ messages.join('\n') }}</textarea>
                <hr>
                <input type="text" class="form-control" v-model="textMessage" @keyup.enter="sendMessage">
            </div>
        </div>
    </div>
</template>


<script>
    export default {
        data(){
           return {
               messages: [],
               textMessage: ''
           }
        },
        //момент монтирования компонента
        mounted() {
           //отвечает за прослушивание канала со стороны пользователя
            //channel - какой канал
            //lesten - какое событие прослушиваем
            //при срабатывании используем стрелочную функцию
            window.Echo.channel('chat')
                    .listen('Message', ({message}) => {
                        this.messages.push(message.body)
            });
        },
        methods: {
            sendMessage: function () {
                axios.post('/messages', {body: this.textMessage});

                this.messages.push(this.textMessage);

                this.textMessage = '';
            }
        }
    }
</script>

<template>
    <div class="container">
        <hr>
        <div class="row">
            <div class="col-sm-12">
                <textarea class="form-control" rows="10" readonly="">{{ messages.join('\n') }}</textarea>
                <hr>
                <input type="text" class="form-control" v-model="textMessage" @keyup.enter="sendMessage"
                       @keydown="actionUser">
                <span v-if="isActive">{{ isActive.name }} набирает сообщение...</span>
            </div>
            <div class="col-sm-4">
                <ul>
                    <li v-for="user in activeUsers">{{ user }}</li>
                </ul>
            </div>
        </div>
    </div>
</template>


<script>
    export default {
        props: ['room', 'user'],
        data(){
           return {
               messages: [],
               textMessage: '',
               isActive: false,
               //чтобы не накладывалось набирает сообщение от нескольких пользователей
               typingTimer: false,
               //кто присоединился
               activeUsers: []
           }
        },
        computed: {
            channel() {
                //чтобы отслеживать присутствующих
                return  window.Echo.join('room.' + this.room);
//                return  window.Echo.private('room.' + this.room);
            }
        },
        //момент монтирования компонента
        mounted() {
            //отвечает за прослушивание канала со стороны пользователя
            //channel - какой канал
            //listen - какое событие прослушиваем
            //при срабатывании используем стрелочную функцию
            //here для отслеживания присутстующих
            //joining - пользователь, который подключился
           this.channel
                   .here((users) => {
                        this.activeUsers = users
                    })
                    .joining((user) => {
                        this.activeUsers.push(user);
                    })
                    .leaving((user) => {
                        this.activeUsers.splice(this.activeUsers.indexOf(user), 1);
                    })
                   .listen('PrivateChat', ({data}) => {
                        this.messages.push(data.body)
                        //когда сообщение пришло, убираем надпись
                        this.isActive = false;})
                    .listenForWhisper('typing', (e) => {
                        //будет получать массив данных, в данном случае имя пользователя   this.channel.whisper('typing', {name: this.user.name});
                        this.isActive = e;

            //если таймер истино отменяем выполнение и присваиваем значение таймера этому свойству
            if(this.typingTimer) clearTimeout(this.typingTimer);
                //задаем время счерез сколько убирать сообщение
            this.typingTimer = setTimeout(() => {
                    this.isActive = false;
                }, 2000);
            });
        },
        methods: {
            sendMessage: function () {
                axios.post('/private-messages', {body: this.textMessage, room_id: this.room});

                this.messages.push(this.textMessage);

                this.textMessage = '';
            },
            actionUser() {
                //whisper - транслирует событие в канал, что пользователь набирает сообщение
                this.channel.whisper('typing', {
                    name: this.user.name
                });
            }
        }
    }
</script>

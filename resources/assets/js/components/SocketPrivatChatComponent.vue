<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="row form-group">
                    <div class="row-sm-4">
                        <select name="" multiple="" class="form-control" v-model="usersSelect">
                            <option v-for="user in users" :value="'news-action.' + user.id ">{{user.email}}</option>
                        </select>
                    </div>
                    <div class="row-sm-12">
                        <textarea rows="6" readonly="" class="form-control">
                            {{dataMessages.join('\n')}}
                        </textarea>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Наберите сообщение" v-model="message">
                    <div class="input-group-append">
                        <button @click="sendMessage" class="btn btn-outline-secondary" type="button">Отправить</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
    export default {
        data: function () {
            return {
                dataMessages: [],
                message: "",
                usersSelect: []
            }
        },
        props: [
            // инициализируем начальные параметры в пропсах
            'users',
            'user'
        ],
        created() {
            //добавляем клиент для связи с сервером
//            var socket = io('http://localhost:3000');
            var socket = io('http://laravel-blog:3000');
            //событие, которое нужно отлавливать - название канала, : , пространство имен
            //далее присваиваем значение для графика, который вернул нам сервер
            //bind - делаем привязку, чтобы работало   this.data
            socket.on("news-action." + this.user.id + ":App\\Events\\PrivateMessage", function (data) {
                //в событии result это ключ
                this.dataMessages.push(data.message.user + ': ' + data.message.message);
            }.bind(this));

            //если все слушают канал, добавляем еще одного слушателя
            socket.on("news-action.:App\\Events\\PrivateMessage", function (data) {
                //в событии result это ключ
                this.dataMessages.push(data.message.user + ': ' + data.message.message);
            }.bind(this));
        },
        methods: {
            sendMessage: function () {

                //если пользователь не выбран в массиве будет одно значение
                if(!this.usersSelect.length)
                        this.usersSelect.push('news-action');

                axios({
                    method: 'get',
                    url: '/send-private-message',
                    params: {
                        message: this.message,
                        channels: this.usersSelect,
                        user: this.user.email
                    }
                }).then((response) => {
                    this.dataMessages.push(this.user.email + ': ' + this.message);
                    this.message = "";
            });
            }
        }
    }
</script>

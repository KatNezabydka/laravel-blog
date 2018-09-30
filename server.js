/**
 * Created by kat on 27.09.18.
 */
//подключили модуль http
//Server() запускает сервер
var http = require('http').Server();
//подключаем библиотеку socket.io
//и привязать к серверу
//реализует протокол web socket для связи сервера с клиентом в браузере
// var io = require('socket.io')(http);

var io = require('socket.io')(http);
//для доступа к редис серверу
var Redis = require('ioredis');


var redis = new Redis();
//чтобы получить значение с сервера редис нужно подписаться на канал
redis.subscribe('news-action');
//запускаем прослушивание (слежение)
// redis.on('message', function (channel, message) {
//     console.log('Message recieved: ' + message);
//     console.log('Channel: ' + channel);
//     //сообщение приходит в формате json-строки
//     message = JSON.parse(message);
//     //отправляем данные всем клиентам
//     //передаем название канала и пространство имен события
//     //далее данные, которые были приняты от redis сервера
//     io.emit(channel + ':' + message.event, message.data);
// });

//чтобы библиотека могла отслеживать множество каналов - можно указывать маску каналов
redis.psubscribe("news-action.*");
//запускаем прослушивание (слежение)
//pattern - вернет news-action.*, message->pmessage
redis.on('pmessage', function (pattern, channel, message) {
    console.log('Message recieved: ' + message);
    console.log('Channel: ' + channel);
    //сообщение приходит в формате json-строки
    message = JSON.parse(message);
    //отправляем данные всем клиентам
    //передаем название канала и пространство имен события
    //далее данные, которые были приняты от redis сервера
    io.emit(channel + ':' + message.event, message.data);
});

//Запускаем сервер
//анонимная функция, для вывода в консоль что сервер запущен
http.listen(3000, function () {
    console.log('Listening on Port: 3000');
});
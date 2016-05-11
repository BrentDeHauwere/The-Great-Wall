var app = require('express');
var http = require('http').Server(app);
var io = require('socket.io')(http);
var Redis = require('ioredis');
var redis = new Redis();
redis.psubscribe('wall.*.messages', function(err, count) {
    console.log('Redis: wall.messages subscribed');
    console.log('Error:' + err);
    console.log('Count:' +count);
});
redis.on('message', function(channel, message) {
    console.log('Message Recieved: ' + message + 'Channel: ' + channel);
    message = JSON.parse(message);
    io.emit(channel + ':' + message.event, message.data);
});
http.listen(3000, function(){
    console.log('Listening on Port 3000');
});

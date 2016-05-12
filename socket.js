var app = require('express');
var http = require('http').Server(app);
var io = require('socket.io')(http);
var Redis = require('ioredis');
var redis = new Redis();
redis.psubscribe('messagewall1.wall.*.messages', function(err, count) {
    console.log('Redis: messagewall1.wall.*.messages subscribed');
    console.log('Error:' + err);
    console.log('Count:' +count);
});
redis.psubscribe('messagewall1.wall.*.polls', function(err, count) {
    console.log('Redis: messagewall1.wall.*.polls subscribed');
    console.log('Error:' + err);
    console.log('Count:' +count);
});
redis.psubscribe('messagewall1.wall.*.message.moderator.accepted', function(err, count) {
    console.log('Redis: messagewall1.wall.*.message.moderator.accepted subscribed');
    console.log('Error:' + err);
    console.log('Count:' +count);
});
redis.psubscribe('messagewall1.wall.*.message.moderator.declined', function(err, count) {
    console.log('Redis: messagewall1.wall.*.message.moderator.declined subscribed');
    console.log('Error:' + err);
    console.log('Count:' +count);
});
redis.on('pmessage', function(pattern,channel, message) {
    console.log('Message Received: ' + message + '\n Channel: ' + channel + '\n Pattern: ' + pattern);
    message = JSON.parse(message);
    io.emit(channel + ':' + message.event, message.data);
});
http.listen(3000, function(){
    console.log('Listening on Port 3000');
});

var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var Redis = require('ioredis');
var redis = new Redis();

redis.psubscribe('msg1.msg.*', function(err, count) {
    console.log('Redis: msg1.msg.* subscribed');
    console.log('Error:' + err);
    console.log('Count:' +count);
});
redis.psubscribe('msg1.polls.*', function(err, count) {
    console.log('Redis: msg1.polls.* subscribed');
    console.log('Error:' + err);
    console.log('Count:' +count);
});
redis.psubscribe('msg1.choice.polls.*', function(err, count) {
    console.log('Redis: msg1.choice.polls.* subscribed');
    console.log('Error:' + err);
    console.log('Count:' +count);
});
redis.psubscribe('msg1.vote.polls.*', function(err, count) {
    console.log('Redis: msg1.vote.polls.* subscribed');
    console.log('Error:' + err);
    console.log('Count:' +count);
});
redis.psubscribe('msg1.moda.msg.*', function(err, count) {
    console.log('Redis: msg1.moda.msg.* subscribed');
    console.log('Error:' + err);
    console.log('Count:' +count);
});
redis.psubscribe('msg1.modd.msg.*', function(err, count) {
    console.log('Redis: msg1.modd.msg.* subscribed');
    console.log('Error:' + err);
    console.log('Count:' +count);
});
redis.psubscribe('msg1.vote.msg.*', function(err, count) {
    console.log('Redis: msg1.modd.msg.* subscribed');
    console.log('Error:' + err);
    console.log('Count:' +count);
});
redis.on('pmessage', function(pattern,channel, message) {
    console.log('Message Received: ' + message + '\n Channel: ' + channel + '\n Pattern: ' + pattern);
    message = JSON.parse(message);
    io.emit(channel + ':' + message.event, message.data);
});

http.listen(1338, function(){
    console.log('Listening on Port 1338');
});

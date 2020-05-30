var io = require('socket.io')(6001);
console.log('Established on port 6001');

io.on('error', function (socket) {
    console.log('Initialized not successfully');
});

io.on('connection', function (socket) {
    console.log('Started connection with ' + socket.id);
});

const Redis = require('ioredis');
var redis = new Redis(6969);
redis.psubscribe('*', function (error, count) {

});

redis.on('pmessage', function (partner, channel, message) {
    console.log(partner);
    console.log(channel);
    console.log(message);
});
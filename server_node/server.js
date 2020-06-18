var io = require('socket.io')(6001);
console.log('Established on port 6001');

io.on('error', function (socket) {
    console.log('Initialized not successfully');
});

io.on('connection', function (socket) {
    var id = socket.id;

    console.log('Started connection with ' + id);

    io.emit('test_socket', 'Socket IO in use');

    socket.on('disconnect', function (socket) {
        console.log('Killed connection with ' + id);
    });

    socket.on('new_reply', function (signal) {
        io.emit('add_reply', signal);
    });

    socket.on('topic_status_changed', function (signal) {
        io.emit('update_topic_status', signal);
    });

    socket.on('reply_approved', function (signal) {
        io.emit('update_reply_status', signal);
    });

    socket.on('reply_deleted', function (signal) {
        io.emit('delete_reply', signal);
    });
});


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

    socket.on('new_thread', function (signal) {
        io.emit('noti_to_tutor', signal);
    });

    socket.on('new_chat', function (signal) {
        io.emit('update_chat', signal);
    });

    socket.on('new_chat_noti', function (signal) {
        io.emit('noti_for_chat', signal);
    });

    socket.on('thread_sheet_changed', function (signal) {
        io.emit('update_thread_sheet', signal);
    });
});


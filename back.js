var express=require('express');
var socket=require('socket.io');
var app=express();
var server=app.listen(7000,function(){
	console.log('juda khul gaya')
});
var io=socket(server);
io.on('connection',function(socket){
	console.log('made socket connection',socket.id);
	// socket.on('response_back',function(data)){
	// socket.broadcast.emit('response_back',data);
// });
});
var net = require('net'),
    fs = require('fs'),
    http = require('http'),
    PORT = 1128,
    server;

server = net.createServer(function (socket) {
    socket.setEncoding("utf8");
    socket.on('data', function(data) {
        try {
            var json,
                tmp,
                options,
                request;        
            if(data == '<policy-file-request/>\0') {
                socket.write('<?xml version="1.0"?><cross-domain-policy><allow-access-from domain="*" to-ports="*" /></cross-domain-policy>' + '\0');
            }
            else {
                json = JSON.parse(data.substr(0, data.length - 1));
                tmp = json.sessionKey.split('|||');
                if(json.command != 'ping') {
                    console.log('===================REQUEST===================');
                    console.log(json); 
                }    
                      
                options = {
                    host: 'localhost',
                    path: '/core/WebEngine.php?sessionID='+tmp[2]+'&game=' + tmp[0] + '|||' + tmp[1] + '&json='+JSON.stringify(json),
                };
                
                request = http.request(options, function(response) {
                    var body = '';
                    response.on('data', function(d) {
                        body += d;
                    });
                    response.on('end', function() {
                        if(body.indexOf('}{') > 0) {
                            var tmp  = body.split('}{'),
                                cnt = tmp.length,
                                needed;
                            for(var i = 0; i < cnt; i++) {
                                needed = tmp[i];
                                if(i !== 0) {
                                    needed = '{' + needed;
                                }
                                if(i !== (cnt - 1)) {
                                    needed = needed + '}';
                                }
                                socket.write(needed + '\0');
                                if(json.command != 'ping') {
                                    console.log('===================RESPONSE===================');
                                    console.log(needed);
                                }
                            }
                        }
                        else {
                            if(json.command != 'ping') {
                                console.log('===================RESPONSE===================');
                                console.log(body);
                            }
                            socket.write(body + '\0');
                        }

                    });
                });
                request.end();
            }   
        }   
        catch (error) {
            console.log(error);
        }
        
     });
 
     socket.on("error", function (exception) {
        console.log('Exception: ' + exception);
        socket.end();
     });
 
     socket.on("timeout", function () {
        console.log('timeout');
        socket.end();
     });
 
     socket.on("close", function (had_error) {
        console.log('socket close');
        socket.end();
     });
});
server.listen(PORT);

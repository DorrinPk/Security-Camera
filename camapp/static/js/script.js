window.onload = function() {
    navigator.getUserMedia = (navigator.getUserMedia ||
                              navigator.webkitGetUserMedia ||
                              navigator.moxGetUserMedia ||
                              navigator.msGetUserMedia);
}
 navigator.getUserMedia = (navigator.getUserMedia ||
                              navigator.webkitGetUserMedia ||
                              navigator.mozGetUserMedia ||
                              navigator.msGetUserMedia);



var label_id = 0;


if(navigator.getUserMedia){
    //request the camera
    var vid = document.getElementById('camera-stream');
    var canvas = document.getElementById('can');
    var ctx =canvas.getContext('2d');
    var socket = io.connect('http://localhost:5000');
    socket.on('connect', function() {
        console.log("connected");
        socket.emit('my event', {data: 'I\'m connected!'});
    });
    navigator.getUserMedia(
        //constraints
        {
            video: true
        },
        
        // Success Callback
        function(localMediaStream) {
            // Get a reference to the video element on the page.
          
            
            // Create an object URL for the video stream and use this 
            // to set the video source.
            vid.src = window.URL.createObjectURL(localMediaStream);
        },
        
        //Error Callback
        function(err) {
            console.log('The following error occurred when trying to use getUserMedia: ' + err);
        }
    );
    timer = setInterval(
            function () {
                ctx.drawImage(vid, 0, 0, 320, 240);
                var data = canvas.toDataURL();
                var output=data.replace(/^data:image\/(png|jpg);base64,/, "");
                if($('.switch-input').prop('checked')){
                    socket.emit('train',{data: output,value: $('#label').val(), id: parseInt($('#labelid').val()) });
                }else{
                    socket.emit('recognition',{data: output,value: $('#label').val() });
                }
            }, 2000);
    socket.on('image',function(data){
        if(data){
            var img = new Image();
            var target = document.getElementById("target");
            target.src = 'data:image/jpeg;base64,' + data.test;
            console.log("Got data!")
        }
    });
}else {
    alert('Sorry, your browser does not support getUserMedia');
}

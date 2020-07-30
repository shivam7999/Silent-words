// require[('opencv')];
function onOpenCvReady() {
  cv['onRuntimeInitialized']=()=>{
var socket = io.connect("http://192.168.43.12:7000")
//query do
const video=document.getElementById("videoElement")
	video.width = 600; 
    video.height = 700;

    if (navigator.mediaDevices.getUserMedia) {
      navigator.mediaDevices.getUserMedia({ video: true })
        .then(function (stream) {
          // socket.emit('catch-frame', { image: true, buffer: getFrame() });
          video.srcObject = stream;
            video.play();
        })
        .catch(function (err0r) {
          console.log(err0r)
          console.log("Something went wrong!");
        });
    }
    function stop(e) {
  var stream = video.srcObject;
  var tracks = stream.getTracks();

  for (var i = 0; i < tracks.length; i++) {
    var track = tracks[i];
    track.stop();
  }

  video.srcObject = null;
}

    let src = new cv.Mat(video.height, video.width, cv.CV_8UC4);
    let dst = new cv.Mat(video.height, video.width, cv.CV_8UC1);
    let cap = new cv.VideoCapture(video);
    // const FPS = 1000000;
    setInterval(() => {
        var type = "image/png"
        canvas=document.getElementById("canvasOutput")
        cap.read(src);
        canvas.width = video.width;
        canvas.height = video.height;
        canvas.getContext('2d').drawImage(video, 0, 0);
        var data = canvas.toDataURL(type);
        data = data.replace('data:' + type + ';base64,', ''); //split off junk 
        // at the beginning

        socket.emit('image', data);
    },500);


    socket.on('response_back', function(image){
        const image_id = document.getElementById('image');
        image_id.src = image;
    });
      };
}
 // returns a frame encoded in base64

    // const getFrame = () => {
    //     const canvas = document.createElement('canvas');
    //     canvas.width = video_t.videoWidth;
    //     canvas.height = video_t.videoHeight;
    //     canvas.getContext('2d').drawImage(video_t, 0, 0);
    //     const data = canvas.toDataURL('image/png');
    //     return data;
    // }

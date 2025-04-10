let video = document.getElementById('video');
let canvas = document.getElementById('canvas');
let captureButton = document.getElementById('capture');
let next = document.getElementById('next');
let canvasBlock = document.getElementById("canvasBlock");
let p = document.getElementById("p");
let context = canvas.getContext('2d');
let capturedFace = null;
let capturedIdentity = null;
let counter = 0;

//open the camera 
navigator.mediaDevices.getUserMedia({ video: true })
        .then(stream => { video.srcObject = stream; })
        .catch(error => { console.error("ُError", error); });


//take a photo
captureButton.addEventListener('click', () => {
        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        canvasBlock.style.display = "block";
        });


next.onclick = function(e){
        counter ++;
        if(counter == 1){
                e.preventDefault();
                capturedFace = canvas.toDataURL('image/png');
                canvasBlock.style.display = "none";
                p.innerHTML = "Take a clear picture of your identity";
        }
        else if(counter == 2){
                capturedIdentity = canvas.toDataURL('image/png');
                canvasBlock.style.display = "none";
                printCanvasImage(capturedIdentity , capturedFace);
                //.............
        }
}



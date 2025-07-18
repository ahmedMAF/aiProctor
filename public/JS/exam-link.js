let video = document.getElementById('video');
let canvas = document.getElementById('canvas');
let captureButton = document.getElementById('capture');
let next = document.getElementById('next');
let canvasBlock = document.getElementById("canvasBlock");
let retry = document.getElementById("retry");
let result = document.getElementById("result");
let p = document.getElementById("p");
let context = canvas.getContext('2d');
let capturedFace = null;
let capturedIdentity = null;
let counter = 0;
let nameOk = false;
let faceOk = false;

//open the camera 
navigator.mediaDevices.getUserMedia({ video: true })
    .then(stream => {
        video.srcObject = stream;
        video.onloadedmetadata = () => {
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
        };
    })
    .catch(error => { console.error("ُError", error); });


//take a photo
captureButton.addEventListener('click', () => {
    context.drawImage(video, 0, 0, canvas.width, canvas.height);
    canvasBlock.style.display = "block";
});


next.onclick = async function (e) {
    counter++;
    if (counter == 1) {
        e.preventDefault();
        capturedFace = await getBlobFromCanvas(canvas);
        canvasBlock.style.display = "none";
        p.innerHTML = "Take a clear picture of your identity";
    }
    else if (counter == 2) {
        e.preventDefault();
        capturedIdentity = await getBlobFromCanvas(canvas);
        canvasBlock.style.display = "none";
        //printCanvasImage(capturedIdentity, capturedFace);
        //.............
        video.parentElement.style.display = "none";
        canvas.style.display = "none";
        result.style.display = "block";

        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });

        await compareFaces();
        await extractText();

        if (faceOk && nameOk) {
            next.click();
            console.log("Identity and face verification successful.");
        }
        else {
            result.innerHTML = "Verification failed, please try again";
            retry.style.display = "block";
            result.style.color = "#e70d0d";
        }
    }
}

function getBlobFromCanvas(canvas) {
    return new Promise((resolve) => {
        canvas.toBlob((blob) => {
            resolve(blob);
        }, 'image/jpeg');
    });
}

async function compareFaces() {
    const apiKey = 'F4K08KzxUmVW3OpjtwY-hXzW1LTy-HUH';
    const apiSecret = 'Zl8qotfsl3HvjQoyg-c042urYzw-Pj34';

    console.log(capturedIdentity);

    const formData = new FormData();
    formData.append('api_key', apiKey);
    formData.append('api_secret', apiSecret);
    formData.append('image_file1', capturedFace, 'face1.jpg');
    formData.append('image_file2', capturedIdentity, 'face2.jpg');

    try {
        const response = await fetch('https://api-us.faceplusplus.com/facepp/v3/compare', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();

        if (data.confidence !== undefined) {
            if (data.confidence > 60) {
                faceOk = true;
                console.log('Faces match with confidence: ' + data.confidence);
            }
            else {
                console.log('Faces do not match with confidence: ' + data.confidence);
            }
        } else {
            // Handle the case where confidence is not returned
            console.log(data.error_message || 'Unknown error');
        }

    } catch (error) {
        // Handle network errors or other issues
        console.log('Request failed: ' + error.message);
    }
}

async function extractText() {
    const formData = new FormData();
    formData.append("language", "auto");
    formData.append("isOverlayRequired", "true");
    formData.append('file', capturedIdentity, 'face1.jpg');
    formData.append("OCREngine", "2");

    try {
        const response = await fetch("https://api.ocr.space/parse/image", {
            method: "POST",
            body: formData,
            headers: {
                apikey: "K85606688488957"
            }
        });

        const result = await response.json();

        if (result.IsErroredOnProcessing) {
            console.log("Error: " + result.ErrorMessage);
        } else {
            const parsedText = result.ParsedResults?.[0]?.ParsedText || "No text found.";
            const arr = fullName.split(" ");
            let nameMatch = arr.every(sub => parsedText.includes(sub));
            console.log("Extracted Text: " + parsedText);
            if (nameMatch) {
                nameOk = true;
                console.log("Identity verified successfully!");
            } else {
                console.log("Identity verification failed.");
            }
        }

    } catch (error) {
        console.error(error);
    }
}

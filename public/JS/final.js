// Constants
const MAX_EVENT_SECONDS = 10; // Max total recording length
const NO_FACE_DELAY = 200; // ms
const HORIZONTAL_THRESHOLD = 0.4;
const VERTICAL_THRESHOLD = 0.4;
const HEAD_MOVEMENT_FACTOR = 0.6;

const EVENT = {
    NO_FACE: 0,
    MULTI_FACE: 1,
    OFF_SCREEN: 2
};

// Landmark Indices
const LANDMARK_INDICES = {
    LEFT_EYE: [36, 37, 38, 39, 40, 41],
    RIGHT_EYE: [42, 43, 44, 45, 46, 47],
    HEAD: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16]
};

// State
let mediaRecorder;
let recordedChunks = [];
let dataArray = JSON.parse(localStorage.getItem('myData')) || {};
let lastResult = "";
let noFaceStartTime = null;
let isProcessingEvent = false; // flag to prevent overlapping events

let hasSentOffScreen = false;
let hasSentNoFace = false;
let hasSentMultipleFaces = false;
let wasNormalState = false;
let currentEvent = null;
let mediaStream = null;
let manualStop = null;

let started = false;
let isCalibrated = false;
let stableFramesCount = 0;
let calibrationData = {
    leftEyeCenter: null,
    rightEyeCenter: null,
    headPosition: null,
    eyeDistance: null
};

let commonVideo = null;
let commonStream = null;
let detectionInterval = null;
let calibrationIndicator = null;

async function initFaceAPI() {
    let cal = JSON.parse(localStorage.getItem('calibrationData'));

    if (cal) {
        calibrationData = cal;
        isCalibrated = true;
    }

    // Load all required models once
    await Promise.all([
        faceapi.nets.tinyFaceDetector.loadFromUri('/models'),
        faceapi.nets.faceLandmark68TinyNet.loadFromUri('/models'),
        faceapi.nets.faceLandmark68Net.loadFromUri('/models'),
        faceapi.nets.faceExpressionNet.loadFromUri('/models')
    ]);

    // Create video element if it doesn't exist
    if (!commonVideo) {
        commonStream = await navigator.mediaDevices.getUserMedia({ video: true });
        let div = document.getElementById('videoCal');
        commonVideo = document.createElement('video');
        div.appendChild(commonVideo);
        commonVideo.srcObject = commonStream;
    }

    // Start detection when video plays
    commonVideo.addEventListener('play', startCombinedDetection);
    await commonVideo.play();
}

async function startCombinedDetection() {
    // Clear any existing interval
    if (detectionInterval) clearInterval(detectionInterval);

    detectionInterval = setInterval(async () => {
        const detections = await faceapi.detectAllFaces(commonVideo, new faceapi.TinyFaceDetectorOptions())
            .withFaceLandmarks()
            .withFaceExpressions();

        const isNormalState = detections.length === 1;
        const isNoFaceState = detections.length === 0;
        const isMultiFaceState = detections.length > 1;

        // Handle state transitions FIRST
        if (isNormalState && !wasNormalState) {
            // Transitioned from abnormal to normal: Reset flags
            hasSentNoFace = false;
            hasSentMultipleFaces = false;
        }

        // No face detected
        if (isNoFaceState) {
            if (noFaceStartTime === null)
                noFaceStartTime = Date.now();

            if (Date.now() - noFaceStartTime >= NO_FACE_DELAY && !hasSentNoFace) {
                hasSentNoFace = true;
                console.log("Noface detected");
                recordProofVideo('Noface detected');
            }
        }
        // Multiple faces detected
        else if (isMultiFaceState) {
            if (!hasSentMultipleFaces) {
                hasSentMultipleFaces = true;
                console.log("Multiface detected");
                recordProofVideo('Multiface detected');
            }

            noFaceStartTime = null;
        }
        // Single face detected
        else {
            onFaceDetected(detections[0].landmarks);

            if (currentEvent == EVENT.NO_FACE || currentEvent == EVENT.MULTI_FACE) {
                console.log("we should stop recording now");
                manualStop();
            }

            // Expression tracking logic
            const top = Object.entries(detections[0].expressions)
                .sort((a, b) => b[1] - a[1])[0];

            if (lastResult !== top[0]) {
                addToArray(top[0]);
                lastResult = top[0];
            }

            // Reset no-face timer
            noFaceStartTime = null;
        }

        // UPDATE PREVIOUS STATE FOR NEXT INTERVAL
        wasNormalState = isNormalState;
    }, 333);
}

function onFaceDetected(landmarks) {
    if (!isCalibrated) {
        if (!calibrationIndicator && !document.getElementById('calibration-indicator')) {
            calibrationIndicator = createCalibrationIndicator();
        }

        attemptAutoCalibration(landmarks);
    } else {
        if (calibrationIndicator)
            removeCalibrationIndicator();

        if (!started) {
            // TODO: Send start time here.
            startExam();
            started = true;
        }

        detectOffScreenGaze(landmarks);
    }
}

function getCenterPoint(landmarks, indices) {
    let x = 0, y = 0;
    for (const i of indices) {
        const point = landmarks.positions[i];
        x += point.x;
        y += point.y;
    }
    return { x: x / indices.length, y: y / indices.length };
}

function attemptAutoCalibration(landmarks) {
    const leftEyeCenter = getCenterPoint(landmarks, LANDMARK_INDICES.LEFT_EYE);
    const rightEyeCenter = getCenterPoint(landmarks, LANDMARK_INDICES.RIGHT_EYE);
    const headPosition = getCenterPoint(landmarks, LANDMARK_INDICES.HEAD);

    const eyeDistance = Math.hypot(
        rightEyeCenter.x - leftEyeCenter.x,
        rightEyeCenter.y - leftEyeCenter.y
    );

    const eyeCenterX = (leftEyeCenter.x + rightEyeCenter.x) / 2;
    const eyeCenterY = (leftEyeCenter.y + rightEyeCenter.y) / 2;

    // Assume center of screen is midpoint
    const isLookingAtCenter =
        Math.abs(eyeCenterX / 640 - 0.5) < 0.05 &&
        Math.abs(eyeCenterY / 480 - 0.5) < 0.05;

    if (isLookingAtCenter) {
        console.log("Auto-calibration in progress " + stableFramesCount + "...");
        stableFramesCount++;

        if (stableFramesCount > 30) {
            calibrationData = { leftEyeCenter, rightEyeCenter, headPosition, eyeDistance };
            localStorage.setItem('calibrationData', JSON.stringify(calibrationData));
            isCalibrated = true;
        }
    } else {
        stableFramesCount = Math.max(0, stableFramesCount - 1);
    }
}

function detectOffScreenGaze(landmarks) {
    const currentLeft = getCenterPoint(landmarks, LANDMARK_INDICES.LEFT_EYE);
    const currentRight = getCenterPoint(landmarks, LANDMARK_INDICES.RIGHT_EYE);
    const currentHead = getCenterPoint(landmarks, LANDMARK_INDICES.HEAD);

    const headDX = (currentHead.x - calibrationData.headPosition.x) * HEAD_MOVEMENT_FACTOR;
    const headDY = (currentHead.y - calibrationData.headPosition.y) * HEAD_MOVEMENT_FACTOR;

    const leftDX = (currentLeft.x - calibrationData.leftEyeCenter.x) - headDX;
    const leftDY = (currentLeft.y - calibrationData.leftEyeCenter.y) - headDY;
    const rightDX = (currentRight.x - calibrationData.rightEyeCenter.x) - headDX;
    const rightDY = (currentRight.y - calibrationData.rightEyeCenter.y) - headDY;

    const avgDX = (leftDX + rightDX) / 2 / calibrationData.eyeDistance;
    const avgDY = (leftDY + rightDY) / 2 / calibrationData.eyeDistance;

    let offScreenDirection = null;

    if (avgDX < -HORIZONTAL_THRESHOLD) {
        offScreenDirection = 'left';
    } else if (avgDX > HORIZONTAL_THRESHOLD) {
        offScreenDirection = 'right';
    } else if (avgDY < -VERTICAL_THRESHOLD) {
        offScreenDirection = 'up';
    } else if (avgDY > VERTICAL_THRESHOLD) {
        offScreenDirection = 'down';
    }

    if (offScreenDirection && !hasSentOffScreen) {
        hasSentOffScreen = true;
        console.log("offscreen detected");
        recordProofVideo(EVENT.OFF_SCREEN);
    } else if (!offScreenDirection) {
        hasSentOffScreen = false;

        if (currentEvent == EVENT.OFF_SCREEN) {
            console.log("we should stop recording now");
            manualStop();
        }
    }
}

function addToArray(item) {
    dataArray[item] = (dataArray[item] || 0) + 1;
    localStorage.setItem('myData', JSON.stringify(dataArray));
}

function sendToServer() {
    const csrfToken2 = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const stored = localStorage.getItem('myData');
    if (!stored) return;

    const data = JSON.parse(stored);
    if (!Object.keys(data).length) return;

    fetch('/test', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-Token': csrfToken2 },
        body: JSON.stringify(data)
    }).catch(() => { });
}

function createCalibrationIndicator() {
    const indicator = document.createElement('div');
    indicator.id = 'calibration-indicator';
    indicator.style.position = 'fixed';
    indicator.style.top = '50%';
    indicator.style.left = '50%';
    indicator.style.transform = 'translate(-50%, -50%)';
    indicator.style.width = '30px';
    indicator.style.height = '30px';
    indicator.style.border = '3px solid rgba(255, 0, 0, 0.7)';
    indicator.style.borderRadius = '50%';
    indicator.style.zIndex = '100000';
    indicator.style.pointerEvents = 'none';
    indicator.style.boxShadow = '0 0 10px rgba(255, 0, 0, 0.5)';
    document.body.appendChild(indicator);
    return indicator;
}

function removeCalibrationIndicator() {
    if (calibrationIndicator && document.body.contains(calibrationIndicator)) {
        document.body.removeChild(calibrationIndicator);
    }
    calibrationIndicator = null;
}

// async function startRecording() {
//     console.log("Starting video recording...");

//     if (!mediaStream)
//         mediaStream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });

//     mediaRecorder = new MediaRecorder(stream, {
//         mimeType: 'video/webm'
//     });
//     recordedChunks = [];

//     mediaRecorder.ondataavailable = (e) => {
//         if (e.data.size > 0) {
//             recordedChunks.push(e.data);
//             // Maintain circular buffer for pre-event footage
//             if (recordedChunks.length > MAX_CHUNKS_PRE_EVENT) {
//                 recordedChunks.shift();
//             }
//         }
//     };

//     mediaRecorder.start(VID_CHUNK_DURATION);
// }

async function recordProofVideo(eventType) {
    if (isProcessingEvent) {
        console.log("trying to record for " + eventType + " while recording to " + currentEvent + ", aborting... ");
        return;
    }

    console.log("recording for " + eventType + "... ");

    currentEvent = eventType;
    isProcessingEvent = true;

    // get stream
    if (!mediaStream) {
        mediaStream = await navigator.mediaDevices.getUserMedia({
            video: true,
            audio: true
        });
    }

    // set up recorder
    const recorder = new MediaRecorder(mediaStream, { mimeType: 'video/webm' });

    // This promise will resolve once—with the full Blob—when you call recorder.stop()
    const dataPromise = new Promise(resolve => {
        recorder.ondataavailable = e => {
            if (e.data && e.data.size > 0) {
                resolve(e.data);
            }
        };
    });

    // manual-stop vs timeout
    const manualPromise = new Promise(resolve => {
        manualStop = resolve;  // call this from your detector
    });
    const timeoutPromise = new Promise(resolve => {
        setTimeout(resolve, MAX_EVENT_SECONDS * 1000);
    });

    // start, race, stop
    recorder.start();
    await Promise.race([manualPromise, timeoutPromise]);
    recorder.stop();

    // grab the Blob and upload
    const blob = await dataPromise;
    console.log("Recording complete for " + eventType + ", uploading...");
    await sendProofVideo(blob, eventType);
    console.log("Uploading complete for " + eventType);

    // cleanup
    isProcessingEvent = false;
    currentEvent = null;
}

async function sendProofVideo(blob, reason) {
    console.log(`sending proof video: ${reason}`);

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const formData = new FormData();
    formData.append('video', blob, 'proof.webm');
    formData.append('reason', reason);

    try {
        await fetch('/test', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken },
            body: formData
        });
        console.log(`Proof video sent: ${reason}`);
    } catch (err) {
        console.error('Upload error:', err);
    }
}

// async function sendBufferedWebMToServer(reason) {
//     const csrfToken3 = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
//     const chunkCopy = [...recordedChunks];
//     const blob = new Blob(chunkCopy, { type: 'video/webm' });

//     const formData = new FormData();
//     formData.append('video', blob, 'last-minute.webm');
//     formData.append('reason', reason);  // add the reason

//     try {
//         const response = await fetch('/test', {
//             method: 'POST',
//             headers: {
//                 'X-CSRF-TOKEN': csrfToken3
//             },
//             body: formData
//         });

//         if (!response.ok) {
//             console.error('Upload failed:', await response.text());
//         } else {
//             console.log(`Upload successful: ${reason}`);
//         }
//     } catch (err) {
//         console.error('Network error:', err);
//     }
// }

// Start everything
initFaceAPI()
setInterval(sendToServer, 300000);

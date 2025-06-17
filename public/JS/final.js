// Constants
const PRE_EVENT_SECONDS = 10; // Buffer before event
const MAX_EVENT_SECONDS = 30; // Max total recording length
const VID_CHUNK_DURATION = 1000; // ms
const MAX_CHUNKS_PRE_EVENT = (PRE_EVENT_SECONDS * 1000) / VID_CHUNK_DURATION;
const NO_FACE_DELAY = 200; // ms
const HORIZONTAL_THRESHOLD = 0.6;
const VERTICAL_THRESHOLD = 0.6;
const HEAD_MOVEMENT_FACTOR = 0.6;

// State
let mediaRecorder;
let recordedChunks = [];
let dataArray = JSON.parse(localStorage.getItem('myData')) || {};
let lastResult = "";
let noFaceStartTime = null;
let isProcessingEvent = false; // flag to prevent overlapping events

let isFaceCurrentlyDetected = false;  // Track if we're in a "normal face" state
let facePreviouslyDetected = false;
let hasSentOffScreen = false;
let hasSentNoFace = false;
let hasSentMultipleFaces = false;

let isCalibrated = false;
let stableFramesCount = 0;
let calibrationData = {
    leftEyeCenter: null,
    rightEyeCenter: null,
    headPosition: null,
    eyeDistance: null
};

// Landmark Indices
const LANDMARK_INDICES = {
    LEFT_EYE: [36, 37, 38, 39, 40, 41],
    RIGHT_EYE: [42, 43, 44, 45, 46, 47],
    HEAD: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16]
};

// Core logic
async function initFaceAPI() {
    await faceapi.nets.tinyFaceDetector.loadFromUri('/models');
    await faceapi.nets.faceLandmark68TinyNet.loadFromUri('/models');
    const stream = await navigator.mediaDevices.getUserMedia({ video: true });
    const video = document.createElement('video');
    video.srcObject = stream;
    video.play();
    video.onplay = () => detectFaces(video);
}

async function detectFaces(video) {
    const options = new faceapi.TinyFaceDetectorOptions({ inputSize: 128, scoreThreshold: 0.5 });
    const result = await faceapi.detectSingleFace(video, options).withFaceLandmarks(true);
    if (result) onFaceDetected(result.landmarks);
    requestAnimationFrame(() => detectFaces(video));
}

function onFaceDetected(landmarks) {
    if (!isCalibrated) {
        attemptAutoCalibration(landmarks);
    } else {
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
        stableFramesCount++;
        if (stableFramesCount > 30) {
            calibrationData = { leftEyeCenter, rightEyeCenter, headPosition, eyeDistance };
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

    // if (offScreenDirection && !hasSentOffScreen) {
    //     hasSentOffScreen = true;
    //     sendBufferedWebMToServer('Off-screen gaze detected');
    // } else if (!offScreenDirection) {
    //     hasSentOffScreen = false; // Reset flag when looking back
    // }

    if (offScreenDirection && !hasSentOffScreen) {
        hasSentOffScreen = true;
        // Replace with new recording logic
        console.log("offscreen detected");
        recordProofVideo('offscreen');
    } else if (!offScreenDirection) {
        hasSentOffScreen = false;
    }
}

function addToArray(item) {
    dataArray[item] = (dataArray[item] || 0) + 1;
    localStorage.setItem('myData', JSON.stringify(dataArray));
}

async function startDetection() {
    await faceapi.nets.tinyFaceDetector.loadFromUri('/models');
    await faceapi.nets.faceLandmark68Net.loadFromUri('/models');
    await faceapi.nets.faceExpressionNet.loadFromUri('/models');

    const stream = await navigator.mediaDevices.getUserMedia({ video: true });
    const video = document.createElement('video');
    video.srcObject = stream;
    video.play();

    video.addEventListener('play', () => {
        setInterval(async () => {
            const detections = await faceapi.detectAllFaces(video,
                                                            new faceapi.TinyFaceDetectorOptions())
            .withFaceLandmarks()
            .withFaceExpressions();

            // No face detected
            if (detections.length === 0) {
                if (Date.now() - noFaceStartTime >= NO_FACE_DELAY && !hasSentNoFace) {
                    hasSentNoFace = true;
                    console.log("Noface detected");
                    recordProofVideo('Noface detected'); // Updated
                }
                return;
            }
            // Multiple faces detected
            else if (detections.length > 1) {
                if (!hasSentMultipleFaces && !isFaceCurrentlyDetected) {
                    hasSentMultipleFaces = true;
                    console.log("Multiface detected");
                    recordProofVideo('Multiface detected'); // Updated
                }
                return;
            }

            // Single face detected - normal state
            isFaceCurrentlyDetected = true;

            // Reset flags when returning to normal state
            if (!isFaceCurrentlyDetected) {
                hasSentNoFace = false;
                hasSentMultipleFaces = false;
            }

            noFaceStartTime = null;
            const top = Object.entries(detections[0].expressions).sort((a, b) => b[1] - a[1])[0];
            if (lastResult !== top[0]) {
                addToArray(top[0]);
                lastResult = top[0];
            }
        }, 333);
    });
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

async function startRecording() {
    const stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
    mediaRecorder = new MediaRecorder(stream);
    recordedChunks = [];

    mediaRecorder.ondataavailable = (e) => {
        if (e.data.size > 0) {
            recordedChunks.push(e.data);
            // Maintain circular buffer for pre-event footage
            if (recordedChunks.length > MAX_CHUNKS_PRE_EVENT) {
                recordedChunks.shift();
            }
        }
    };

    mediaRecorder.start(VID_CHUNK_DURATION);
}

async function recordProofVideo(reason) {
    console.log("recording for " + reason + "... ");
    console.log("other event recorging? " + isProcessingEvent);

    if (isProcessingEvent) return;
    isProcessingEvent = true;

    // Stop current recording to preserve buffer
    mediaRecorder.stop();

    // Wait for mediaRecorder to finish processing
    await new Promise(resolve => {
        mediaRecorder.onstop = resolve;
    });

    // Capture pre-event footage
    const preEventChunks = [...recordedChunks];
    recordedChunks = [];

    // Start recording event footage
    const stream = mediaRecorder.stream;
    const eventRecorder = new MediaRecorder(stream);
    let eventChunks = [];

    eventRecorder.ondataavailable = (e) => {
        if (e.data.size > 0) eventChunks.push(e.data);
    };
        eventRecorder.start();

        // Record for the full MAX_EVENT_SECONDS (including pre-event)
        const eventDuration = MAX_EVENT_SECONDS * 1000;
        setTimeout(() => {
            eventRecorder.stop();
        }, eventDuration);

        // Wait for event recorder to finish
        await new Promise(resolve => {
            eventRecorder.onstop = resolve;
        });

        // Combine pre-event and event footage
        const proofChunks = [...preEventChunks, ...eventChunks];
        const blob = new Blob(proofChunks, { type: 'video/webm' });

        // Send to server
        await sendProofVideo(blob, reason);

        // Restart main recording
        startRecording();
        isProcessingEvent = false;
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
initFaceAPI();
startDetection();
startRecording(); // Initialize recording
setInterval(sendToServer, 300000);

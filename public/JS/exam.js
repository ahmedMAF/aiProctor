let next = document.getElementById("next");
let time = document.getElementById("time");
let questionText = document.getElementById('question-text');
let multipleChoose = document.getElementById('mc');
let trueOrFalse = document.getElementById('tof');
let opMultipleChoose = document.getElementsByClassName('op');
let grade = document.getElementById('grade');
let qId = document.getElementById('q-id');
let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

let [minutes, seconds] = time.innerText.split(":").map(Number);
let t = minutes * 60 + seconds;

function startExam() {
    document.getElementById("videoCal").style.display = "none";

    setInterval(function () {
        let minutes = Math.floor(t / 60);
        let seconds = t % 60;
        time.textContent = `${minutes}:${seconds < 10 ? '0' + seconds : seconds}`;
        if (minutes == 0 && seconds == 0) {
            document.getElementById("finish").click();
        }
        else {
            t--;
        }
    }, 1000);
}
//next.onclick = loadNextQuestion();

function loadNextQuestion() {
    fetch(`/exam/next-question/${examId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({
            answer: document.querySelector('input[name="answer"]:checked')?.value || null,
            questionId: qId.value,
        })
    })
        .then(response => {
            let check = document.querySelector('input[name="answer"]:checked');
            if (check) {
                check.checked = false;
            }
            if (response.status === 404) {
                multipleChoose.style.display = 'none';
                trueOrFalse.style.display = 'none';
                questionText.innerText = "Good luck, you have completed the exam";
                next.style.display = "none";
                document.getElementById("finish").style.display = "block";
                document.getElementById("mark").style.display = "none";
                return;
            }
            return response.json();
        })
        .then(data => {
            if (data) {
                qId.value = data.id;
                questionText.innerText = data.text;
                grade.innerText = data.grade;
                console.log(data);

                if (data.type == 1) {
                    multipleChoose.style.display = 'block';
                    trueOrFalse.style.display = 'none';
                    for (let i = 0; i < 4; i++) {
                        opMultipleChoose[i].innerText = data.answers[i];
                    }
                }
                else if (data.type == 2) {
                    multipleChoose.style.display = 'none';
                    trueOrFalse.style.display = 'block';
                }
            }
        })
}

next.onclick = loadNextQuestion;

window.history.replaceState({}, '', `/exam/next-question/refresh/${examId}`);

//window.onload = loadNextQuestion();
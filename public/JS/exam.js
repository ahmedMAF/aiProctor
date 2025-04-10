let next = document.getElementById("next");
let time = document.getElementById("time");
let questionText = document.getElementById('question-text');
let multipleChoose = document.getElementById('mc');
let trueOrFalse = document.getElementById('tof');
let opMultipleChoose = document.getElementsByClassName('op');
let grade = document.getElementById('grade');

let [minutes, seconds] = time.innerText.split(":").map(Number);
let t = minutes * 60 + seconds;

setInterval(function(){
    let minutes = Math.floor(t / 60);
    let seconds = t % 60;
    time.textContent = `${minutes}:${seconds < 10 ? '0' + seconds : seconds}`;
    t--;
},1000);

//next.onclick = loadNextQuestion();

function loadNextQuestion() {
    fetch(`/exam/next-question/${examId}`, {
        method: 'GET',
    })
    .then(response => {
        if (response.status === 404) {
            questionText.innerText = "الامتحان انتهى. شكراً لتقديمك!";
           // document.getElementById('next-btn').disabled = true;
            return;
        }
        return response.json();
    })
    .then(data => {
        if (data) {
            questionText.innerText = data.text;
            grade.innerText = data.grade;
            console.log(data);

            if(data.type == 1){
                multipleChoose.style.display = 'block';
                trueOrFalse.style.display = 'none';
                for(let i = 0 ; i < 4 ; i++){
                    opMultipleChoose[i].innerText = data.answers[i];
                }
            }
            else if(data.type == 2){
                multipleChoose.style.display = 'none';
                trueOrFalse.style.display = 'block';
            }
        }
    })
}

next.onclick = loadNextQuestion;

window.onload = loadNextQuestion();
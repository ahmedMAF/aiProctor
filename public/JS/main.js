//elements
let navBar = document.querySelector("nav");
let openIconForSmallScrean = document.getElementById("open-men");
let openIconForSmallScreanUL = document.querySelector("nav ul");

//openIconForSmallScrean
openIconForSmallScrean.onclick = function(){
    openIconForSmallScreanUL.classList.toggle("display-blok-ul");
    console.log("sadas");
};
document.onclick = function(e){
    if(e.target.classList[0] !== "open-men"){
        openIconForSmallScreanUL.classList.remove("display-blok-ul");
    }
};
//change nav bar style whine scroll
window.onscroll = function(){
    if(window.scrollY >= 100){
        navBar.style = "background-color: #6c63ff";
    }
    else{
        navBar.style = "background-color: transparent";
    }
};
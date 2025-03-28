let add = document.getElementById("add");
let contant = document.getElementById("contant");
let selectType = document.getElementById("select-type");
let mc = document.getElementById("m-c");
let tof = document.getElementById("t-o-f");

add.onclick = function(){
    contant.style.display = "block";
    add.style.margin = "0px auto 30px auto";
}

selectType.onchange = function(){
    if(this.value == "1"){
        tof.style.display = "none";
        mc.style.display = "block";
    }
    else if(this.value == "2"){
        mc.style.display = "none";
        tof.style.display = "block";
    }
    else{
        mc.style.display = "none";
        tof.style.display = "none";
    }
}
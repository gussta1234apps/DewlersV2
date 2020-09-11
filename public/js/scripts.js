function blinker() {
    var element = document.getElementById("blink");
    var element2 = document.getElementById("blink2");
    element.classList.add("blink_me");
    element2.classList.add("blink_me");
    console.log(element);
}

function createdewl() {

    $('#exampleModalCenter').modal('toggle');
}

// ACTIVE_LI FUNCTION
function active_li(n){
    console.log(n);
    var li = document.getElementsByClassName("history-li");
    var i = 0;
    for (i=0; i <= 2; i++){
        console.log("--------")
        console.log(i);
        console.log(n);
        if(i == n){
            li[i].style.background = "#00d9aa"
        }else{
            li[i].style.background = "#000000"
        }
    }
}

var $boxes = $(".choose-winner-box").click(function(){
        $boxes.removeClass("active-winner");
        $(this).addClass("active-winner");
    });

// funciones de la seccion de friend



function accept_request($id){

    window.location.href ="/public/acept_friend/"+$id;


}

function refuse_request($id){
    window.location.href ="/public/refuse_friend/"+$id;

}

function aceptduel(){




}


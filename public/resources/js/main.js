var showMenuBox = true;
var showFriendsBox = false;
var currentDewls = '';
var witnessDewls = '';

$(document).ready(function(){
   /*  if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
        $('.create-dewl-button-desktop').hide();
    }else{
        $('.create-dewl-mobile').hide();
    } */
    updateCurrentDewls();
    setInterval(updateCurrentDewls,15000);
    $('.request-body').slideUp();
    showHome()


    $('.menu-box').css('left','-350px');
    $('.friends-box').css('right','-350px');
    $('.r-u-sure').hide();

    $('.menu-button').click(function(){
        toggleMenu()
    });

    $('.witness-player-selector .btn').click(function(){
        togglewinnerChooser();
    });
    $('.r-u-sure .btn').click(function(){
        togglewinnerChooser();
    });

    $('.dewler-search-input').keyup(function(){
        if($('.dewler-search-input').val().length>0){
            $('.friends-request').slideUp(300);
            $('.friends-results').addClass("full-table");
        }else{
            $('.friends-request').slideDown(300);
            $('.friends-results').removeClass("full-table");


        }
    });

    $('.friends-request-notification').click(function(){
        $('.friends-body').hide(0);
        $('.request-body').show(300);
    });

    $('.return-to-friends-body').click(function(){
        $('.request-body').hide(0);
        $('.friends-body').show(0);
    });

    $('.friends-dewl-button').click(function(){
        $('#createDewlModalButton').click();
        toggleFriendBox();
    });

    $('.create-dewl-button-desktop').click(function(){
        if(showMenuBox){toggleMenu();}else if(showFriendsBox){toggleFriendBox();}
        $('#createDewlModalButton').click();
    });

    $('.create-dewl-button-mobile').click(function(){
        if(showMenuBox){toggleMenu();}else if(showFriendsBox){toggleFriendBox();}
        $('#createDewlModalButton').click();
    });

    $('.dewl-winrate').click(function(){
        if(showMenuBox){toggleMenu();}else if(showFriendsBox){toggleFriendBox();}
        $('#showFancyBox').click();
    });

    $('.dewler-search-input').keyup(function(){
        console.log('typping');
        var dewlerName = $('.dewler-search-input').val();

        if(dewlerName.length>0){
            $('#friends-container').slideUp(0);
            var load = '<div class="spinner-border text-danger" style="padding:5px;" role="status"></div><h5 class="center text-center">Loading</h5>';
            $('#dewler-search-container').html(load);
            searchDewler(dewlerName);
        }else{
            searchValidation();
        }
    });
});

let showHome=()=>{
    $('#history').slideUp(0);
    $('#home').slideDown(0);
    toggleMenu()
}

let showHistory=()=>{
    $('#home').slideUp(0);
    $('#history').slideDown(0);
    toggleMenu()
}

let toggleMenu=()=>{
    if(showMenuBox){
        $('.menu-box').css('left','-350px');
        //$('.menu-box').hide(500);
        showMenuBox = false;
    }else{
        if(showFriendsBox){toggleFriendBox()}
        $('.menu-box').show(300);
        $('.menu-box').css('left','0px');
        showMenuBox = true;
    }
}

let toggleFriendBox=()=>{
    if(showFriendsBox){
        $('.friends-box').css('right','-350px');
        //$('.menu-box').hide(500);
        showFriendsBox = false;
    }else{
        if(showMenuBox){toggleMenu()}
        $('.friends-box').show(300);
        $('.friends-box').css('right','0px');
        showFriendsBox = true;
    }
}

let togglewinnerChooser=()=>{
    $('.choose-winner').toggle();
    $('.r-u-sure').toggle();
}

let loadPlayerToDewl=(id,name)=>{
    $('#challendged').val(id);
    $('#playerInput').val(name);
    $('#createDewlModalButton').click();
}


let searchDewler=(dewlerName)=>{
    $.ajax({
        url:'/searchDewler/' + dewlerName,
        method:'GET'
    }).done(function(data){
        if(data=="No-users"){
            data = '<h5 class="center text-center">0 results</h5>';
        }
        $('#dewler-search-container').html(data);
        searchValidation();
    });
    
}

let searchValidation=()=>{
    if($('.dewler-search-input').val().length==0){
        //setTimeout(function(){ FUNCTION }, 0);
        
        $('#friends-container').slideDown(300);
        $('#dewler-search-container').empty();
        console.log('empty');
    }
}

let prepareToCreateDewl=()=>{
    var id = $('#players option[value="' + $('#playerInput').val() + '"]').data('id');
    console.log(id);
    $('#challendged').val(id);
}

let prepareWitnessToCreateDewl=()=>{
    var id = $('#witnessList option[value="' + $('#witnessInput').val() + '"]').data('id');
    console.log(id);
    $('#witness').val(id);
}

let createDewlValidations=()=>{
    if(true){
        return true;
    }else{
        return false;
    }
}

let updateCurrentDewls=()=>{
    console.log("actualizando current");
    $.ajax({
        url:'/updateCurrentDewls',
        data:{
            getData:true
        }
    }).done(function(data){

        if(data!=currentDewls){
            console.log("Se actualizó");
            $('#currentDewlInformation').html(data);
        }
        else{
            console.log('no hay cambios');
        }
        currentDewls = data;
    });

    console.log("actualizando witness");
    $.ajax({
        url:'/updateWitnessDewls',
        data:{
            getData:true
        }
    }).done(function(data){

        if(data!=witnessDewls){
            console.log("Se actualizó");
            $('#witnessDewls').html(data);
        }
        else{
            console.log('no hay cambios');
        }
        witnessDewls = data;
    });
}
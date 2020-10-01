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
   // $('.r-u-sure').hide();

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

// let togglewinnerChooser=()=>{
//     $('.choose-winner').toggle();
//     $('.r-u-sure').toggle();
// }

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
    var title = $('#exampleInputEmail1').val();
    var desc = $('#descriptio').val();
    var stacks = $('#pot').val();
    var vs = $('#playerInput').val();
    var checkb = $('#customCheck1')
    var witnss = $('#witnessInput').val();
    var tdate = $('#datepicker').val();
   // if(true){
    if((title=="")
        || (desc =="" || desc.length < 20)
        || (stacks =="")
        || (vs =="")
        || (checkb.is(':checked') && witnss == "")
        || (tdate == "")){
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Please complete all fields',
            }
        )
        return false;
    }else{
        return true;
    }
}
let createDewlValidationsDON=()=>{

    var desc = $('#descriptionDON').val();


    // if(true){
    if(desc ==""){
        Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please complete all fields',
            }
        )
        return false;
    }else{
        return true;
    }
}

let createreview=()=>{

    var rev = $('#txtarea').val();

    // if(true){
    if(rev ==""){
        Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please add a review',
            }
        )
        return false;
    }else{
        return true;
    }
}


function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

let updateCurrentDewls=()=>{
    $.ajax({
        url:'/updateCurrentDewls',
        data:{
            getData:true
        }
    }).done(function(data){
        if(data!=currentDewls){
            $('#currentDewlInformation').html(data);
        }
        currentDewls = data;
    });

    $.ajax({
        url:'/updateWitnessDewls',
        data:{
            getData:true
        }
    }).done(function(data){

        if(data!=witnessDewls){
            $('#witnessDewls').html(data);
        }
        witnessDewls = data;
    });
}
let createwitnessreview=(id)=>{
    //console.log($('#witness_review_id').length);
    if($('#witness_review_id').length==0){
        //console.log("no existe");
    }else{
        //console.log("ya existe y se tratara de borrar");
        $('#witness_review_id').remove();
    }
    $('<input>').attr({type:'hidden',name:'id',value:id,id:'witness_review_id'}).appendTo('#witness_review');
    //console.log(id)
}

let loadDoubleOrNothingPlayer=(title,pot,witness,id,name)=>{
     console.log("title"+title);
     console.log("pot"+pot);
     console.log("witness"+witness);
     console.log("id"+id);
     console.log("name"+name);
    if($('#donduel').length==0){
        //console.log("no existe");
    }else{
        //console.log("ya existe y se tratara de borrar");
        $('#donduel').remove();
    }
    $('<input>').attr({type:'hidden',name:'duel',value:id,id:'donduel'}).appendTo('#donmodalform');
     $('#dontitle').val(title);
    $('#donpot').val(pot*2);
   // $('#donwitnessInput').val(witness);
    $('#donduel').val(id);
    $('#donchallendged').val(name);
    // $('#playerInput').val(name);

}

let addamount=(amount)=>{
    if($('#amount').length==0){
        console.log("no existe");
    }else{
        console.log("ya existe y se tratara de borrar");
        $('#amount').remove();
    }
    $('<input>').attr({type:'hidden',name:'amount',value:amount,id:'amount'}).appendTo('#addstacksforms');

        console.log('Se agrego e valor de :'+amount+'/n');
        $('#addstacksforms').submit();
}


let updateDewlViewState=(dewlID,state)=>{
    $.ajax({
        url:'/updateDewlViewState/' + dewlID + '/' + state,
        data:{
            updateViewState:true
        }
    });
}
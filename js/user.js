$(document).ready(function(){


    $(document).on("click",".logout",function(){
       window.location.href="public/userAction/logout.php";
    });

    $(document).on('click','.add_review',function(){

        $("#txt_place_id").val($(this).attr('data-place_id'));

        $.get("public/userAction/checkuserlogin.php",function(data){
            if(data == 1) {
                $("#addreview").modal('show');
            }else if(data == 0){
                bootbox.alert("Please log in.");

            }
        });

    });

    $("#frm_add_reviews").submit(function(e){
        var rating = $('#rating-input').val();
        var text= $("#message-text").val();
        var placeid= $("#txt_place_id").val();
        $.post("public/userAction/saveUserReview.php",{rating:rating,placeid:placeid,reviewtext:text},function(data){
            if(data == "not-loggedin"){
                $("#review_error_container").html("<div class='alert alert-warning alert-dismissable'> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>Please Login first.</strong></div>");
            }else{
                $("#review_error_container").html("<div class='alert alert-success alert-dismissable'> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>Review submitted successfully.</strong></div>");
                $('#rating-input').rating('clear');
                $("#message-text").val("");

                setTimeout(function(){
                    $("#review_error_container").animate({},'slow','swing',function(){
                        $("#review_error_container").html("");
                    });

                },3000)

            }
        });
        e.preventDefault();
    });

    $("#frm_regiters").submit(function(e){
        var user_name = $("#frm_regiters input[name='username'] ").val();
        var user_email = $("#frm_regiters input[name='useremail']").val();
        var password  = $("#frm_regiters input[name='userpassword']").val();
        if(user_name =='' || user_email =='' || password ==''){

            $("#reg_error").html("").prepend("<div class='alert alert-danger alert-dismissable'> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>Please fill up empty fields</strong></div>");
        }else{
            $.post("public/userAction/register.php",{name:user_name,email:user_email,password:password},function(data){
                if(data=='0'){
                    $("#reg_error").html("").fadeIn("<div class='alert alert-danger alert-dismissable'> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>Please fill up empty fields</strong></div>");
                }else{
                    $("#reg_error").html("").prepend("<div class='alert alert-success alert-dismissable'> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>Registration Successful</strong></div>");
                    $(".userinfo_container").html( user_name+' <div style="padding-top: 2px;padding-bottom: 10px;" id="btn-group-login" class="btn-group" role="group" aria-label="Default button group"><button type="button" class="btn btn-primary btn-sm logout">Logout</button></div>');
                    $("#status").hide();
                    $(".login_wrapper").html("");
                    $("#btn_register").hide();
                    $(".userinfo_container").css("padding","10px 15px");

                    $("#frm_regiters input[name='username'] ").val("");
                    $("#frm_regiters input[name='useremail']").val("");
                    $("#frm_regiters input[name='userpassword']").val("");

                    setTimeout(function(){
                        $('#registerModal').fadeOut('slow');
                    },1000)

                }
            })

        }

        e.preventDefault();
    });

    $("#user_login").submit(function(e){
        var user_email = $("#txt_email").val();
        var password   = $("#txt_password").val();

        if(user_email =='' || password ==''){

        }else {
            $.post("public/userAction/login.php",{email:user_email,password:password},function(data){
                var res = JSON.parse(data);
                console.log(res.res);
                if(res=='0'){
                    bootbox.alert("User name and password is empty.");
                }else if(res.res=='1'){
                    $(".userinfo_container").html(res.username+' <div style="padding-top: 2px;padding-bottom: 10px;" id="btn-group-login" class="btn-group" role="group" aria-label="Default button group"><button type="button" class="btn btn-primary btn-sm logout">Logout</button></div>');
                    $("#status").hide();
                    $(".login_wrapper").html("");
                    $("#btn_register").hide();
                    $(".userinfo_container").css("padding","10px 15px");
                    $("#txt_email").val("");
                    $("#txt_password").val("");
                    setTimeout(function(){
                        $('#registerModal').modal('hide');
                    },1000);
                }else{
                    bootbox.alert(res.res);
                }


            });
        }

        e.preventDefault();
    });

});
const Auth = {
    init : function(){
        this.transitionFormInput();
        // this.autoFocus();
        this.setCenterScreenForForm();
        $(window).on('resize', this.setCenterScreenForForm)
    },
    transitionFormInput : function(){
        var self = this;
        $(".form-auth").find("input").each(function(){
            // let focusin = function(){
            //     let formGroup = $(this).closest(".form-group");
            //     formGroup.addClass("validated");
            //     formGroup.prev().addClass("margin--moved");
            // }
            // let focusout = function(){
            //     let formGroup = $(this).closest(".form-group");
            //     if($(this).val() == ''){
            //         formGroup.removeClass("validated");
            //         formGroup.prev().removeClass("margin--moved");
            //     }
            // }
            //
            // $(this).on("focusin", focusin);
            // $(this).on("focusout", focusout);
            // $(this).on("keypress", function(e){
            //     if(e.keyCode == 13){
            //         e.preventDefault();
            //         return false;
            //     }
            // });

            if($(this).hasClass('number-only')){
                self.numberOnly(this);
            }
        });
    },
    numberOnly : function(el){
        $(el).attr('type', 'number').on("beforeinput", function(e){
            var text = e.originalEvent.data;
            if(text == null){
                return;
            }
            return $.inArray(text.toLowerCase(), ['e', '+', '-']) == -1;
        });
    },
    autoFocus : function(){
        $("[autofocus]").focus();
    },
    register : function(btn, callback){
        var form        = $(btn).closest("form");
        var formData    = new FormData(form[0]);
        var urlReq      = form.attr('action');
        var succFunc    = function(result){
            if(typeof callback == "function"){
                callback(result);
            }
            if(result.success == false){
                return alert(result.message);
            }
            if(typeof result.redirect == "undefined"){
                result.redirect = "";
            }
            if(typeof result.message != 'undefined' && urlReq.indexOf("/auth/login") == -1){
                alert(result.message);
            }
            switch (result.redirect){
                case "login" :
                    window.location.href = '/auth/verify';
                    break;
                case "home" :
                    window.location.href = '/home';
                    break;
            }
        }
        Request.ajax(urlReq, formData, succFunc).fail(function(error){
            if(typeof error != "object"){
                return alert("Unable to register at this time. Please reload the page and try again. Or report to the admin!");
            }
            var aryErr = Object.values(error.responseJSON.errors);
            alert(aryErr.join("\n"));
        });
    },
    reSendOtp : function(){
        window.event.preventDefault();
        Request.ajax('/auth/re-send-otp', function(result){
            alert(result.message);
        });
    },
    login : function(btn){
        return this.register(btn, function(result){
            if(result.success == false){
                $("#enter_password").val('').focusout();
            }
        });
    },
    checkOtp : function(btn){
        var callback = null;
        if($(btn).attr('data-form-forgot') == '1'){
            callback = function(result){
                if(result.success){
                    $("#formConfirmOTP").hide(300);
                    $("#formEditPassword").show(300);
                }
            }
        }
        return this.register(btn, callback);
    },
    forgotPassword : function(btn){
        return this.register(btn, function(result){
            if(result.success){
                $("#formEnterUsername").hide(300);
                $("#formConfirmOTP").show(300);
            }
        });
    },
    editPasswordForgot : function(btn){
        return this.register(btn);
    },
    setCenterScreenForForm : function(){
        if(window.innerWidth <= 990){
            $("#box-auth").css("margin-top", "");
            return;
        }
        var boxAuthHeight = $("#box-auth").height();
        var windowHeight = window.innerHeight;
        var indexMargin = Math.abs((windowHeight / 2) - (boxAuthHeight / 2));
        $("#box-auth").css("margin-top", indexMargin + "px");
    }
}

Auth.init();

const Auth = {
    init : function(){
        //this.transitionFormInput();
    },
    transitionFormInput : function(){
        const self = this;
        $(".form-auth").find("input").each(function(){
            if($(this).hasClass('number-only')){
                self.numberOnly(this);
            }
        });
    },
    numberOnly : function(el){
        $(el).attr('type', 'number').on("beforeinput", function(e){
            const text = e.originalEvent.data;
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
        const form = $(btn).closest("form");
        const formData = new FormData(form[0]);
        const urlReq = form.attr('action');
        const succFunc = function (result) {
            $(btn).prop('disabled', false);
            if (typeof callback == "function") {
                callback(result);
            }
            if (result.success == false) {
                form.find('p.error').remove();
                return alertify.alertDanger('Error', result.message);
            }
            if (typeof result.redirect == "undefined") {
                result.redirect = "";
            }
            if (typeof result.message != 'undefined' && urlReq.indexOf("/auth/login") == -1) {
                alertify.alertSuccess(result.message);
            }
            switch (result.redirect) {
                case "login" :
                    window.location.href = '/auth/verify';
                    break;
                case "home" :
                    window.location.href = '/home';
                    break;
            }
        };
        $(btn).prop('disabled', true);
        Request.ajax(urlReq, formData, succFunc).fail(function(error){
            $(btn).prop('disabled', false);
            if(typeof error != "object"){
                return alertify.alertDanger("Unable to register at this time. Please reload the page and try again. Or report to the admin!");
            }
            const errors = error.responseJSON.errors;
            const $p = $('<p />').addClass('error mb-0 pl-3');
            form.find('p.error').remove();
            for(const key in errors) {
                const formGroup = form.find('[name="'+key+'"]').closest('.form-group');
                const errEl = $p.clone().text(errors[key][0]);
                formGroup.append(errEl)
            }
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
        let callback = null;
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
    }
}

Auth.init();

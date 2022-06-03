var Main = {
    getOtpTransfer : function(){
        window.event.preventDefault();
        var $buttonGetOtp = $(".area-transfer .btn-get-otp");
        $buttonGetOtp.attr("disabled", "disabled");
        Request.ajax('/send-otp-transfer', function(result){
            if(!result.success){
                return alert("Fail send OTP");
            }
            $("#otp_key").val(result.data.otp_key);
            $buttonGetOtp.removeAttr("disabled");
            alert(result.message)
        });
    },
    submitTransfer : function(el){
        window.event.preventDefault();
        var $form = $(el).closest('form');
        var formData = new FormData($form[0]);
        var urlAction = $form.attr('action');
        Request.ajax(urlAction, formData, function(result){
            alert(result.message);
            if(result.success){
                $form.trigger("reset");
            }
        })
    },
    transferToInvest : function(el){
        window.event.preventDefault();
        var $form = $(el).closest('form');
        var formData = new FormData($form[0]);
        var urlAction = $form.attr('action');
        Request.ajax(urlAction, formData, function(result){
            if(!result.success){
                return alert(result.message);
            }
            $form.trigger('reset');
            $("#transferToInvest").modal("hide");
            $(".box-money.money-invest .money-text").text(result.data.invest);
            $(".box-money.money-wallet .money-text").text(result.data.wallet);
        })
    },
    transferIBToWallet : function(el){
        window.event.preventDefault();
        var $form = $(el).closest('form');
        var formData = new FormData($form[0]);
        var urlAction = $form.attr('action');
        Request.ajax(urlAction, formData, function(result){
            alert(result.message)
            if(!result.success){
                return;
            }
            $form.trigger('reset');
            $("#transferIBToWallet").modal("hide");
            $(".box-money.money-ib .money-text").text(result.data.ib);
            $(".box-money.money-wallet .money-text").text(result.data.wallet);
        })
    },
    changePassword : function(el){
        window.event.preventDefault();
        var $form = $(el).closest('form');
        var formData = new FormData($form[0]);
        var urlAction = $form.attr('action');
        Request.ajax(urlAction, formData, function(result){
            if(!result.success){
                return alert(result.message);
            }
            $form.trigger('reset');
            $("#changePasswordModal").modal("hide");
            alert("Password changed!\nPlease login after change password!");
            window.location.href = "/auth/logout";
        })
    },
    showLeftMenu : function(){
        $("body").addClass('left-menu-mobile-open');
    },
    hideLeftMenu : function(){
        $("body").removeClass('left-menu-mobile-open');
    },
    rebuildSttTable : function($table){
        var $tbody = $table.find("tbody");
        var stt = 1;
        $tbody.find("tr").each(function(){
            $(this).find("td:first-child").text(stt++);
        });
    }
}

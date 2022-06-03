var Admin = {
    saveSetting: function(btn){
        var $input = $(btn).parent().find('input');
        var typeSetting = $input.attr('data-type');
        var valSetting = $input.val().trim();
        var param = {
            type : typeSetting,
            value : valSetting
        }
        Request.ajax('/change-setting', param, function(result){
            if(result.success){
                alert('Save Setting success! Please reload page to update Interest History!')
            }else{
                alert(result.message)
            }
        })
    },
    changeStatusTransfer : function(el, type){
        var $tr = $(el).closest("tr");
        var url = $tr.attr('data-url') || '/request-liquidity';
        var params = {
            type : type,
            code : $tr.attr('data-code')
        }
        Request.ajax(url, params, function(result){
            alert(result.message);
            if(result.success){
                var $table = $tr.closest("table");
                $tr.remove();
                Main.rebuildSttTable($table);
            }
        });
    },
    saveSystemSetting : function(el){
        window.event && window.event.preventDefault();
        var $form = $(el).closest("form");
        var url = $form.attr('action');
        var formData = new FormData($form[0]);
        Request.ajax(url, formData, function(result){
            alert(result.message)
        });
    }
}

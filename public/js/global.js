window.toggleInputLabel = function(el) {
    if($(el).val().trim() == '') {
        $(el).closest('.form-group').removeClass("input-valid");
    }else{
        $(el).closest('.form-group').addClass("input-valid");
    }
}

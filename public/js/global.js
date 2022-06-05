window.toggleInputLabel = function(el) {
    if($(el).val().trim() == '') {
        $(el).closest('.form-group').removeClass("input-valid");
    }else{
        $(el).closest('.form-group').addClass("input-valid");
    }
}

$('[inline-input]').each(function(){
    $(this).on('focus', function(){
        this.parentNode.classList.add('input-valid');
    });
    $(this).on('change focusout', function(){
        toggleInputLabel(this);
    });
});
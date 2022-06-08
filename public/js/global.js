window.toggleInputLabel = function(el) {
    if($(el).val().trim() == '') {
        $(el).closest('.form-group').removeClass("input-valid");
    }else{
        $(el).closest('.form-group').addClass("input-valid");
    }
}

const numberOnly = function(el){
    $(el).attr('type', 'number').on("beforeinput", function(e){
        const text = e.originalEvent.data;
        if(text == null){
            return;
        }
        return $.inArray(text.toLowerCase(), ['e', '+', '-']) == -1;
    });
}

window.addEventListener('DOMContentLoaded', (event) => {
    $('.number-only').each(function(){
        numberOnly(this);
    });
});

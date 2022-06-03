const Crypto = {
    onChangeMethodSelect : function(el){
        var type = $(el).val();
        var $form = $(el).closest('form');
        var $textLabel = $form.find('.rate-crypto-change');
        var typeForm = $form.find('#type_form').val();
        var rateSetting = window.rateCyptoSetting[typeForm][type];
        $textLabel.text(rateSetting + " " + type + "/POUND");
        $("#crypto-amount").trigger("change");
        $form.find('[name="rate"]').val(rateSetting)
    },
    onChangeAmountCypto : function(el){
        var amount = parseInt($(el).val() || 0);
        var method = $("#crypto-method").val();
        var typeForm = $('#type_form').val();
        var rateSetting = parseFloat(window.rateCyptoSetting[typeForm][method]);
        $("#crypto-amount-prev").val(amount * rateSetting);
    },
    copyAddress : function(){
        Home.copyInForm('cypto-to-address')
    }
}

var SearchForm = {
    init : function(){
        this.setDatepicker();
    },
    setDatepicker : function(){
        $.fn.datepicker.defaults.format = "dd/mm/yyyy";
        $(".datepicker").each(function(){
            var ref  = $(this).attr('data-ref');
            var type = $(this).attr('data-type');
            $(this).datepicker().on('changeDate', function (selected) {
                var dateSelected = selected.date;
                if(dateSelected == undefined){
                    return;
                }
                var date = new Date(dateSelected.valueOf());
                var action = type == 'from' ? 'setStartDate' : 'setEndDate';
                $('#' + ref).datepicker(action, date);
            });
        });
    },
    getMonday : function(){
        var d    = new Date();
        var day  = d.getDay()
        var diff = d.getDate() - day + (day == 0 ? -6 : 1);
        return new Date(d.setDate(diff));
    },
    getFirstDayInMonth : function(){
        var d = new Date();
        var currMonth = d.getMonth();
        var currYear = d.getFullYear();
        return new Date(currYear, currMonth, 1);
    },
    getElInputDate : function(el){
        var $el = $(el).parent();
        var from = $el.attr('data-from');
        var to = $el.attr('data-to');
        return {
            from : $("#" + from),
            to : $("#" + to)
        }
    },
    setDateToday : function(el){
        var $inputDate = this.getElInputDate(el);
        this.setValueDatepicker($inputDate, {
            from : null,
            to : new Date()
        });
    },
    clearDate : function(el){
        var $inputDate = this.getElInputDate(el);
        this.setValueDatepicker($inputDate, {
            from : null,
            to : null
        });
    },
    setDateThisMonth : function(el){
        var $inputDate = this.getElInputDate(el);
        this.setValueDatepicker($inputDate, {
            from : this.getFirstDayInMonth(),
            to : new Date()
        });
    },
    setDateThisWeek : function(el){
        var $inputDate = this.getElInputDate(el);
        this.setValueDatepicker($inputDate, {
            from : this.getMonday(),
            to : new Date()
        });
    },
    setValueDatepicker : function(objInput, objDate){
        objInput.from.datepicker('setDate', null);
        objInput.to.datepicker('setDate', null);
        setTimeout(function(){
            objInput.from.datepicker('setDate', objDate.from);
            objInput.to.datepicker('setDate', objDate.to);
        }, 300);
    },
    search : function(el){
        var $form = $(el).closest("form");
        var url = $form.attr('action');
        var formData = new FormData($form[0]);
        Request.ajax(url, formData, function(result){
            if(!result.success){
                return alert(result.message);
            }
            var typeSearch = result.typeSearch || '';
            switch (typeSearch){
                case 'user' :
                    $("#table-user-list").html(result.data.html);
                    $("#table-user-tree-parent").html(result.data.tree_parent);
                    break;
                case 'liquidity' :
                    $("#table-liquidity-list").html(result.data.html);
                    break;
                case 'internal-transfer' :
                    $("#table-internal-transfer").html(result.data.html);
                    break;
                case 'cripto-history' :
                    $("#crypto-history").html(result.data.html);
                    break;
                case 'interest-rate-history' :
                    $("#interest-rate-history").html(result.data.html);
                    break;
            }
        })
    },
    gotoPagePagination : function(el, page, url = ''){
        if(url != ''){
            return Home.getListUserRequest(url);
        }
        var $tableDetail = $(el).closest('.table-detail');
        var $formSearch = $tableDetail.find('.search-form form');
        $formSearch.find('[name="page"]').val(page);
        $formSearch.find(".btn-search").trigger('click');
    }
}

SearchForm.init();

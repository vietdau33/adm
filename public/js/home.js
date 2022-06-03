const Home = {
    tableDetail : null,
    init : function(){
        this.calcHeightContent();
        this.setHeightAreaInfomation();
        // this.removeLoadingSystem();
        var self = this;
        $(window).on('resize', function(){
            self.calcHeightContent();
        });
    },
    calcHeightContent : function(){
        var heightHeader    = $("#header-content")[0].offsetHeight;
        var footerHeader    = $("#footer-content")[0].offsetHeight;
        var height          = "calc(100vh - " + (heightHeader + footerHeader) + "px)";
        $("#main-content").css({
            height      : height,
            minHeight   : height,
            maxHeight   : height
        });
    },
    setHeightAreaInfomation : function(){
        var $infomationArea = $(".information-detail");
        var $titleInfomation = $(".information-title");
        var heightAreaInfo = $infomationArea.height();
        $infomationArea.animate({"height" : "15px"});
        $infomationArea.css("opacity", 1);
        $titleInfomation.on("click", function(){
            if($infomationArea.hasClass("opened")){
                $infomationArea.finish().removeClass("opened").animate({"height" : "15px"});
            }else{
                $infomationArea.finish().addClass("opened").animate({"height" : heightAreaInfo + "px"});
            }
        });
    },
    // removeLoadingSystem : function(){
    //     window.addEventListener('DOMContentLoaded', function(){
    //         $(".wrapper").addClass("ready");
    //         setTimeout(function(){
    //             var hiddenPromise = $(".loading-system").animate({'opacity' : 0}, 300);
    //             hiddenPromise.promise().done(function(){
    //                 $(".loading-system").addClass("hide");
    //             });
    //         }, 1000);
    //     });
    // },
    copyRefLink : function(){
        this.copyInForm('inputRefLink');
    },
    copyInForm : function(idInput){
        var $input = $("#" + idInput);
        var $buttonCopy = $input.next();
        if($buttonCopy.hasClass("copied")){
            return;
        }
        $input.removeAttr("disabled").select();
        document.execCommand("copy");
        $input[0].setSelectionRange(0, 0)
        $input.prop("disabled", true);
        $buttonCopy.addClass('copied').text("Copied!");
        setTimeout(function(){
            $buttonCopy.removeClass('copied').text("Copy");
        }, 2000)
    },
    setArrowValue : function(idInput, type){
        var $input = $("#" + idInput);
        var dataArrow = JSON.parse($input.attr('data-arrow'));
        var inputVal = $input.val();
        if(this.isFloat(inputVal)){
            inputVal = parseFloat(inputVal);
        }else{
            inputVal = parseInt(inputVal);
        }
        if(type == 'up'){
            inputVal += dataArrow.step;
        }
        if(type == 'down'){
            inputVal -= dataArrow.step;
        }
        if(inputVal < dataArrow.min){
            inputVal = dataArrow.min;
        }
        if(inputVal > dataArrow.max){
            inputVal = dataArrow.max;
        }
        if(this.isFloat(inputVal)){
            var toFix = typeof dataArrow.toFix != 'undefined' ? dataArrow.toFix : 1;
            inputVal = inputVal.toFixed(toFix);
        }
        $input.val(inputVal);
    },
    isFloat : function(number){
        return !isNaN(number) && number.toString().indexOf('.') != -1;
    },
    showModalChangeIB : function(el, username, tree){
        var $modal = $("#changeIBModal");
        $modal.find("form").trigger('reset');
        $modal.find('[name="username"]').val(username);
        $modal.find('[name="tree"]').val(JSON.stringify(tree));
        $modal.find('.content-header h3').text("Change IB - " + username);
        $modal.modal("show");
        this.tableDetail = $(el).closest(".table-detail");
    },
    changeIB : function(el){
        var $form = $(el).closest('form');
        var formData = new FormData($form[0]);
        var url = $form.attr('action');
        var self = this;
        Request.ajax(url, formData, function(result){
            alert(result.message);
            if(!result.success){
                return;
            }
            if(self.tableDetail == null){
                return;
            }
            var $modal = $("#changeIBModal");
            $modal.find("form").trigger('reset');
            $modal.modal("hide");
            self.tableDetail.html(result.data.html);
        });
    },
    getListUser : function(el){
        window.event && window.event.preventDefault();
        var size = $(".search-form [name='size']").val();
        var href = $(el).attr('data-href') + "?size=" + size;
        this.getListUserRequest(href);
    },
    getListUserRequest : function(href){
        Request.ajax(href, function(result){
            if(!result.success){
                return alert(result.message);
            }
            $("#table-user-list").html(result.data.html);
            $("#table-user-tree-parent").html(result.data.tree_parent);
        })
    },
    showUserInfo : function(el){
        window.event && window.event.preventDefault();
        var href = $(el).attr("href");
        Request.ajax(href, function(result){
            if(result.success === false){
                return alert(result.message);
            }

            var $memberOvl = $("#memberDetail");
            var datas = result.datas;
            var aryKey = Object.keys(datas);

            for (var k in aryKey){
                var key = aryKey[k];
                var data = result.datas[key];
                $memberOvl.find(".info-" + key).val(data);
            }
            $memberOvl.modal("show");
        });
    },
    changePersonalInfo : function(el){
        var $form = $(el).closest("form");
        var href = $form.attr("action");
        var formData = new FormData($form[0]);
        Request.ajax(href, formData, function(result){
            alert(result.message);
        })
    }
}

Home.init();

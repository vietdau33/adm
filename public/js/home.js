const Home = {
    tableDetail : null,
    init : function(){
        this.calcHeightContent();
        this.setHeightAreaInfomation();
        $(window).on('resize', this.calcHeightContent.bind(this));
    },
    calcHeightContent : function(){
        const heightHeader = this.getFirstContextJqueryElement($("#header-content"), 'offsetHeight');
        const footerHeader = this.getFirstContextJqueryElement($("#footer-content"), 'offsetHeight');
        const height       = "calc(100vh - " + (heightHeader + footerHeader) + "px)";
        $("#main-content").css({
            height      : height,
            minHeight   : height,
            maxHeight   : height
        });
    },
    getFirstContextJqueryElement: function(payload, context = null) {
        if(payload.length <= 0) {
            return null;
        }
        return context == null ? payload[0] : payload[0][context];
    },
    setHeightAreaInfomation : function(){
        const $infomationArea = $(".information-detail");
        const $titleInfomation = $(".information-title");
        const heightAreaInfo = $infomationArea.height();
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
    copyRefLink : function(){
        this.copyInForm('inputRefLink');
    },
    copyInForm : function(idInput){
        const $input = $("#" + idInput);
        const $buttonCopy = $input.next();
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
    copyReflinkWithButton: function(btn) {
        const $buttonCopy = $(btn);
        const text = $buttonCopy.attr('data-text');
        Home.copyTextRaw(text, function(){
            $buttonCopy.addClass('copied').text("Copied!");
            clearTimeout(window.timeoutCopied);
            window.timeoutCopied = setTimeout(function(){
                $buttonCopy.removeClass('copied').text("Copy");
            }, 2000)
        });
    },
    copyTextRaw: function (text, callback) {
        if(typeof text == 'object' && text instanceof HTMLElement) {
            text = text.getAttribute('data-text') || 'No See text to copy!';
        }
        const textArea = document.createElement("textarea");
        textArea.value = text;
        textArea.style.top = "0";
        textArea.style.left = "0";
        textArea.style.position = "fixed";

        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();

        try {
            document.execCommand('copy');
            if(typeof callback == 'function') {
                callback();
            }
        } catch (err) {
            alert("Copy text error!");
        }
        document.body.removeChild(textArea);
    },
    showModalChangeIB : function(el, username, tree){
        const $modal = $("#changeIBModal");
        $modal.find("form").trigger('reset');
        $modal.find('[name="username"]').val(username);
        $modal.find('[name="tree"]').val(JSON.stringify(tree));
        $modal.find('.content-header h3').text("Change IB - " + username);
        $modal.modal("show");
        this.tableDetail = $(el).closest(".table-detail");
    },
    changeIB : function(el){
        const $form = $(el).closest('form');
        const formData = new FormData($form[0]);
        const url = $form.attr('action');
        const self = this;
        Request.ajax(url, formData, function(result){
            alert(result.message);
            if(!result.success){
                return;
            }
            if(self.tableDetail == null){
                return;
            }
            const $modal = $("#changeIBModal");
            $modal.find("form").trigger('reset');
            $modal.modal("hide");
            self.tableDetail.html(result.data.html);
        });
    },
    getListUser : function(el){
        window.event && window.event.preventDefault();
        const size = $(".search-form [name='size']").val();
        const href = $(el).attr('data-href') + "?size=" + size;
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
        const href = $(el).attr("href");
        Request.ajax(href, function(result){
            if(result.success === false){
                return alert(result.message);
            }

            const $memberOvl = $("#memberDetail");
            const datas = result.datas;
            const aryKey = Object.keys(datas);

            for (const k in aryKey){
                const key = aryKey[k];
                const data = result.datas[key];
                $memberOvl.find(".info-" + key).val(data);
            }
            $memberOvl.modal("show");
        });
    },
    changePersonalInfo : function(el){
        const $form = $(el).closest("form");
        const href = $form.attr("action");
        const formData = new FormData($form[0]);
        Request.ajax(href, formData, function(result){
            alert(result.message);
        })
    }
}

Home.init();

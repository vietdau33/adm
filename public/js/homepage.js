const Homepage = {
    init : function(){
        this.bindEventClickBarMenu();
        this.bindEventClickCloseIcon();
        if($("#popup-top").length > 0){
            this.bindEventClosePopupTop();
            this.setImagePopuptop();
            setTimeout(this.showPopupTop, 1000);
        }
    },
    bindEventClickBarMenu : function(){
        $(".icon-menu-header img").on("click", function(){
            $(".menu-header").addClass("open");
            $(".bg-menu-header").removeClass("d-none");
        });
    },
    bindEventClickCloseIcon : function(){
        $(".close-icon img").on("click", function(){
            $(".menu-header").removeClass("open");
            $(".bg-menu-header").addClass("d-none");
        });
    },
    bindEventClosePopupTop : function(){
        var self = this;
        $("#popup-top .box-close").on("click", self.hidePopupTop);
    },
    showPopupTop : function(){
        $("#popup-top").fadeIn(10, function(){
            $("#popup-top .area-popup-top").fadeIn(300);
        })
    },
    hidePopupTop : function(){
        $("#popup-top .area-popup-top").fadeOut(300, function(){
            $("#popup-top").fadeOut(10);
        });
        setTimeout(Homepage.showPopupTop, timeReopenPopup);
    },
    setImagePopuptop : function(){
        var isSp = window.innerWidth <= 991;
        var $img = $("#popup-top .box-image img");
        var srcSp = $img.attr("data-src-sp");
        var srcPc = $img.attr("data-src-pc");
        $img.attr("src", isSp ? srcSp : srcPc);
    }
}
Homepage.init();

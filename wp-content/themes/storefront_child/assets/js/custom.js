/*! scooch 1.0.1 2016-05-16 */
!function(a){if("function"==typeof define&&define.amd)define(["$"],a);else{var b=window.Mobify&&window.Mobify.$||window.jQuery||window.Zepto;a(b)}}(function(a){var b=function(a){var b={},c=navigator.userAgent,d=a.support=a.support||{};a.extend(a.support,{touch:"ontouchend"in document}),b.events=d.touch?{down:"touchstart",move:"touchmove",up:"touchend"}:{down:"mousedown",move:"mousemove",up:"mouseup"},b.getCursorPosition=d.touch?function(a){return a=a.originalEvent||a,{x:a.touches[0].clientX,y:a.touches[0].clientY}}:function(a){return{x:a.clientX,y:a.clientY}},b.getProperty=function(a){for(var b=["Webkit","Moz","O","ms",""],c=document.createElement("div").style,d=0;d<b.length;++d)if(void 0!==c[b[d]+a])return b[d]+a},a.extend(d,{transform:!!b.getProperty("Transform"),transform3d:!(!(window.WebKitCSSMatrix&&"m11"in new window.WebKitCSSMatrix)||/android\s+[1-2]/i.test(c))});var e=b.getProperty("Transform");b.translateX=d.transform3d?function(a,b){"number"==typeof b&&(b+="px"),a.style[e]="translate3d("+b+",0,0)"}:d.transform?function(a,b){"number"==typeof b&&(b+="px"),a.style[e]="translate("+b+",0)"}:function(a,b){"number"==typeof b&&(b+="px"),a.style.left=b};var f=(b.getProperty("Transition"),b.getProperty("TransitionDuration"));return b.setTransitions=function(a,b){a.style[f]=b?"":"0s"},b.onTransitionEnd=function(b,c){b.one("transitionend webkitTransitionEnd otransitionend MSTransitionEnd",function(d){var e=a(d.target);0===e.not(b).length&&c(d)})},b.requestAnimationFrame=function(){var a=window.requestAnimationFrame||window.webkitRequestAnimationFrame||window.mozRequestAnimationFrame||window.oRequestAnimationFrame||window.msRequestAnimationFrame||function(a){window.setTimeout(a,1e3/60)},b=function(){a.apply(window,arguments)};return b}(),b}(a),c=function(a,b){var c={dragRadius:10,moveRadius:20,animate:!0,autoHideArrows:!1,rightToLeft:!1,infinite:!1,autoplay:!1,classPrefix:"m-",classNames:{outer:"scooch",inner:"scooch-inner",item:"item",center:"center",touch:"has-touch",dragging:"dragging",active:"active",inactive:"inactive",fluid:"fluid"}},d=a.support,e=function(a,b){this.setOptions(b),this.initElements(a),this.options.infinite&&this.initLoop(),"object"==typeof this.options.autoplay&&this.initAutoplay(),this.initStartElement(),this.initOffsets(),this.initAnimation(),this.bind(),this.start(),this._updateCallbacks=[]};return e.defaults=c,e.prototype.setOptions=function(b){var d=this.options||a.extend({},c,b);d.classNames=a.extend({},d.classNames,b.classNames||{}),this.options=d},e.prototype.initElements=function(b){this._index=1,this.element=b,this.$element=a(b),this.$inner=this.$element.find("."+this._getClass("inner")),this.$items=this.$inner.children(),this._length=this.$items.length,this._alignment=this.$element.hasClass(this._getClass("center"))?.5:0,this._isFluid=this.$element.hasClass(this._getClass("fluid")),this._lockLeft=1,this._lockRight=this._length},e.prototype.initStartElement=function(){this.$start=this.$inner.children().first(),this.$current=this.$items.eq(this._index-1)},e.prototype.initLoop=function(){this._loopPrepend=2,this._loopAppend=2;for(var a=0;a<this._loopPrepend;a++){var b=this.$items.eq(this._length-1-a).clone();this.$inner.prepend(b)}for(var a=0;a<this._loopAppend;a++){var b=this.$items.eq(a).clone();this.$inner.append(b)}this._lockLeft=this._lockLeft-1,this._lockRight=this._lockRight+1;var c=this;this.$element.on("afterSlide",function(){var a=c._index;if(c._index<1)a=c._length;else{if(!(c._index>c._length))return;a=1}c._index=a,c.initStartElement(),c.start()})},e.prototype.initAutoplay=function(){var a=this,b=function(){var b=a._index%a._length+1;a.move(b)};if(this.options.autoplay.interval&&"number"==typeof this.options.autoplay.interval&&this.options.autoplay.interval>1){var c=a.options.autoHideArrows;a.options.autoHideArrows=!1,a.timer=window.setInterval(b,this.options.autoplay.interval),"boolean"==typeof this.options.autoplay.cancelOnInteraction&&this.options.autoplay.cancelOnInteraction?this.$element.on("touchstart click mouseover",function(){window.clearInterval(a.timer),a.options.autoHideArrows=c,c&&a.hideArrows(a._index)}):a.initLoop()}},e.prototype.initOffsets=function(){this._offsetDrag=0},e.prototype.initAnimation=function(){this.animating=!1,this.dragging=!1,this._needsUpdate=!1,this._enableAnimation()},e.prototype._getClass=function(a){return this.options.classPrefix+this.options.classNames[a]},e.prototype._enableAnimation=function(){this.animating||(b.setTransitions(this.$inner[0],!0),this.$inner.removeClass(this._getClass("dragging")),this.animating=!0)},e.prototype._disableAnimation=function(){this.animating&&(b.setTransitions(this.$inner[0],!1),this.$inner.addClass(this._getClass("dragging")),this.animating=!1)},e.prototype.start=function(){this._disableAnimation(),this.$element.trigger("beforeSlide",[this._index,this._index]),this.$element.trigger("afterSlide",[this._index,this._index]),this.update()},e.prototype.refresh=function(){this.$items=this.$inner.children("."+this._getClass("item")),this._length=this.$items.length,this._lockRight=this.$items.length,this.start()},e.prototype.update=function(a){if("undefined"!=typeof a&&this._updateCallbacks.push(a),!this._needsUpdate){this._needsUpdate=!0;var c=this;b.requestAnimationFrame(function(){c._update(),setTimeout(function(){for(var a=0,b=c._updateCallbacks.length;b>a;a++)c._updateCallbacks[a].call(c);c._updateCallbacks=[]},10)})}},e.prototype._update=function(){if(this._needsUpdate){var a=this.$current,c=this.$start,d=a.prop("offsetLeft")+a.prop("clientWidth")*this._alignment,e=c.prop("offsetLeft")+c.prop("clientWidth")*this._alignment,f=Math.round(-(d-e)+this._offsetDrag);a.prop("offsetParent")&&b.translateX(this.$inner[0],f),this._needsUpdate=!1}},e.prototype.hideArrows=function(a){this.$element.find("[data-m-slide=prev]").removeClass(this._getClass("inactive")),this.$element.find("[data-m-slide=next]").removeClass(this._getClass("inactive")),1===a&&this.$element.find("[data-m-slide=prev]").addClass(this._getClass("inactive")),a===this._length&&this.$element.find("[data-m-slide=next]").addClass(this._getClass("inactive"))},e.prototype.bind=function(){var c,e,f,g,h=Math.abs,i=!1,j=!1,k=this.options.dragRadius,l=this,m=this.$element,n=this.$inner,o=this.options,p=!1,q=!1,r=a(window).width(),s=function(a){d.touch||a.preventDefault(),i=!0,j=!1,c=b.getCursorPosition(a),e=0,f=0,g=!1,l._disableAnimation(),p=l._index===l._lockLeft,q=l._index===l._lockRight},t=function(a){if(i&&!j){var d=b.getCursorPosition(a),m=l.$element.width();e=c.x-d.x,f=c.y-d.y,g||h(e)>h(f)&&h(e)>k?(g=!0,a.preventDefault(),p&&0>e?e=e*-m/(e-m):q&&e>0&&(e=e*m/(e+m)),l._offsetDrag=-e,l.update()):h(f)>h(e)&&h(f)>k&&(j=!0)}},u=function(){i&&(i=!1,l._enableAnimation(),!j&&h(e)>o.moveRadius?o.rightToLeft?0>e?l.next():l.prev():e>0?l.next():l.prev():(l._offsetDrag=0,l.update()))},v=function(a){g&&a.preventDefault()};n.on(b.events.down+".scooch",s).on(b.events.move+".scooch",t).on(b.events.up+".scooch",u).on("click.scooch",v).on("mouseout.scooch",u),m.on("click","[data-m-slide]",function(b){b.preventDefault();var c=a(this).attr("data-m-slide"),d=parseInt(c,10);isNaN(d)?l[c]():l.move(d)}),m.on("afterSlide",function(a,b,c){l.$items.eq(b-1).removeClass(l._getClass("active")),l.$items.eq(c-1).addClass(l._getClass("active")),l.$element.find("[data-m-slide='"+b+"']").removeClass(l._getClass("active")),l.$element.find("[data-m-slide='"+c+"']").addClass(l._getClass("active")),o.autoHideArrows&&l.hideArrows(c)}),a(window).on("resize orientationchange",function(){r!==a(window).width()&&(l._disableAnimation(),r=a(window).width(),l.update())}),m.trigger("beforeSlide",[1,1]),m.trigger("afterSlide",[1,1])},e.prototype.unbind=function(){this.$inner.off()},e.prototype.destroy=function(){this.unbind(),this.$element.trigger("destroy"),this.$element.remove(),this.$element=null,this.$inner=null,this.$start=null,this.$current=null},e.prototype.move=function(c,d){var e=this.$element,f=this.$inner,g=this.$items,h=(this.$start,this.$current),i=(this._length,this._index);d=a.extend({},this.options,d),c<this._lockLeft?c=this._lockLeft:c>this._lockRight&&(c=this._lockRight),d.animate?this._enableAnimation():this._disableAnimation(),e.trigger("beforeSlide",[i,c]),this.$current=h=d.infinite?f.children().eq(c+this._loopPrepend-1):g.eq(c-1),this._offsetDrag=0,this._index=c,d.animate?this.update():this.update(function(){this._enableAnimation()}),d.animate?b.onTransitionEnd(this.$inner,function(){e.trigger("afterSlide",[i,c])}):e.trigger("afterSlide",[i,c])},e.prototype.next=function(){this.move(this._index+1)},e.prototype.prev=function(){this.move(this._index-1)},e}(a,b);a.fn.scooch=function(b,d){var e=a.extend({},a.fn.scooch.defaults);return"object"==typeof b&&(a.extend(e,b,!0),d=null,b=null),d=Array.prototype.slice.apply(arguments),this.each(function(){var f=(a(this),this._scooch);f||(f=new c(this,e)),b&&(f[b].apply(f,d.slice(1)),"destroy"===b&&(f=null)),this._scooch=f}),this},a.fn.scooch.defaults={}});

var init = {
	onReady: function() {
        init.frmBtn();
        init.scooch();
	},
    wholesaleSubmit: function() {
		var Frm = jQuery('#wholesalefrm');
        jQuery.ajax({
            url: ajax.ajaxurl,
            type: Frm.attr('method'),
            data: {
            	firstName: jQuery('input[name="firstName"]').val(),
                lastName: jQuery('input[name="lastName"]').val(),
            	phone: jQuery('input[name="phone"]').val(),
            	emailaddress: jQuery('input[name="emailaddress"]').val(),
                company: jQuery('input[name="company"]').val(),
                address: jQuery('input[name="address"]').val(),
                address2: jQuery('input[name="address2"]').val(),
                city: jQuery('input[name="city"]').val(),
                state: jQuery('#state option:selected').val(),
                zip: jQuery('input[name="zip"]').val(),
                service: jQuery('#service option:selected').val(),
                qty: jQuery('input[name="qty"]').val(),
                action: 'sendWholesale'
            },
            dataType: 'html',
            beforeSend() {
                jQuery('#wholesalefrm button').html('<i class="fa fa-spinner fa-spin"></i>');
            },
            success(data) {
                fbq('track', 'Lead',{
                    content_name: 'wholesale'
                });
            	init.frmResponse(data);
            },
            error(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                console.log(err.Message);
            }
        });
        return false;
	},
    influenceSubmit: function() {
        var Frm = jQuery('#influencefrm');
        jQuery('#influencefrm button').html('<i class="fa fa-spinner fa-spin"></i>');
        jQuery.ajax({
            url: ajax.ajaxurl,
            type: Frm.attr('method'),
            data: {
                handle: jQuery('input[name="handle"]').val(),
                emailaddress: jQuery('input[name="emailaddress"]').val(),
                address: jQuery('input[name="address"]').val(),
                address2: jQuery('input[name="address2"]').val(),
                city: jQuery('input[name="city"]').val(),
                state: jQuery('option:selected').val(),
                zip: jQuery('input[name="zip"]').val(),
                action: 'sendInfluence'
            },
            dataType: 'html',
            success: function(data) {
                fbq('track', 'Lead',{
                    content_name: 'influencer'
                });
                init.frmResponse(data);
            }
        });
        return false;
    },
	frmResponse: function(response) {
        jQuery('form button i').remove();
        if (response === "Success") {
        	jQuery('form button').replaceWith('<button class="success"><i class="fa fa-check"></i></button>');
            jQuery("input").val("");
            setTimeout(
            	function() {
            		jQuery('form button').replaceWith('<button>Submit</button>');
            	}, 2500
        	);
        }
        if (response === "E") {
         	jQuery('form button').replaceWith('<button class="error"><i class="fa fa-ban"></i></button>');
         	setTimeout(
            	function() {
            		jQuery('form button').replaceWith('<button>Submit</button>');
            	}, 2500
        	);
        }
	},
	frmBtn: function() {
		jQuery('#wholesalefrm').submit(init.wholesaleSubmit);
        jQuery('#influencefrm').submit(init.influenceSubmit);
	},
    scooch: function() {
        jQuery('.m-scooch').scooch(); 
    }
};

jQuery(document).ready(function() {
	init.onReady();
});
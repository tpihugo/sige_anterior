require('./bootstrap');

require('alpinejs');

this.thumbPreview=function(){xOffset=10,yOffset=30,$("a.thumb").hover(function(t){this.t=this.title,this.title="";var e=""!=this.t?"<br>"+this.t:"";$("body").append("<p id='thumb'><img width='300x' src='"+this.href+"' alt='' />"+e+"</p>"),$("#thumb").css("top",t.pageY-xOffset+"px").css("left",t.pageX+yOffset+"px").fadeIn("fast")},function(){this.title=this.t,$("#thumb").remove()}),$("a.thumb").mousemove(function(t){$("#thumb").css("top",t.pageY-xOffset+"px").css("left",t.pageX+yOffset+"px")})},$(document).ready(function(){thumbPreview()});

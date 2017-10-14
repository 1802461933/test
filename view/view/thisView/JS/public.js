var header = document.getElementById("header");
var sid = document.getElementById("sidebar");
var sidButton = document.getElementById("sidButton");
var butimg = sidButton.firstElementChild;
var nav = document.getElementById('nav');
var content = document.getElementById("content");
sid.style.marginTop = header.offsetHeight;
sidButton.style.marginTop = header.offsetHeight+"px";			

butimg.onclick = function(){
var sidWidth = sid.offsetWidth;
	if(sidWidth==0){
		sid.style.width = 187+"px";
		this.src="../../../img/user/index/bar_close.gif";
		nav.style.display="block";
		content.style.width="85%";
	}else{
			nav.style.display="none";
			sid.style.width = 0 + "px"; 
			this.src = "../../../img/user/index/bar_right.gif";
			content.style.width="99%";
	}
}



function callStatus(btn){
	if(btn.innerText == "空闲"){
		btn.style.backgroundColor="#FF5722";
		btn.innerText="示忙";
	}else{
		btn.style.backgroundColor="#009688";
		btn.innerText="空闲";
	}
	
}



function autodivheight(){ //函数：获取尺寸
    //获取浏览器窗口高度
    var winHeight=0;
    if (window.innerHeight){
        winHeight = window.innerHeight;
    }
    else if ((document.body) && (document.body.clientHeight)){
        winHeight = document.body.clientHeight;
    }
    if (document.documentElement && document.documentElement.clientHeight){
        winHeight = document.documentElement.clientHeight;
    }
    document.getElementById("sidebar").style.height= winHeight-70+"px";
    sidButton.style.marginTop=winHeight/2.6+"px";
    document.getElementById("content").style.height= winHeight-70 +"px";
}
autodivheight();

$(".layui-nav-item").on('click',function(){
	$(this).siblings().removeClass('layui-nav-itemed');
});
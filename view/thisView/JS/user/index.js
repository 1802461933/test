var footer = document.getElementById("footer");
var header = document.getElementById("header");
var sid = document.getElementById("sidebar");
var sidButton = document.getElementById("sidButton");
var butimg = sidButton.firstElementChild;
var nav = document.getElementById('nav');
var content = document.getElementById("content");
console.log(content.offsetLeft);
sid.style.marginTop = header.offsetHeight;
sidButton.style.marginTop = header.offsetHeight+"px";			
butimg.onclick = function(){
var sidWidth = sid.offsetWidth;

/*动态布局*/
	if(sidWidth==0){
		sid.style.width = 187+"px";
		this.src="../../img/index/bar_close.gif";
		nav.style.display="block";
		content.style.width="85%";
	}else{
			nav.style.display="none";
			sid.style.width = 0 + "px"; 
			this.src = "../../img/index/bar_right.gif";
			content.style.width="99%";
		}
	}

/*示忙状态替换*/
function callStatus(btn){
	if(btn.innerText == "空闲"){
		btn.style.backgroundColor="#FF5722";
		btn.innerText="示忙";
	}else{
		btn.style.backgroundColor="#009688";
		btn.innerText="空闲";
	}
	
}

/*显示隐藏高级搜索*/
function hiddenFromSenior(){
	var fromSeniorHeight = document.getElementById("fromSenior").offsetHeight;
	if( fromSeniorHeight == 0){
		document.getElementById("fromSenior").style.height = 140 + "px";
		document.getElementById("fromSenior").style.display = "block";
	}else{
		document.getElementById("fromSenior").style.height = 0 + "px";
		document.getElementById("fromSenior").style.display = "none";
	}
	
}

function tiemday(btn){
	layui.laydate({elem: btn,format:'YYYY-MM-DD hh:mm:ss',istoday: false});
	btn.value=laydate.now(-30, 'YYYY-MM-DD hh:mm:ss');
	
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
    document.getElementById("sidebar").style.height= winHeight-65+"px";
    sidButton.style.marginTop=winHeight/2.6+"px";
    document.getElementById("content").style.height= winHeight-70 +"px";
}
autodivheight();

$(".layui-nav-item").on('click',function(){
	$(this).siblings().removeClass('layui-nav-itemed');
});



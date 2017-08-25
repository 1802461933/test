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


function userDataModify(){
	$(".userdata span").attr("contenteditable","true");
	$("[name=quiz1]").removeAttr("disabled");
	$(".Preservation>button").css('display',"block");
}

function Preservation(btn){
	$(".userdata span").attr("contenteditable","false");
	$("[name=quiz1]").attr("disabled","disabled");
	$(btn).css('display','none');
}
function addUserPhone(){
	var str = '<div class="cleth">';
		str += '<p class="phone">';
		str += '<span contenteditable="true">电话/姓名</span>';
		str += '<span contenteditable="true">所属省/所属市</span>';
		str += '</p>';
		str += '<p class="phoneBtn">';
		str += '<button class="layui-btn layui-btn-primary layui-btn-small" onclick="delPhone(this)">删除</button>';
		str += '<button class="layui-btn layui-btn-primary layui-btn-small" onclick="prvnPhone(this)">保存</button>';
		str += '<button class="layui-btn layui-btn-primary layui-btn-small" onclick="editPhone(this)">修改</button>';
		str += '</p>';
		str += '</div>';
	$('.userPhone').append(str);
}

function delPhone(btn){
  $(btn).parent().parent('div').remove();
}

function prvnPhone(btn){
	$(btn).parent().prev().children('span').attr('contenteditable','false');
}

function editPhone(btn){
	$(btn).parent().prev().children('span').attr('contenteditable','true');
}

function address(){
	var str = '<div class="addressDiv" >';
		str += '<p class="addressP" contenteditable="true">';
		str += '请输入用户地址';						
		str += '</p>';
		str += '<p class="addressBtn">';					
		str += '<button class="layui-btn layui-btn-primary layui-btn-small" onclick="delAddress(this)">删除</button>';						
		str += '<button class="layui-btn layui-btn-primary layui-btn-small" onclick="prvnAddress(this)">保存</button>';
		str += '<button class="layui-btn layui-btn-primary layui-btn-small" onclick="editAddress(this)">修改</button>';
		str += '</p>';						
		str += '</div>';
	$('.addressTd').append(str);
}

function delAddress(btn){
	$(btn).parent().parent('div').remove();
}

function prvnAddress(btn){
	$(btn).parent().prev().attr('contenteditable','false');
}

function editAddress(btn){
	$(btn).parent().prev().attr('contenteditable','true');
}

function deltable(btn){
	$(btn).parent().remove();
}

function addTables(){
	$('.mask').css({'display':"block"});
}

function tablePreservation(){
	$('.mask').css({'display':"none"});
	
}

function delTable(btn){
	$(btn).parent().remove();
}

function addTable(btn){
	var content = $(btn).prev().text();
	var className = $(btn).prev().attr('class');
	var str = '<li>';
		str += '<span class="'+className+'">'+content+'</span>';
		str += '<button class="layui-btn layui-btn-primary layui-btn-mini" onclick="delTable(this)">删除</button>';
		str += '</li>';
	$('#addTabUl').append(str);
}

function selctDisplay(str){
	if(str=="动态"){
		$("#select").css('display','block');
		$(".selectRight").css("height","auto");
	}else{
		$("#select").css("display","none");
		$(".selectRight").css("height","21px");
	}
}

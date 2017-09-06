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
/*动态布局*/
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

$(".pay_list_c1").on("click",function(){
$(this).addClass("on").siblings().removeClass("on");
})
function addHtmlPhone(){
	i++;
	var str = '<div class="layui-form-item">';
		str += '<div class="layui-inline">';
		str += '<label class="layui-form-label">联系方式</label>';
		str += '<div class="layui-input-inline">';
		str += '<input type="tel" name="phone" lay-verify="phone" autocomplete="off" class="layui-input">';
		str += '</div>';
		str += '</div>';
		str += '<div class="layui-input-item">';
//		str += '<form name="forms'+i+'">';
		str += '<label class="layui-form-label addmargin" style="padding-left: 0;">号码归属</label>';
		str += '<div class="addAscription">';
		str += '<select name="selectsheng'+i+'" onChange='+'"selectcityarea('+"'selectsheng"+i+"',"+"'selectcity"+i+"',"+"'forms');\""+">;";
		str += '<option>选择省</option>';
		str += '</select>';
		str += '<select name="selectcity'+i+'">';
		str += '<option>选择市</option>';
		str += '</select>';
		str += "</div>";
//		str += "<form/>";
		str += "</div>";
		str += "</div>";
	$('#form').append(str);
	first("selectsheng"+i,"selectcity"+i,"forms",0,0);
}

function addHtmlress(){
	var str = '<div class="layui-form-item layui-form-text">';
		str += '<div class="layui-input-block ressText">';
		str += '<textarea placeholder="请输入地址" class="layui-textarea"></textarea>';
		str += '</div>';
		str += '</div>';
	$('.addressHtml').append(str);	
}

$('.tdHover').on('mouseover',function(){
	$(this).css('background-color','#FFFFFF');
})

function delTable(btn){
	$(btn).parent('li').remove();
}
function addTable(btn){
	var content = $(btn).parent('li').children('span').text();
	var className = $(btn).parent('li').children('span').attr('class');
	var str = '<li>'
		str += '<span class="'+className+'">'+content+'</span>';
		str += '<button class="layui-btn layui-btn-primary layui-btn-mini" onclick="delTable(this)">删除</button>';
		str += '</li>';
	$(".defaultUl").append(str);
}
function closeAddUser(){
	$(".mask").css('display','none');
	$("#adduser").css('display','none');
}

function adduser(){
	$(".mask").css('display','block');
	$("#adduser").css('display','block');
}

function deluser(id){
	var result = confirm("确定删除用户？");
	if(id==undefined){
	if(result){
		var obj=document.getElementsByName('checkbox');
		var str = "";
		for(var i=0; i<obj.length; i++){ 
			if(obj[i].checked) 
			{
				str += obj[i].value+','
				};
		}
	}
	}else{
		alert(id);
	}
}

function cancelTransfer(){
	$(".mask").css('display','none');
	$(".transfer").css('display','none');
}

function transferBlock(id){
	$(".mask").css('display','block');
	$(".transfer").css('display','block');
	if(id!=undefined){
		transfer(id);
	}
}

function transfer(id){
	var transferId = $("#transferId").val();
	if(id==undefined){
	var obj=document.getElementsByName('checkbox');
		var str = "";
		for(var i=0; i<obj.length; i++){ 
			if(obj[i].checked) 
			{
				str += obj[i].value+','
				};
		}
	alert(str);	
	}else{
//		alert(id);
	}
	
}

function exports(){
	var result = confirm("确定导出这些用户？");
	if(result){
		var obj=document.getElementsByName('checkbox');
		var str = "";
		for(var i=0; i<obj.length; i++){ 
			if(obj[i].checked) 
			{
				str += obj[i].value+','
				};
		}
	}
}

function moreUlH(btn){
	var wth = $('#moreUl').height();
	if(wth<60){	
	$('#moreUl').height("120px");
	$(btn).addClass("bgmarrowTop");
	}else{
		$('#moreUl').height("40px");
	$(btn).removeClass("bgmarrowTop");
	}
}

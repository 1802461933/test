var footer = document.getElementById("footer");
var header = document.getElementById("header");
var sid = document.getElementById("sidebar");
var sidButton = document.getElementById("sidButton");
var heigth = footer.offsetTop - header.offsetHeight ;
var butimg = sidButton.firstElementChild;
var nav = document.getElementById('nav');
var content = document.getElementById("content");
butimg.style.marginTop = heigth / 2.2 + "px";
sid.style.height = heigth+ "px";
sidButton.style.height = heigth+ "px";
content.style.height = heigth + "px";
console.log(content.offsetLeft);
sid.style.marginTop = header.offsetHeight;
sidButton.style.marginTop = header.offsetHeight+"px";			
butimg.onclick = function(){
var sidWidth = sid.offsetWidth;
	if(sidWidth==0){
		sid.style.width = 187+"px";
		this.src="../../img/index/bar_close.gif";
		nav.style.display="block";
		content.style.width="86.5%";
	}else{
			nav.style.display="none";
			sid.style.width = 0 + "px"; 
			this.src = "../../img/index/bar_right.gif";
			content.style.width="99.5%";
		}
	}
function callStatus(btn){
	if(btn.innerText == "空闲"){
		btn.style.backgroundColor="#FF5722";
		btn.innerText="示忙";
	}else{
		btn.style.backgroundColor="#1E9FFF";
		btn.innerText="空闲";
	}
	
}

function hiddenFromSenior(){
	var fromSeniorHeight = document.getElementById("fromSenior").offsetHeight;
	if( fromSeniorHeight == 0){
		document.getElementById("fromSenior").style.height = 200 + "px";
	}else{
		document.getElementById("fromSenior").style.height = 0 + "px";
	}
	
}

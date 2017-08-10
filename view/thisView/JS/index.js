var footer = document.getElementById("footer");
var header = document.getElementById("header");
var sid = document.getElementById("sidebar");
var sidButton = document.getElementById("sidButton");
var heigth = footer.offsetTop - header.offsetHeight ;
var butimg = sidButton.firstElementChild;
butimg.style.marginTop = heigth / 2.2 + "px";
sid.style.height = heigth+ "px";
sidButton.style.height = heigth+ "px";
sid.style.marginTop = header.offsetHeight;
sidButton.style.marginTop = header.offsetHeight+"px";			
butimg.onclick = function(){
var sidWidth = sid.offsetWidth;
	if(sidWidth==0){
		sid.style.width = 187+"px";
		this.src="../../img/index/bar_close.gif";
	}else{
		sid.style.width = 0 + "px"; 
			this.src = "../../img/index/bar_right.gif";
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

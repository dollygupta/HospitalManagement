

function goTohomepage(){
	var pwd=document.getElementById('pwd').value;
	var email=document.getElementById('email').value;
	var user_type=document.getElementById('user_type').value;
	
	sendAjaxData(pwd,email,user_type);
}


function sendAjaxData(pwd,email,user_type){
	
	var xttp = new XMLHttpRequest();
	xttp.open("GET", "homepage.php?pwd="+pwd+"&email="+email+"&user_type="+user_type, true);
	xttp.onreadystatechange = function() { 
	if (xttp.readyState == XMLHttpRequest.DONE && xttp.status == 200) {
	var result=xttp.responseText.trim();
	alert(result);
	if(result == "wrong"){
		document.getElementById("error").innerHTML="wrong credential entered!";

		}
	else{
		window.location="http://localhost/HospitalManagement/"+result+".php?";
		}
	}
	}
	xttp.send();
}


function err(text){
	document.querySelector("#err").innerHTML = text;
	document.querySelector("#wlcm").style.marginTop = "20vh";
}

function validate(){
	let nick = document.querySelector("#inp").value;
	let pwd = document.querySelector("#pwd").value;
	if (nick.trim() !== '' && pwd.trim() !== ''){
		let data = {
			login: nick,
			pwd: pwd
		};
		ajax("reg", data, (ndata)=>{
			if (ndata.access === true) {
				localStorage.clear();
				localStorage.setItem("login", ndata.login);
				location.href = "view.html";
			}
			else {
				let text = ndata.access + " for user " + nick + "<br>" + ndata.login;
				err(text.toString());
				return false;
			}
		});
		return true;
	} else {
		err("Enter a valid data");
		return false;
	}
}
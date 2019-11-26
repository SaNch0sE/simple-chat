function connect() {
	let login = document.getElementById('inp').value;
	let pwd = document.getElementById('pwd').value;
	let data = {
		login: login,
		password: pwd
	};
	ajax("adminVal", data, (data)=>{
		if (data.resp !== "error" && data.resp === true) {
			document.getElementById('input').innerHTML = '';
			db = '<button onclick="showUsers()">Show users</button><button onclick="showMessages()">Show messages</button><table id="vdb"></table>';
			document.getElementById('db').innerHTML = db;
		} else {
			document.getElementById('db').innerHTML = '<h3 style="color: red;"> Access Denied<br> resp: ' + data.resp + '</h3>';
		}
	});
}
//
function showUsers() {
	ajax("showUsers", null, (data)=>{
		let vdb = document.getElementById('vdb');
		vdb.innerHTML = '';
		if (data !== "No users") {
            for(let i=0; i < data.length; i++){
            	let parent = document.createElement("tr");
            	parent.innerHTML = '<td>' + data[i].id + '</td>'+'<td>' + data[i].user + '</td>'+'<td>' + data[i].password + '</td>';
				vdb.append(parent);
            }
		} else if(data === "No users") {
			let parent = document.createElement("tr");
			parent.innerHTML = '<td>' + data + '</td>';
			vdb.append(parent);
		} else {
			parent.innerHTML = 'Error :(';
		}
	});
}
//
function showMessages() {
	ajax("getMessages", null, (data)=>{
		let vdb = document.getElementById('vdb');
		vdb.innerHTML = '';
		if (data !== "No messages") {
            for(let i=0; i < data.length; i++){
            	let parent = document.createElement("tr");
            	parent.innerHTML = '<td>' + i + '</td>'+'<td>' + data[i].date + '</td>'+'<td>' + data[i].nick + '</td>'+'<td>' + data[i].message + '</td>';
				vdb.append(parent);
            }
		} else if (data === "No messages"){
			let parent = document.createElement("tr");
			parent.innerHTML = '<td>' + data + '</td>';
			vdb.append(parent);
		} else {
			parent.innerHTML = 'Error :(';
		}
	});
}
//
function createdb() {
	if (prompt("Enter 'y', if you sure", "n") === "y"){
		ajax("createdb", null, (data)=>{
			let inp = document.getElementById('input');
			inp.innerHTML = '<h1 style="color: red;">' + JSON.stringify(data) + '</h1>';
			setTimeout(()=>{location.href = "admin.html"},3000);
		});
	}
}

let oldObj = 0;
let error;
let x;
let timer = 2000;

function clean() {
    document.querySelector("#messages").innerHTML = "";
}

function send() {
        let nick = localStorage.getItem("login");
        let msg = document.querySelector("#msg").value;
        //clean garbage spaces and new lines
        // msg = msg.replace(/\s\s+/g, ' ');
        // msg = msg.replace(/\n\s*\n/g, '\n');
        // msg = msg.replace(/\"/g, '\\"');
        // //removing html tags
        // msg = msg.replace('<','\\"');
        // msg = msg.replace('>','\\"');
        //validating data
    if (msg === '' || msg === ' ') {
        alert("Please Fill Message Field");
        console.log("!sent");
    } else {
        //generate and send request
        let json = {
            nick: nick,
            msg: msg
        };
        //ajax(method, action, data, callback)
        ajax("sendMessage", json, (response)=>{
            if (response.resp !== '') {
                console.log(response.resp);
            }
            document.querySelector("#msg").value = "";
        });
    }
}

function sendOnCtrlEnter(event) {
    if(event.ctrlKey === true && event.charCode === 10) {
        event.preventDefault();
        send();
        document.querySelector("#msg").value = "";
    }
}

function getData() {
    ajax("getMessages", null, (data)=>{
        let parent = document.querySelector("#messages");
        if(data !== "Error") {
            if(JSON.stringify(oldObj) !== JSON.stringify(data) && data !== 'No messages'){
                clean();
                oldObj = data;
                console.log("get");
                for(let i=0; i < data.length; i++){
                    let li = document.createElement("li");
                    li.innerHTML = "[" + data[i].date + "]<br>" + data[i].nick +": "+ data[i].message;
                    parent.append(li);
                }
                parent.scrollTop = parent.scrollHeight;
            }
            else if (data === 'No messages') {
                parent.innerHTML = data;
            }
        } else if (data === "Error") {
            error = data;
        } else {
            let li = document.createElement("li");
            li.innerHTML = data;
            parent.append(li);
        }
    });
    if (error !== "Error") {
        x = setTimeout(getData, timer);
    }
    else {
        x = setTimeout(getData, timer + 8000);
    }
}

function load() {
    getData();
}
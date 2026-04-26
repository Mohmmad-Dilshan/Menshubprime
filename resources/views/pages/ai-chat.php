<?php include ROOT_PATH . '/includes/header.php'; ?>

<style>
.chat-wrap{
max-width:900px;
margin:60px auto;
background:#0f172a;
border-radius:16px;
padding:20px;
color:white;
box-shadow:0 10px 30px rgba(0,0,0,.5);
}

.chat-box{
height:400px;
overflow-y:auto;
background:#020617;
padding:15px;
border-radius:12px;
margin-bottom:15px;
}

.msg{
margin:10px 0;
padding:10px 14px;
border-radius:12px;
max-width:70%;
}

.user{background:#2563eb;margin-left:auto;}
.bot{background:#16a34a;}

input{
width:80%;
padding:12px;
border:none;
border-radius:10px;
background:#020617;
color:white;
}

button{
padding:12px 18px;
border:none;
border-radius:10px;
background:#f97316;
color:white;
cursor:pointer;
}
</style>

<div class="chat-wrap">
<h2>🤖 AI Assistant</h2>

<div class="chat-box" id="chatBox"></div>

<input type="text" id="userMsg" placeholder="Ask me anything..." autocomplete="off">
<button onclick="sendMsg()">Send</button>
</div>

<script>
function sendMsg(){
let msg = document.getElementById("userMsg").value;
if(msg=="") return;

let chatBox = document.getElementById("chatBox");
chatBox.innerHTML += <div class="msg user">${msg}</div>;

fetch("ai-chat-api.php",{
method:"POST",
headers:{'Content-Type':'application/x-www-form-urlencoded'},
body:"message="+encodeURIComponent(msg)
})
.then(res=>res.text())
.then(data=>{
chatBox.innerHTML += <div class="msg bot">${data}</div>;
chatBox.scrollTop = chatBox.scrollHeight;
});

document.getElementById("userMsg").value="";
}
</script>

<?php include ROOT_PATH . '/includes/footer.php'; ?>
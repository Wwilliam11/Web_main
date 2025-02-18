<head>
    <style>
        body{
            margin:0;
            padding:0;
            background:#000;
        }
        #messages{
            position: fixed;
            left:0;
            top:0;
            width:100%;
            height:calc( 100% - 50px );
            background:#000;
            overflow-y:auto;
            padding:10px;
            box-sizing: border-box;
        }
        #sendMsg{
            position: fixed;
            left:0;
            bottom:0;
            width: 100%;
            height:50px;
            background:#AAA;
        }
        #msgTxt{
            position: absolute;
            left:0;
            top:0;
            width:calc(100% - 100px);
            height:100%;
            padding-left:10px;
            box-sizing: border-box;
        }
        #msgBtn{
            position: absolute;
            right:0;
            top:0;
            width: 100px;
            height:100%;
        }
        .outer{
            width:100%;
            margin-top:10px;
            display:flex;
        }
        #inner{
            padding:10px;
            box-sizing: border-box;
            border-radius:10px;
        }
        .me{
            background:#8800FF;
            color:#fff;
        }
        .notMe{
            background:#FFF;
            color:#000;
        }
    </style>
</head>

<body>
    <div id="messages"></div>

    <div id="sendMsg">
        <input type="text" id="msgTxt" placeholder="ENTER YOUR MSG...">
        <input type="submit" id="msgBtn" value="send" onclick="module.sendMsg()">
    </div>

    <script>
        module = {};
    </script>
    <script type="module">
      import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.4/firebase-app.js";
      import { getDatabase, ref, set, remove, onChildAdded, onChildRemoved } from "https://www.gstatic.com/firebasejs/10.12.4/firebase-database.js";

        const firebaseConfig = {
          apiKey: "AIzaSyCGcOPtpXetQ9qGnSkUFI1tq-gcCfo4HjI",
          authDomain: "chat-57ed8.firebaseapp.com",
          projectId: "chat-57ed8",
          storageBucket: "chat-57ed8.appspot.com",
          messagingSenderId: "86686235448",
          appId: "1:86686235448:web:3f611446a987f135815fcd"
        };

        const app = initializeApp(firebaseConfig);
        const db = getDatabase(app);

        // variables
        var msgTxt = document.getElementById('msgTxt');
        var sender;
        if(sessionStorage.getItem('sender')){
            sender = sessionStorage.getItem('sender');
        } else {
            sender = prompt('PLEASE ENTER YOUR NAME');
            sessionStorage.setItem('sender',sender);
        }

        // TO SEND MESSAGES
        module.sendMsg = function sendMsg(){
            var msg = msgTxt.value;
            var timestamp = new Date().getTime();
            set(ref(db,"messages/"+timestamp),{
                msg : msg,
                sender : sender
            })

            msgTxt.value="";
        }

        // TO RECEIVE MSG
        onChildAdded(ref(db,"messages"), (data)=>{
            if(data.val().sender == sender){
                messages.innerHTML += "<div style=justify-content:end class=outer id="+data.key+"><div id=inner class=me>you : "+data.val().msg+"<button id=dltMsg onclick=module.dltMsg("+data.key+")>DELETE</button></div></div>";
            } else {
                messages.innerHTML += "<div class=outer id="+data.key+"><div id=inner class=notMe>"+data.val().sender+" : "+data.val().msg+"</div></div>";
            }
        })

        // TO DELETE MSG
        module.dltMsg = function dltMsg(key){
            remove(ref(db,"messages/"+key));
        }

        // WHEN MSG IS DELETED
        onChildRemoved(ref(db,"messages"),(data)=>{
            var msgBox = document.getElementById(data.key);
            messages.removeChild(msgBox);
        })
    </script>
</body>

</html>
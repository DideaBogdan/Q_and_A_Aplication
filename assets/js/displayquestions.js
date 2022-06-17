mainPannel = document.getElementById('main-pannel');
//questionForm = document.createElement('div');//.setAttribute('id', 'question-form');
//questionTitle = document.createElement('h3').setAttribute('id', 'question-title');
//username = document.createElement('p');//.setAttribute('id', 'username');
//text = document.createElement('div');//.setAttribute('id', 'question-box');

let permData;
let url = 'http://localhost/Q_and_A_Aplication/api/post/displayquestions.php';
let header = new Headers();
header.append('Content-type', 'application/json');
let request = new Request( url, {
    headers: header,
    method: 'GET',
});
fetch(request)
    .then((response) => response.json())
    .then((data)=>{
        console.log('Response from server');
        //let variable = JSON.parse(data);
        permData = data;
        displayquestions(data);
    })
.catch(console.warn);


function displayquestions(json){
    data = json;
    console.log(permData);
    data.forEach(element => {
        

        questionForm = document.createElement('div');
        questionTitle = document.createElement('h3');
        username = document.createElement('p');
        text = document.createElement('a');
        
        questionIDhidden = document.createElement('input');
        questionIDhidden.setAttribute('type', 'hidden');
        questionIDhidden.setAttribute('id', 'questionIDhidden');
        questionIDhidden.setAttribute('value', element.id);
        questionForm.appendChild(questionIDhidden);

        if(element.username == null){
            const user = document.createTextNode( "Anonymous asks:");
            username.appendChild(user);
        } else {
            const user = document.createTextNode(element.username + " asks:");
            username.appendChild(user);
        }
        const node = document.createTextNode(element.text);
        text.classList.add("questionText");
        text.addEventListener('click', redirect);
        text.appendChild(node);
        questionTitle.appendChild(username);


        // pentru afisarea acum cat timp a fost pusa o intrebare sau cand s-a raspuns
        timestamp = document.createElement('p');
        const date = new Date(element.updated_at);
        const currentSeconds = new Date().getTime() / 1000;
        const questionSeconds = Math.floor(date.getTime() / 1000);
        const currTime= Math.floor(currentSeconds-questionSeconds);
        
        if(currTime < 60){
            timestamp.innerText = Math.floor(currTime) + " seconds ago";
        }
        else if(currTime/60 < 60) {
            if(Math.floor(currTime/60) == 1){
                timestamp.innerText = Math.floor(currTime/60) + " minute ago";
            } else{
                timestamp.innerText = Math.floor(currTime/60) + " minutes ago";
            }
        }
        else if(currTime/(60*60) < 24) {
            if(Math.floor(currTime/(60*60)) == 1){
                timestamp.innerText = Math.floor(currTime/(60*60)) + " hour ago";
            } else{
                timestamp.innerText = Math.floor(currTime/(60*60)) + " hours ago";
            }
        }
        else if(currTime/((60*60*24)) < 31){
            if(Math.floor(currTime/60*60*24) == 1){
                timestamp.innerText = Math.floor(currTime/(60*60*24)) + " day ago";
            } else {
                timestamp.innerText = Math.floor(currTime/(60*60*24)) + " days ago";
            }
        }
        else if(currTime/(60*60*24*30) < 12){
            if(Math.floor(currTime/(60*60*24*30)) == 1){
                timestamp.innerText = Math.floor(currTime/(60*60*24*30)) + "month ago";
            } else {
                timestamp.innerText = Math.floor(currTime/(60*60*24*30)) + "months ago";
            }
        }
        else{
            if(Math.floor(currTime/(60*60*24*365)) == 1){
                timestamp.innerText = Math.floor(currTime/(60*60*24*365)) + " year ago";
            } else {
                timestamp.innerText = Math.floor(currTime/(60*60*24*365)) + " years ago";
            }
            
        }



        questionForm.appendChild(questionTitle);
        questionForm.appendChild(timestamp);
        questionForm.appendChild(text);

        divBtns = document.createElement('div');
        likeButton = document.createElement('button');
        dislikeButton = document.createElement('button');

        divBtns.addEventListener('click', giveReaction);
       // likeButton.addEventListener('click', giveLike);
       // dislikeButton.addEventListener('click', giveDislike);

        likeButton.innerText = "Like";
        dislikeButton.innerText = "Dislike";
        
        likeButton.setAttribute('class', 'likeButton');
        dislikeButton.setAttribute('class', 'dislikeButton');

        divBtns.appendChild(likeButton);
        divBtns.appendChild(dislikeButton);

        questionForm.appendChild(divBtns);
       
        questionForm.setAttribute('id', 'question-form');
        text.setAttribute('id', 'question-box');
        username.setAttribute('id', 'username');
        mainPannel.appendChild(questionForm);

        ///aici ar trebui un questionForm.appendChild() pentru butoanele de sub intrebare - like/dislike eventual - !!!important - butonul de raspunsuri
        /// butonul de raspunsuri va fi generat din script (de aici) si va afisa raspunsurile + un field de tip input pentru a raspunde si utilizatorul 
    });
}

function redirect(e){
    e.preventDefault();
    let id = -1;
    permData.forEach(element => {
        console.log(element.text);
        if(e.currentTarget.innerText == element.text)
            id = element.id;
            
    });
    console.log(id);
    location.assign("http://localhost/Q_and_A_Aplication/detailed.php?id=" + id);
    console.log(e.currentTarget.innerText);
}


function showPopup(){
    popUp = document.getElementById('popUp');
    popUp.style.display = "block";

    container = document.getElementById('containerpopup');
    container.style.display = "block";


    container.addEventListener('click', function(e){
        if(e.target === container) {
            popUp.style.display = "none";
            container.style.display = "none";
        }
    })

    closeBtn = document.getElementById('close');
    closeBtn.addEventListener('click', function(e){
        popUp.style.display = "none";
        container.style.display = "none";
    })
}

function giveReaction(e){
    
    if(e.target.firstChild == 'Like'){
        giveLike(e);
    }
    else{
        giveDislike(e);
    }

}

function giveLike(e){
    e.preventDefault();
    isLogged = document.getElementById('session_var').value;
    let question = e.target.parentNode.parentNode;
    let questionId = question.querySelector('#questionIDhidden').value;
    if(isLogged == ""){
        showPopup();
    }
    if(e.target.classList.contains('reacted')){
        let data = {
                user : isLogged,
                id_post : parseInt(questionId)
                };
        const json = JSON.stringify(data);

        let urlReact = 'http://localhost/Q_and_A_Aplication/api/post/deletereaction.php';
        let requestReact = new Request( urlReact, {
            headers: header,
            body: json,
            method: 'POST',
        });
        
        fetch(requestReact)
            .then((response) => response.json())
            .then((data)=>{
                console.log('Response from server');
                if(data.message === 'Reaction deleted'){
                    e.target.classList.remove('reacted');
                }
            })
        .catch(console.warn);
    
    }
    else {
        let data = {like : "1",
                dislike : "0",
                user : isLogged,
                id_post : parseInt(questionId)
                };
        const json = JSON.stringify(data);

        let urlReact = 'http://localhost/Q_and_A_Aplication/api/post/createreaction.php';
        let requestReact = new Request( urlReact, {
            headers: header,
            body: json,
            method: 'POST',
        });
        
        fetch(requestReact)
            .then((response) => response.json())
            .then((data)=>{
                console.log('Response from server');
                if(data.message === 'Reaction created'){
                    e.target.classList.add('reacted');
                }
            })
        .catch(console.warn);
    
        }
}

function giveDislike(e){
    e.preventDefault();
    isLogged = document.getElementById('session_var').value;
    let question = e.target.parentNode.parentNode;
    let questionId = question.querySelector('#questionIDhidden').value;
    if(isLogged == ""){
        showPopup();
    }
    if(e.target.classList.contains('reacted')){
        let data = {
                user : isLogged,
                id_post : parseInt(questionId)
                };
        const json = JSON.stringify(data);

        let urlReact = 'http://localhost/Q_and_A_Aplication/api/post/deletereaction.php';
        let requestReact = new Request( urlReact, {
            headers: header,
            body: json,
            method: 'POST',
        });
        
        fetch(requestReact)
            .then((response) => response.json())
            .then((data)=>{
                console.log('Response from server');
                if(data.message === 'Reaction deleted'){
                    e.target.classList.remove('reacted');
                }
            })
        .catch(console.warn);
    
    }
    else {
        let data = {like : "0",
                dislike : "1",
                user : isLogged,
                id_post : parseInt(questionId)
                };
        const json = JSON.stringify(data);

        let urlReact = 'http://localhost/Q_and_A_Aplication/api/post/createreaction.php';
        let requestReact = new Request( urlReact, {
            headers: header,
            body: json,
            method: 'POST',
        });
        
        fetch(requestReact)
            .then((response) => response.json())
            .then((data)=>{
                console.log('Response from server');
                if(data.message === 'Reaction created'){
                    e.target.classList.add('reacted');
                }
            })
        .catch(console.warn);
    
        }
}

function likepost(user, questionId){
    let data = {like : "1",
                dislike : "0",
                user : user,
                id_post : parseInt(questionId)
                };
    const json = JSON.stringify(data);

    let urlReact = 'http://localhost/Q_and_A_Aplication/api/post/createreaction.php';
    let requestReact = new Request( urlReact, {
        headers: header,
        body: json,
        method: 'POST',
    });
    
    fetch(requestReact)
        .then((response) => response.json())
        .then((data)=>{
            console.log('Response from server');
            if(data.message === 'Reaction created'){
                console.log(1);

            }
        })
    .catch(console.warn);
    
}



function dislikepost(user, questionId){
    let data = {like : "1",
                dislike : "0",
                user : user,
                id_post : parseInt(questionId)
    };
    const json = JSON.stringify(data);
    let urlReact = 'http://localhost/Q_and_A_Aplication/api/post/createreaction.php';
    let requestReact = new Request( urlReact, {
    headers: header,
    body: json,
    method: 'POST',
    });

    fetch(requestReact)
        .then((response) => response.json())
        .then((data)=>{
            console.log('Response from server');
            console.log(data);
    })
    .catch(console.warn);

}
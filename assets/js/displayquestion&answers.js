mainPannel = document.getElementById('main-pannel');
let permData;

questionId = document.getElementById('question_id').value;
let obj = {id : parseInt(questionId)};
const json = JSON.stringify(obj);
let userInput = document.getElementById('user_answer');

let user_username;
if(userInput != null){
    user_username = userInput.value;
}
 
let url = 'http://localhost/Q_and_A_Aplication/api/post/displayquestion&answers.php';

let header = new Headers();
header.append('Content-type', 'application/json');
header.append('Accept', 'application/json');
let request = new Request( url, {
    headers: header,
    body: json,
    method: 'POST',
});

fetch(request)
    .then((response) => response.json())
    .then((data)=>{
        console.log('Response from server');
        //let variable = JSON.parse(data);
       // permData = data;
        displayquestion_answers(data);
    })
.catch(console.warn);


function get_time(element){
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
    return timestamp;

}


function displayquestion_answers(json){
    data = json;
    console.log(data);
    data.slice(0,1).forEach(element => {
            questionForm = document.createElement('div');
            questionTitle = document.createElement('h3');
            username = document.createElement('p');

            questionIDhidden = document.createElement('input');
            questionIDhidden.setAttribute('type', 'hidden');
            questionIDhidden.setAttribute('id', 'questionIDhidden');
            questionIDhidden.setAttribute('value', element.id);
            questionForm.appendChild(questionIDhidden);

            text = document.createElement('a');

            if(element.username == null){
                const user = document.createTextNode( "Anonymous asks:");
                username.appendChild(user);
            } else {
                const user = document.createTextNode(element.username + " asks:");
                username.appendChild(user);
            }
            const node = document.createTextNode(element.text);
            text.appendChild(node);
            questionTitle.appendChild(username);

            
            likeButton = document.createElement('button');
            dislikeButton = document.createElement('button');

            likeButton.innerText = "Like";
            dislikeButton.innerText = "Dislike";
            
            likeButton.setAttribute('id', 'likeButton');
            dislikeButton.setAttribute('id', 'dislikeButton');

            likeButton.addEventListener('click', giveLike);
            dislikeButton.addEventListener('click', giveDislike);

   
            questionForm.appendChild(questionTitle);
            questionForm.appendChild(get_time(element));
            questionForm.appendChild(text);
            questionForm.appendChild(likeButton);
            questionForm.appendChild(dislikeButton);

        
            questionForm.setAttribute('id', 'question-form');
            text.setAttribute('id', 'question-box');
            username.setAttribute('id', 'username');
            mainPannel.appendChild(questionForm);
        });

    answerForm = document.createElement('form');
    answerForm.addEventListener('submit', createanswer);;
    answerForm.setAttribute('name', 'formanswer');
    answerForm.setAttribute('id', 'formanswer');

    answerInput = document.createElement('textarea');
    answerInput.setAttribute('type', 'text');
    answerInput.setAttribute('placeholder', 'Type your answer here...');
    answerInput.setAttribute('name', 'answer');
    answerInput.setAttribute('id', 'answer');
    answerInput.setAttribute("style", "height: fit-content");
    answerInput.addEventListener("input", OnInput, false);

    answerButton = document.createElement('button');
    answerButton.appendChild(document.createTextNode('Submit answer'));
    answerButton.setAttribute('id', 'answerbutton');

    answerForm.appendChild(answerInput);
    answerForm.appendChild(answerButton);
    mainPannel.appendChild(answerForm);

    
    data.slice(1).forEach(element => {
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
            const user = document.createTextNode( "Anonymous responds:");
            username.appendChild(user);
        } else {
            const user = document.createTextNode(element.username + " responds:");
            username.appendChild(user);
        }
        const node = document.createTextNode(element.text);
        text.appendChild(node);
        questionTitle.appendChild(username);

        questionForm.appendChild(questionTitle);
        questionForm.appendChild(get_time(element));
        questionForm.appendChild(text);

        likeButton = document.createElement('button');
        dislikeButton = document.createElement('button');
        likeButton.addEventListener('click', giveLike);
        dislikeButton.addEventListener('click', giveDislike);

        likeButton.innerText = "Like";
        dislikeButton.innerText = "Dislike";
        
        likeButton.setAttribute('class', 'likeButton');
        dislikeButton.setAttribute('class', 'dislikeButton');

        questionForm.appendChild(likeButton);
        questionForm.appendChild(dislikeButton);
    
        questionForm.setAttribute('id', 'containeranswer');
        text.setAttribute('id', 'answer');
        username.setAttribute('id', 'username');
        mainPannel.appendChild(questionForm);

    });

        ///aici ar trebui un questionForm.appendChild() pentru butoanele de sub intrebare - like/dislike eventual - !!!important - butonul de raspunsuri
        /// butonul de raspunsuri va fi generat din script (de aici) si va afisa raspunsurile + un field de tip input pentru a raspunde si utilizatorul 
        

        ///kind reminder to change the selects from the databse and to use both classes in php : Answer and Question - important for the order by
}


async function createanswer(e) {
    e.preventDefault();

    let myAnswer = e.target;
    let formData = new FormData(myAnswer);

    let json = await convertToJSON(formData); 
    console.log(json);
    
    let url = 'http://localhost/Q_and_A_Aplication/api/post/createanswer.php';
    let header = new Headers();
    header.append('Content-type', 'application/json');
    let request = new Request( url, {
        headers: header,
        body: json,
        method: 'POST',
    });
    fetch(request)
        .then((response) => response.json(), console.log("face asta"))
        .then((data)=>{
            console.log('Response from server');
            console.log(data);
        })
    .catch(console.warn);

    window.location.reload();
    
}


function convertToJSON(formData){
    let obj={};
    for(let key of formData.keys()){
        obj[key]=formData.get(key);
    }
    obj['question'] = parseInt(questionId);
    if(user_username === ""){
        obj['username'] = "";
        return JSON.stringify(obj);
    } else{
        obj['username'] = user_username;
        return JSON.stringify(obj);
    }
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



function OnInput() {
  this.style.height = "auto";
  this.style.height = (this.scrollHeight) + "px";
}


function giveLike(e){
    e.preventDefault();
    if(document.getElementById('session_var').value == ""){
        showPopup();
    }
    else {
        console.log("you can like");
        likepost();
    }
}

function giveDislike(e){
    e.preventDefault();

    if(document.getElementById('session_var').value == ""){
        showPopup();
    }
    else {
        console.log("you can dislike");
        dislikepost();
    }

}

function likepost(){
    console.log("merge");
}



function dislikepost(){
    console.log("merge");
}
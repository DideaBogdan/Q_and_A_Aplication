mainPannel = document.getElementById('main-pannel');
let permData;

isAdmin = document.getElementById('session_admin').value;

questionId = document.getElementById('question_id').value;
let obj = {id : parseInt(questionId)};
const json = JSON.stringify(obj);
let userInput = document.getElementById('user_answer');

isLogged = document.getElementById('session_var').value;
isLogged_ID = document.getElementById('session_var_id').value;

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


async function displayquestion_answers(json){
    content = json;
    console.log(content);

    let urlget = 'http://localhost/Q_and_A_Aplication/api/post/getreactions.php';
    
    let request = new Request( urlget, {
        headers: header,
        method: 'GET',
    });
    await fetch(request)
        .then((response) => response.json())
        .then((data)=>{
            console.log('Response from server');
            response = data;
            console.log(response);
        })
    .catch(console.warn);


    content.slice(0,1).forEach(element => {
            questionForm = document.createElement('div');
            questionTitle = document.createElement('h3');
            username = document.createElement('a');
            category = document.createElement('p');
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
            text.appendChild(node);
           
            username.setAttribute("style", "float : left; margin : 10px; text-decoration: none;");
            if(element.username!= null){
            username.setAttribute("href", "http://localhost/Q_and_A_Aplication/profile.php?username=" + element.username);
            }

            questionTitle.setAttribute("style", "margin : -10px")
            questionTitle.appendChild(username);

            category.setAttribute("style", "display : inline-block");
            category.innerText = " in " + element.category;
           
            category.setAttribute("style", "float : right; margin : 10px;");
            questionTitle.appendChild(category);   
            
            divBtns = document.createElement('div');
            likeButton = document.createElement('button');
            dislikeButton = document.createElement('button');
            reportButton = document.createElement('button');

            likeButton.innerText = "Like " ;
            dislikeButton.innerText = "Dislike ";
            
            likeButton.setAttribute('class', 'likeButton');
            dislikeButton.setAttribute('class', 'dislikeButton');
            reportButton.setAttribute('class', 'reportButton');

            spanLike = document.createElement('span');
            spanDislike = document.createElement('span');
            spanLike.setAttribute('class', 'likespan');
            spanDislike.setAttribute('class', 'dislikespan');
    
            let likeint = 0;
            let dislikeint = 0;
            let reportint = 0;
    
            response.forEach(entry=>{
                if(entry.id_post === element.id && Number(entry.is_question) === 1)
                {
                    if(entry.like === 1){
                        likeint= likeint+1;
                        if(Number(entry.user) === Number(isLogged_ID) ){
                            likeButton.classList.add('reacted');
                        } 
                    }
                    else if(entry.dislike === 1){
                        dislikeint++;
                        if(Number(entry.user) === Number(isLogged_ID) ){
                            dislikeButton.classList.add('reacted');
                        } 
                    }
                    else if(entry.report === 1){
                        reportint++;
                        if(Number(entry.user) === Number(isLogged_ID) ){
                            reportButton.classList.add('reacted');
                        }
                    }
            }
            });
            spanLike.innerText = likeint;
            spanDislike.innerText = dislikeint;
    
            likeButton.appendChild(spanLike);
            dislikeButton.appendChild(spanDislike);
        
            divBtns.addEventListener('click', giveReaction);
            
            divBtns.appendChild(likeButton);  
            divBtns.appendChild(dislikeButton);

            if(isAdmin === "0" || isAdmin === ""){
                reportButton.setAttribute('style', 'display: none;');
               
            }
                reportButton.innerText = "Report";
                
    
                spanReport = document.createElement('span');
                spanReport.innerText = reportint;
    
                reportButton.appendChild(spanReport);
                
                divBtns.appendChild(reportButton);
        
            questionForm.appendChild(get_time(element));
            questionForm.appendChild(questionTitle);
            questionForm.appendChild(text); 
            questionForm.appendChild(divBtns);

        
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
    answerInput.setAttribute("required" ,"true");
    answerInput.addEventListener("input", OnInput, false);

    answerButton = document.createElement('button');
    answerButton.appendChild(document.createTextNode('Submit answer'));
    answerButton.setAttribute('id', 'answerbutton');

    answerForm.appendChild(answerInput);
    answerForm.appendChild(answerButton);
    mainPannel.appendChild(answerForm);

    
    content.slice(1).forEach(element => {
        questionForm = document.createElement('div');
        questionTitle = document.createElement('h3');
        username = document.createElement('a');
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
        
        username.setAttribute("style", "float : left; margin : 10px; text-decoration: none;");
        if(element.username!= null){
        username.setAttribute("href", "http://localhost/Q_and_A_Aplication/profile.php?username=" + element.username);
        }
        text.appendChild(node);
        questionTitle.appendChild(username);


        divBtns = document.createElement('div');
        likeButton = document.createElement('button');
        dislikeButton = document.createElement('button');
        reportButton = document.createElement('button');

        likeButton.innerText = "Like " ;
        dislikeButton.innerText = "Dislike ";
        
        likeButton.setAttribute('class', 'likeButton');
        dislikeButton.setAttribute('class', 'dislikeButton');
        reportButton.setAttribute('class', 'reportButton');


        spanLike = document.createElement('span');
        spanDislike = document.createElement('span');
        spanLike.setAttribute('class', 'likespan');
        spanDislike.setAttribute('class', 'dislikespan');

        let likeint = 0;
        let dislikeint = 0;
        let reportint = 0;

        response.forEach(entry=>{
            if(entry.id_post === element.id && Number(entry.is_question) === 0)
            {
                if(entry.like === 1){
                    likeint= likeint+1;
                    if(Number(entry.user) === Number(isLogged_ID) ){
                        likeButton.classList.add('reacted');
                    } 
                }
                else if(entry.dislike === 1){
                    dislikeint++;
                    if(Number(entry.user) === Number(isLogged_ID) ){
                        dislikeButton.classList.add('reacted');
                    } 
                }
                else if(entry.report === 1){
                    reportint++;
                    if(Number(entry.user) === Number(isLogged_ID) ){
                        reportButton.classList.add('reacted');
                    }
                }
            }
        });
        spanLike.innerText = likeint;
        spanDislike.innerText = dislikeint;

        likeButton.appendChild(spanLike);
        dislikeButton.appendChild(spanDislike);
    
        divBtns.addEventListener('click', giveReaction);
        
        divBtns.appendChild(likeButton);  
        divBtns.appendChild(dislikeButton);

        if(isAdmin === "0" || isAdmin === ""){
            reportButton.setAttribute('style', 'display: none;');
           
        }
            reportButton.innerText = "Report";
            

            spanReport = document.createElement('span');
            spanReport.innerText = reportint;

            reportButton.appendChild(spanReport);
            
            divBtns.appendChild(reportButton);
        
        questionForm.appendChild(get_time(element));
        questionForm.appendChild(questionTitle);
        
        questionForm.appendChild(text); 
        questionForm.appendChild(divBtns);

    
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

function showPopup2(text){
    popUp = document.getElementById('popUp');
    popUp.style.display = "block";

    container = document.getElementById('containerpopup');
    container.style.display = "block";

    contentText = document.getElementById('content');
    contentText.innerText = text;

    buttonss = document.getElementsByClassName('buttons');

    let i;
    for (i = 0; i < buttonss.length; i++) {
        buttonss[i].style.display = 'none';
    }

    
    closeBtn = document.getElementById('close');
    closeBtn.addEventListener('click', function(e){
        popUp.style.display = "none";
        container.style.display = "none";
        window.location.reload();
    })
}


function OnInput() {
  this.style.height = "auto";
  this.style.height = (this.scrollHeight) + "px";
}


function giveReaction(e){
    btnDiv = e.target.parentNode;
     if(e.target.classList.contains('likeButton')){
        if(e.target.parentNode.parentNode.id === "question-form"){
            giveLike(e);
        } else {
            giveLikeAnswer(e);
        }
    }
    else if(e.target.classList.contains('dislikeButton')){
        if(e.target.parentNode.parentNode.id === "question-form"){
            giveDislike(e);
        } else {
            giveDislikeAnswer(e);
        }
    }
    else if(e.target.classList.contains('reportButton')){
        if(e.target.parentNode.parentNode.id === "question-form"){
            giveReport(e);
        } else {
            giveReportAnswer(e);
        }
    }

}

async function giveLike(e){
    e.preventDefault();
    let question = e.target.parentNode.parentNode;
    let questionId = question.querySelector('#questionIDhidden').value;

    let spanLikeBtn = e.target.lastChild;
    let spanDislikeBtn = question.lastChild.lastChild.previousSibling.lastChild;
    console.log(spanLikeBtn);
    console.log(spanDislikeBtn);
    if(isLogged == ""){
        showPopup();
    }
    else {
        if(e.target.parentNode.lastChild.previousSibling.classList.contains('reacted')){
            console.log("intra aici in undislike then like");
            let data = {
                user : isLogged,
                like : parseInt("0"),
                dislike : parseInt("1"),
                report : parseInt("0"),
                id_post : parseInt(questionId),
                is_question : parseInt("1"),
                    };
            let json = JSON.stringify(data);

            let urlReact = 'http://localhost/Q_and_A_Aplication/api/post/deletereaction.php';
            let requestReact = new Request( urlReact, {
                headers: header,
                body: json,
                method: 'POST',
            });
            
            await fetch(requestReact)
                .then((response) => response.json())
                .then((data)=>{
                    console.log('Response from server');
                    if(data.message === 'Reaction deleted'){
                        e.target.parentNode.lastChild.previousSibling.classList.remove('reacted');
                        let numb = Number(spanDislikeBtn.innerText);
                        numb = numb-1;
                        spanDislikeBtn.innerText = numb;
                    }
            })
            .catch(console.warn);

            
            let data2 = {like : parseInt("1"),
                        dislike : parseInt("0"),
                        report : parseInt("0"),
                        user : isLogged,
                        id_post : parseInt(questionId),
                        is_question : parseInt("1"),
                        };
            let json2 = JSON.stringify(data2);
            console.log(json2);

            let urlReact2 = 'http://localhost/Q_and_A_Aplication/api/post/createreaction.php';
            let requestReact2 = new Request( urlReact2, {
                headers: header,
                body: json2,
                method: 'POST',
            });

            await fetch(requestReact2)
                .then((response) => response.json())
                .then((data)=>{
                    console.log('Response from server');
                    if(data.message === 'Reaction created'){
                        e.target.classList.add('reacted');
                        let numb = Number(spanLikeBtn.innerText);
                        numb = numb+1;
                        spanLikeBtn.innerText = numb;
                    }
            })
            .catch(console.warn);
            }
        else {
                if(e.target.classList.contains('reacted')){
                    console.log("intra aici");
                    let data = {
                        user : isLogged,
                        like : parseInt("1"),
                        dislike : parseInt("0"),
                        report : parseInt("0"),
                        id_post : parseInt(questionId),
                        is_question : parseInt("1"),
                            };
                    let json = JSON.stringify(data);

                    let urlReact = 'http://localhost/Q_and_A_Aplication/api/post/deletereaction.php';
                    let requestReact = new Request( urlReact, {
                        headers: header,
                        body: json,
                        method: 'POST',
                    });
                    
                    await fetch(requestReact)
                        .then((response) => response.json())
                        .then((data)=>{
                            console.log('Response from server');
                            if(data.message === 'Reaction deleted'){
                                e.target.classList.remove('reacted');
                                let numb = Number(spanLikeBtn.innerText);
                                numb = numb-1;
                                spanLikeBtn.innerText = numb;
                            }
                        })
                    .catch(console.warn);
                }
                else { 
                    console.log("intra aici-la baza");
                    let data = {like : parseInt("1"),
                                dislike : parseInt("0"),
                                report : parseInt("0"),
                                user : isLogged,
                                id_post : parseInt(questionId),
                                is_question : parseInt("1"),
                                };
                    let json = JSON.stringify(data);
                    console.log(json);

                    let urlReact = 'http://localhost/Q_and_A_Aplication/api/post/createreaction.php';
                    let requestReact = new Request( urlReact, {
                        headers: header,
                        body: json,
                        method: 'POST',
                    });

                    await fetch(requestReact)
                        .then((response) => response.json())
                        .then((data)=>{
                            console.log('Response from server');
                            if(data.message === 'Reaction created'){
                                e.target.classList.add('reacted');
                                let numb = Number(spanLikeBtn.innerText);
                                numb = numb+1;
                                spanLikeBtn.innerText = numb;
                            }
                        })
                    .catch(console.warn);
                }
            }
    }
}

async function giveDislike(e){
    e.preventDefault();
    isLogged = document.getElementById('session_var').value;
    let question = e.target.parentNode.parentNode;
    let questionId = question.querySelector('#questionIDhidden').value;

    let spanLikeBtn = e.target.previousSibling.lastChild;
    let spanDislikeBtn =  e.target.lastChild;
    console.log(spanLikeBtn);
    console.log(spanDislikeBtn);
    if(isLogged == ""){
        showPopup();
    }  else {
        if(e.target.parentNode.firstChild.classList.contains('reacted')){
            console.log("intra aici in unlike then dislike");
            let data = {
                user : isLogged,
                like : parseInt("1"),
                dislike : parseInt("0"),
                report : parseInt("0"),
                id_post : parseInt(questionId),
                is_question : parseInt("1"),
                    };
            let json = JSON.stringify(data);

            let urlReact = 'http://localhost/Q_and_A_Aplication/api/post/deletereaction.php';
            let requestReact = new Request( urlReact, {
                headers: header,
                body: json,
                method: 'POST',
            });
            
            await fetch(requestReact)
                .then((response) => response.json())
                .then((data)=>{
                    console.log('Response from server');
                    if(data.message === 'Reaction deleted'){
                        e.target.parentNode.firstChild.classList.remove('reacted');
                        let numb = Number(spanLikeBtn.innerText);
                        console.log(spanLikeBtn.innerText);
                        numb = numb-1;
                        spanLikeBtn.innerText = numb;
                    }
                })
            .catch(console.warn);

            let data2 = {like : parseInt("0"),
                        dislike : parseInt("1"),
                        report : parseInt("0"),
                        user : isLogged,
                        id_post : parseInt(questionId),
                        is_question : parseInt("1"),
                        };
            let json2 = JSON.stringify(data2);
            console.log(json2);

            let urlReact2 = 'http://localhost/Q_and_A_Aplication/api/post/createreaction.php';
            let requestReact2 = new Request( urlReact2, {
                headers: header,
                body: json2,
                method: 'POST',
            });

            await fetch(requestReact2)
                .then((response) => response.json())
                .then((data)=>{
                    console.log('Response from server');
                    if(data.message === 'Reaction created'){
                        e.target.classList.add('reacted');
                        let numb = Number(spanDislikeBtn.innerText);
                        numb = numb+1;
                        spanDislikeBtn.innerText = numb;
                    }
                })
            .catch(console.warn);
            }
        else {
            if(e.target.classList.contains('reacted')){
                console.log("intra aici in dislike");
                let data = {
                    user : isLogged,
                    like : parseInt("0"),
                    dislike : parseInt("1"),
                    report : parseInt("0"),
                    id_post : parseInt(questionId),
                    is_question : parseInt("1"),
                        };
                const json = JSON.stringify(data);
                console.log(json);


                let urlReact = 'http://localhost/Q_and_A_Aplication/api/post/deletereaction.php';
                let requestReact = new Request( urlReact, {
                    headers: header,
                    body: json,
                    method: 'POST',
                });
                
                await fetch(requestReact)
                    .then((response) => response.json())
                    .then((data)=>{
                        console.log('Response from server');
                        if(data.message === 'Reaction deleted'){
                            e.target.classList.remove('reacted');
                            let numb = Number(spanDislikeBtn.innerText);
                            numb = numb-1;
                            spanDislikeBtn.innerText = numb;
                        }
                    })
                .catch(console.warn);
            }
            else {
                let data = {like : parseInt("0"),
                            dislike : parseInt("1"),
                            report : parseInt("0"),
                            user : isLogged,
                            id_post : parseInt(questionId),
                            is_question : parseInt("1"),
                            };
                let json = JSON.stringify(data);
                console.log(json);

                let urlReact = 'http://localhost/Q_and_A_Aplication/api/post/createreaction.php';
                let requestReact = new Request( urlReact, {
                    headers: header,
                    body: json,
                    method: 'POST',
                });

            await fetch(requestReact)
                    .then((response) => response.json())
                    .then((data)=>{
                        console.log('Response from server');
                        if(data.message === 'Reaction created'){
                            e.target.classList.add('reacted');
                            let numb = Number(spanDislikeBtn.innerText);
                            numb = numb+1;
                            spanDislikeBtn.innerText = numb;
                        }
                    })
                .catch(console.warn);
                }
            }
        }
    }

async function giveLikeAnswer(e){
    e.preventDefault();
    let question = e.target.parentNode.parentNode;
    let questionId = question.querySelector('#questionIDhidden').value;

    let spanLikeBtn = e.target.lastChild;
    let spanDislikeBtn = question.lastChild.lastChild.previousSibling.lastChild;
    console.log(spanLikeBtn);
    console.log(spanDislikeBtn);
    if(isLogged == ""){
        showPopup();
    }
    else {
        if(e.target.parentNode.lastChild.previousSibling.classList.contains('reacted')){
            console.log("intra aici in undislike then like");
            let data = {
                user : isLogged,
                like : parseInt("0"),
                dislike : parseInt("1"),
                report : parseInt("0"),
                id_post : parseInt(questionId),
                is_question : parseInt("1"),
                    };
            let json = JSON.stringify(data);

            let urlReact = 'http://localhost/Q_and_A_Aplication/api/post/deletereaction.php';
            let requestReact = new Request( urlReact, {
                headers: header,
                body: json,
                method: 'POST',
            });
            
            await fetch(requestReact)
                .then((response) => response.json())
                .then((data)=>{
                    console.log('Response from server');
                    if(data.message === 'Reaction deleted'){
                        e.target.parentNode.lastChild.previousSibling.classList.remove('reacted');
                        let numb = Number(spanDislikeBtn.innerText);
                        numb = numb-1;
                        spanDislikeBtn.innerText = numb;
                    }
            })
            .catch(console.warn);

            
            let data2 = {like : parseInt("1"),
                        dislike : parseInt("0"),
                        report : parseInt("0"),
                        user : isLogged,
                        id_post : parseInt(questionId),
                        is_question : parseInt("0"),
                        };
            let json2 = JSON.stringify(data2);
            console.log(json2);

            let urlReact2 = 'http://localhost/Q_and_A_Aplication/api/post/createreaction.php';
            let requestReact2 = new Request( urlReact2, {
                headers: header,
                body: json2,
                method: 'POST',
            });

            await fetch(requestReact2)
                .then((response) => response.json())
                .then((data)=>{
                    console.log('Response from server');
                    if(data.message === 'Reaction created'){
                        e.target.classList.add('reacted');
                        let numb = Number(spanLikeBtn.innerText);
                        numb = numb+1;
                        spanLikeBtn.innerText = numb;
                    }
            })
            .catch(console.warn);
            }
        else {
                if(e.target.classList.contains('reacted')){
                    console.log("intra aici");
                    let data = {
                        user : isLogged,
                        like : parseInt("1"),
                        dislike : parseInt("0"),
                        report : parseInt("0"),
                        id_post : parseInt(questionId),
                        is_question : parseInt("1"),
                            };
                    let json = JSON.stringify(data);

                    let urlReact = 'http://localhost/Q_and_A_Aplication/api/post/deletereaction.php';
                    let requestReact = new Request( urlReact, {
                        headers: header,
                        body: json,
                        method: 'POST',
                    });
                    
                    await fetch(requestReact)
                        .then((response) => response.json())
                        .then((data)=>{
                            console.log('Response from server');
                            if(data.message === 'Reaction deleted'){
                                e.target.classList.remove('reacted');
                                let numb = Number(spanLikeBtn.innerText);
                                numb = numb-1;
                                spanLikeBtn.innerText = numb;
                            }
                        })
                    .catch(console.warn);
                }
                else { 
                    console.log("intra aici-la baza");
                    let data = {like : parseInt("1"),
                                dislike : parseInt("0"),
                                report : parseInt("0"),
                                user : isLogged,
                                id_post : parseInt(questionId),
                                is_question : parseInt("0"),
                                };
                    let json = JSON.stringify(data);
                    console.log(json);

                    let urlReact = 'http://localhost/Q_and_A_Aplication/api/post/createreaction.php';
                    let requestReact = new Request( urlReact, {
                        headers: header,
                        body: json,
                        method: 'POST',
                    });

                    await fetch(requestReact)
                        .then((response) => response.json())
                        .then((data)=>{
                            console.log('Response from server');
                            if(data.message === 'Reaction created'){
                                e.target.classList.add('reacted');
                                let numb = Number(spanLikeBtn.innerText);
                                numb = numb+1;
                                spanLikeBtn.innerText = numb;
                            }
                        })
                    .catch(console.warn);
                }
            }
    }
}
    
async function giveDislikeAnswer(e){
    e.preventDefault();
    isLogged = document.getElementById('session_var').value;
    let question = e.target.parentNode.parentNode;
    let questionId = question.querySelector('#questionIDhidden').value;

    let spanLikeBtn = e.target.previousSibling.lastChild;
    let spanDislikeBtn =  e.target.lastChild;
    console.log(spanLikeBtn);
    console.log(spanDislikeBtn);
    if(isLogged == ""){
        showPopup();
    }  else {
        if(e.target.parentNode.firstChild.classList.contains('reacted')){
            console.log("intra aici in unlike then dislike");
            let data = {
                user : isLogged,
                like : parseInt("1"),
                dislike : parseInt("0"),
                report : parseInt("0"),
                id_post : parseInt(questionId),
                is_question : parseInt("1"),
                    };
            let json = JSON.stringify(data);

            let urlReact = 'http://localhost/Q_and_A_Aplication/api/post/deletereaction.php';
            let requestReact = new Request( urlReact, {
                headers: header,
                body: json,
                method: 'POST',
            });
            
            await fetch(requestReact)
                .then((response) => response.json())
                .then((data)=>{
                    console.log('Response from server');
                    if(data.message === 'Reaction deleted'){
                        e.target.parentNode.firstChild.classList.remove('reacted');
                        let numb = Number(spanLikeBtn.innerText);
                        console.log(spanLikeBtn.innerText);
                        numb = numb-1;
                        spanLikeBtn.innerText = numb;
                    }
                })
            .catch(console.warn);

            let data2 = {like : parseInt("0"),
                        dislike : parseInt("1"),
                        report : parseInt("0"),
                        user : isLogged,
                        id_post : parseInt(questionId),
                        is_question : parseInt("0"),
                        };
            let json2 = JSON.stringify(data2);
            console.log(json2);

            let urlReact2 = 'http://localhost/Q_and_A_Aplication/api/post/createreaction.php';
            let requestReact2 = new Request( urlReact2, {
                headers: header,
                body: json2,
                method: 'POST',
            });

            await fetch(requestReact2)
                .then((response) => response.json())
                .then((data)=>{
                    console.log('Response from server');
                    if(data.message === 'Reaction created'){
                        e.target.classList.add('reacted');
                        let numb = Number(spanDislikeBtn.innerText);
                        numb = numb+1;
                        spanDislikeBtn.innerText = numb;
                    }
                })
            .catch(console.warn);
            }
        else {
            if(e.target.classList.contains('reacted')){
                console.log("intra aici in dislike");
                let data = {
                    user : isLogged,
                    like : parseInt("0"),
                    dislike : parseInt("1"),
                    report : parseInt("0"),
                    id_post : parseInt(questionId),
                    is_question : parseInt("1"),
                        };
                const json = JSON.stringify(data);
                console.log(json);


                let urlReact = 'http://localhost/Q_and_A_Aplication/api/post/deletereaction.php';
                let requestReact = new Request( urlReact, {
                    headers: header,
                    body: json,
                    method: 'POST',
                });
                
                await fetch(requestReact)
                    .then((response) => response.json())
                    .then((data)=>{
                        console.log('Response from server');
                        if(data.message === 'Reaction deleted'){
                            e.target.classList.remove('reacted');
                            let numb = Number(spanDislikeBtn.innerText);
                            numb = numb-1;
                            spanDislikeBtn.innerText = numb;
                        }
                    })
                .catch(console.warn);
            }
            else {
                let data = {like : parseInt("0"),
                            dislike : parseInt("1"),
                            report : parseInt("0"),
                            user : isLogged,
                            id_post : parseInt(questionId),
                            is_question : parseInt("0"),
                            };
                let json = JSON.stringify(data);
                console.log(json);
                let urlReact = 'http://localhost/Q_and_A_Aplication/api/post/createreaction.php';
                let requestReact = new Request( urlReact, {
                    headers: header,
                    body: json,
                    method: 'POST',
                });

            await fetch(requestReact)
                    .then((response) => response.json())
                    .then((data)=>{
                        console.log('Response from server');
                        if(data.message === 'Reaction created'){
                            e.target.classList.add('reacted');
                            let numb = Number(spanDislikeBtn.innerText);
                            numb = numb+1;
                            spanDislikeBtn.innerText = numb;
                        }
                    })
                .catch(console.warn);
                }
            }
        }
    }

    async function giveReport(e){
        e.preventDefault();
        let question = e.target.parentNode.parentNode;
        let questionId = question.querySelector('#questionIDhidden').value;
        
        spanReportBtn = e.target.lastChild;
    
        if(isLogged == ""){
            showPopup();
        }
        else if(e.target.classList.contains('reacted')){
                console.log("intra aici");
                let data = {
                    user : isLogged,
                    like : parseInt("0"),
                    dislike : parseInt("0"),
                    report : parseInt("1"),
                    id_post : parseInt(questionId),
                    is_question : parseInt("1"),
                        };
                let json = JSON.stringify(data);
    
                let urlReact = 'http://localhost/Q_and_A_Aplication/api/post/deletereaction.php';
                let requestReact = new Request( urlReact, {
                    headers: header,
                    body: json,
                    method: 'POST',
                });
                
                await fetch(requestReact)
                    .then((response) => response.json())
                    .then((data)=>{
                        console.log('Response from server');
                        if(data.message === 'Reaction deleted'){
                            e.target.classList.remove('reacted');
                            let numb = Number(spanReportBtn.innerText);
                            numb = numb-1;
                            spanReportBtn.innerText = numb;
                        }
                    })
                .catch(console.warn);
            }
            else { 
                console.log("intra aici-la baza");
                let data = {like : parseInt("0"),
                            dislike : parseInt("0"),
                            report : parseInt("1"),
                            user : isLogged,
                            id_post : parseInt(questionId),
                            is_question : parseInt("1"),
                            };
                let json = JSON.stringify(data);
                console.log(json);
    
                let urlReact = 'http://localhost/Q_and_A_Aplication/api/post/createreaction.php';
                let requestReact = new Request( urlReact, {
                    headers: header,
                    body: json,
                    method: 'POST',
                });
    
                await fetch(requestReact)
                    .then((response) => response.json())
                    .then((data)=>{
                        console.log('Response from server');
                        if(data.message === 'Reaction created'){
                            e.target.classList.add('reacted');
                            let numb = Number(spanReportBtn.innerText);
                            numb = numb+1;
                            spanReportBtn.innerText = numb;
                        }
                        else if(data.message === 'Question deleted'){
                            showPopup2("Question has been deleted!");
                            setTimeout(() => {
                                window.location.reload();    
                              }, "3000");
                        }
                    })
                .catch(console.warn);
            }
    }

    async function giveReportAnswer(e){
        e.preventDefault();
        let question = e.target.parentNode.parentNode;
        let questionId = question.querySelector('#questionIDhidden').value;
        
        spanReportBtn = e.target.lastChild;
    
        if(isLogged == ""){
            showPopup();
        }
        else if(e.target.classList.contains('reacted')){
                console.log("intra aici");
                let data = {
                    user : isLogged,
                    like : parseInt("0"),
                    dislike : parseInt("0"),
                    report : parseInt("1"),
                    id_post : parseInt(questionId),
                    is_question : parseInt("0"),
                        };
                let json = JSON.stringify(data);
    
                let urlReact = 'http://localhost/Q_and_A_Aplication/api/post/deletereaction.php';
                let requestReact = new Request( urlReact, {
                    headers: header,
                    body: json,
                    method: 'POST',
                });
                
                await fetch(requestReact)
                    .then((response) => response.json())
                    .then((data)=>{
                        console.log('Response from server');
                        if(data.message === 'Reaction deleted'){
                            e.target.classList.remove('reacted');
                            let numb = Number(spanReportBtn.innerText);
                            numb = numb-1;
                            spanReportBtn.innerText = numb;
                        }
                    })
                .catch(console.warn);
            }
            else { 
            
                let data = {like : parseInt("0"),
                            dislike : parseInt("0"),
                            report : parseInt("1"),
                            user : isLogged,
                            id_post : parseInt(questionId),
                            is_question : parseInt("0"),
                            };
                let json = JSON.stringify(data);
                console.log(json);
    
                let urlReact = 'http://localhost/Q_and_A_Aplication/api/post/createreaction.php';
                let requestReact = new Request( urlReact, {
                    headers: header,
                    body: json,
                    method: 'POST',
                });
                await fetch(requestReact)
                    .then((response) => response.json())
                    .then((data)=>{
                        
                        if(data.message === 'Reaction created'){
                            e.target.classList.add('reacted');
                            let numb = Number(spanReportBtn.innerText);
                            numb = numb+1;
                            spanReportBtn.innerText = numb;
                        }
                        else if(data.message === 'Answer deleted'){
                            showPopup2("Answer has been deleted!");
                            setTimeout(() => {
                                window.location.reload();    
                              }, "3000");
                        }
                    })
                .catch(console.warn);
            }
    }

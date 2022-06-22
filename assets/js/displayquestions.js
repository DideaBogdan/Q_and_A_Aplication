mainPannel = document.getElementById('main-pannel');

isLogged = document.getElementById('session_var').value;
isLogged_ID = document.getElementById('session_var_id').value;

isAdmin = document.getElementById('session_admin').value;


let response;
let permData
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
        permData = data;
        displayquestions(data);
    })
.catch(console.warn);


async function displayquestions(json){
    content = json;
    let urlget = 'http://localhost/Q_and_A_Aplication/api/post/getreactions.php';
    
    let request = new Request( urlget, {
        headers: header,
        method: 'GET',
    });
    await fetch(request)
        .then((response) => response.json())
        .then((data)=>{
            response = data;
        })
    .catch(console.warn);

    content.forEach(element => {
        
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
        text.classList.add("questionText");
        text.setAttribute("href", "http://localhost/Q_and_A_Aplication/detailed.php?id="+element.id);
      //  text.addEventListener('click', redirect);
        text.appendChild(node);
        username.setAttribute("style", "float : left; margin : 10px; text-decoration: none;");
        if(element.username!= null){
        username.setAttribute("href", "http://localhost/Q_and_A_Aplication/profile.php?username=" + element.username);
        }
        questionTitle.setAttribute("style", "margin : -10px");
        questionTitle.appendChild(username);

        category.setAttribute("style", "display : inline-block");
        category.innerText = " in " + element.category;
       

        category.setAttribute("style", "float : right; margin : 10px;");
        questionTitle.appendChild(category);   

        // pentru afisarea acum cat timp a fost pusa o intrebare sau cand s-a raspuns
        timestamp = document.createElement('p');
        timestamp.setAttribute("style" , "margin : 5px");
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


        questionForm.appendChild(timestamp);
        questionForm.appendChild(questionTitle);
        questionForm.appendChild(text);

        divBtns = document.createElement('div');
        likeButton = document.createElement('button');
        dislikeButton = document.createElement('button');
        reportButton = document.createElement('button');

        likeButton.innerText = "Like " ;
        dislikeButton.innerText = "Dislike ";
        
        likeButton.setAttribute('class', 'likeButton');
        dislikeButton.setAttribute('class', 'dislikeButton');


        spanLike = document.createElement('span');
        spanDislike = document.createElement('span');
        spanLike.setAttribute('class', 'likespan');
        spanDislike.setAttribute('class', 'dislikespan');
        reportButton.setAttribute('class', 'reportButton');

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
        })
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

        questionForm.appendChild(divBtns);
        questionForm.setAttribute('id', 'question-form');
        username.setAttribute('id', 'username');
        mainPannel.appendChild(questionForm);

        ///aici ar trebui un questionForm.appendChild() pentru butoanele de sub intrebare - like/dislike eventual - !!!important - butonul de raspunsuri
        /// butonul de raspunsuri va fi generat din script (de aici) si va afisa raspunsurile + un field de tip input pentru a raspunde si utilizatorul 
    });
}





function redirect(e){
    e.preventDefault();
    let id = -1;
    let texturl = "";
    permData.forEach(element => {
        console.log(element.text);
        if(e.currentTarget.innerText == element.text)
            id = element.id;
            texturl = e.currentTarget.innerText;
            console.log(texturl);
    });
    location.assign("http://localhost/Q_and_A_Aplication/detailed.php?id=" + id);
    console.log(e.currentTarget.innerText);
}



function showPopup(text){
    popUp = document.getElementById('popUp');
    popUp.style.display = "block";

    container = document.getElementById('containerpopup');
    container.style.display = "block";

    contentText = document.getElementById('content');
    contentText.innerText = text;

    container.addEventListener('click', function(e){
        if(e.target === container) {
            popUp.style.display = "none";
            container.style.display = "none";
            window.location.reload();
        }
    })

    closeBtn = document.getElementById('close');
    closeBtn.addEventListener('click', function(e){
        popUp.style.display = "none";
        container.style.display = "none";
        window.location.reload();
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


function giveReaction(e){
    btnDiv = e.target.parentNode;
    if(e.target.classList.contains('likeButton')){
        giveLike(e);
    }
    else if(e.target.classList.contains('dislikeButton')){
        giveDislike(e);
    }
    else if(e.target.classList.contains('reportButton')){
        giveReport(e);
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
        showPopup('You must have an account to react to posts!');
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
        showPopup('You must have an account to react to posts!');
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

async function giveReport(e){
    e.preventDefault();
    let question = e.target.parentNode.parentNode;
    let questionId = question.querySelector('#questionIDhidden').value;
    
    spanReportBtn = e.target.lastChild;

    if(isLogged == ""){
        showPopup('You must have an account to react to posts!');
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
            let header2 = new Headers();
            header2.append('Content-Type', 'text/xml');
            let requestReact = new Request( urlReact, {
                headers: header2,
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
    
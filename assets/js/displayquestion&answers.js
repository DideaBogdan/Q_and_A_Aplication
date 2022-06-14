mainPannel = document.getElementById('main-pannel');
let permData;

questionId = document.getElementById('question_id').value;
let obj = {id : parseInt(questionId)};
const json = JSON.stringify(obj);   

const user_username = document.getElementById('user_answer').value;

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


function displayquestion_answers(json){
    data = json;
    console.log(data);
    data.slice(0,1).forEach(element => {
            questionForm = document.createElement('div');
            questionTitle = document.createElement('h3');
            username = document.createElement('p');
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

            questionForm.appendChild(questionTitle);
            questionForm.appendChild(text);
        
            questionForm.setAttribute('id', 'question-form');
            text.setAttribute('id', 'question-box');
            username.setAttribute('id', 'username');
            mainPannel.appendChild(questionForm);
        });

    answerForm = document.createElement('form');
    answerForm.addEventListener('submit', createanswer);;
    answerForm.setAttribute('name', 'formanswer');

    answerInput = document.createElement('input');
    answerInput.setAttribute('type', 'text');
    answerInput.setAttribute('placeholder', 'Type your answer here...');
    answerInput.setAttribute('name', 'answer');

    answerButton = document.createElement('button');
    answerButton.appendChild(document.createTextNode('Submit answer'));

    answerForm.appendChild(answerInput);
    answerForm.appendChild(answerButton);
    mainPannel.appendChild(answerForm);

    
    data.slice(1).forEach(element => {
        questionForm = document.createElement('div');
        questionTitle = document.createElement('h3');
        username = document.createElement('p');
        text = document.createElement('a');
       
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
        questionForm.appendChild(text);
    
        questionForm.setAttribute('id', 'question-form');
        text.setAttribute('id', 'question-box');
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
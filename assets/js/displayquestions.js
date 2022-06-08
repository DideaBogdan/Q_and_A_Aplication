mainPannel = document.getElementById('main-pannel');
//questionForm = document.createElement('div');//.setAttribute('id', 'question-form');
//questionTitle = document.createElement('h3').setAttribute('id', 'question-title');
//username = document.createElement('p');//.setAttribute('id', 'username');
//text = document.createElement('div');//.setAttribute('id', 'question-box');


let url = 'http://localhost/Q_and_A_Aplication/api/post/displayquestions.php';
let header = new Headers();
header.append('Content-type', 'application/json');
let request = new Request( url, {
    headers: header,
    //body: json,
    method: 'GET',
});
fetch(request)
    .then((response) => response.json())
    .then((data)=>{
        console.log('Response from server');
        //let variable = JSON.parse(data);
        //console.log(data);
        displayquestions(data);
    })
.catch(console.warn);


function displayquestions(json){
    data = json;
    
    data.forEach(element => {
        

        questionForm = document.createElement('div');
        questionTitle = document.createElement('h3');
        username = document.createElement('p');
        text = document.createElement('div');

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

        ///aici ar trebui un questionForm.appendChild() pentru butoanele de sub intrebare - like/dislike eventual - !!!important - butonul de raspunsuri
        /// butonul de raspunsuri va fi generat din script (de aici) si va afisa raspunsurile + un field de tip input pentru a raspunde si utilizatorul 
    });
}
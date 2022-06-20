leftPannel = document.getElementsByClassName('left-pannel');
divAnswers = document.getElementById ('leaderboard_answer');
divQuestions = document.getElementById ('leaderboard_questions');
divStatistics = document.getElementById('statistics');

let scores;
getleaderboard();
async function getleaderboard(){
    let url14 = 'http://localhost/Q_and_A_Aplication/api/post/showleaderboard.php';
let header4 = new Headers();
header4.append('Content-type', 'application/json');
let request14 = new Request( url14, {
    headers: header4,
    method: 'GET',
});
 await fetch(request14)
    .then((response) => response.json())
    .then((data)=>{
        scores= data;
    })
.catch(console.warn);
 
//left first statistic
let index=1;
scores[0].sort((a,b) =>  b.score - a.score);
scores[0].slice(0,10).forEach(element => {

   spanElem=document.createElement('span');
   spanElem.setAttribute('class', 'ladeboard-row');

   pIndex= document.createElement('p');
   pName = document.createElement('a');
   pScore = document.createElement('p');
   
   pIndex.innerText= index + '.';
   index++;
   pName.innerText = element.nume;
   pName.setAttribute('style', 'margin-left: 10px; margin-right: 10px; text-decoration: none; color: #f09819;')
   pName.setAttribute("href", "http://localhost/Q_and_A_Aplication/profile.php?username=" + element.nume);
   pName.setAttribute('id', 'username');
   
   pScore.innerText = element.score;

   spanElem.appendChild(pIndex);
   spanElem.appendChild(pName);
   spanElem.appendChild(pScore);
   spanElem.setAttribute('style', 'word-break: break-all; text-align: center;');


   divAnswers.appendChild(spanElem);


});

 //left second statistic
index=1;
scores[1].sort((a,b) => b.score - a.score);
console.log(scores[1]);
scores[1].slice(0,10).forEach(element => {
    
    spanElem=document.createElement('span');
    spanElem.setAttribute('class', 'ladeboard-row');
 
    pIndex= document.createElement('p');
    pName = document.createElement('a');
    pScore = document.createElement('p');
    
    pIndex.innerText= index + '.';
    index++;
    pName.innerText = element.nume;
    pName.setAttribute('style', 'margin-left: 10px; margin-right: 10px; text-decoration: none; color: #f09819;');
    pName.setAttribute("href", "http://localhost/Q_and_A_Aplication/profile.php?username=" + element.nume);
    pName.setAttribute('id', 'username');

 
    pScore.innerText = element.score;
 
    spanElem.appendChild(pIndex);
    spanElem.appendChild(pName);
    spanElem.appendChild(pScore);
    spanElem.setAttribute('style', 'word-break: break-all; text-align: center;');
 
    divQuestions.appendChild(spanElem);
 
 });

    //right statistic

    //users
    spanNum = document.createElement ('span');
    spanNum.setAttribute('class', 'statistic-value');
    pUsers= document.createElement('p');
    pUsers.innerText = 'Users:';
    spanNum.innerText = scores[2][0].users;
    spanNum.setAttribute('style', 'margin-right: 10px;')
    pUsers.appendChild(spanNum);
    divStatistics.appendChild(pUsers);
    
    //questions
    spanNum = document.createElement ('span');
    spanNum.setAttribute('class', 'statistic-value');
    pQuestions= document.createElement('p');
    pQuestions.innerText = 'Questions:';
    spanNum.innerText = scores[2][1].questions;
    spanNum.setAttribute('style', 'margin-right: 10px;')
    pQuestions.appendChild(spanNum);
    divStatistics.appendChild(pQuestions);

    //answers
    spanNum = document.createElement ('span');
    spanNum.setAttribute('class', 'statistic-value');
    pAnswers= document.createElement('p');
    pAnswers.innerText = 'Answers:';
    spanNum.innerText = scores[2][2].answers;
    spanNum.setAttribute('style', 'margin-right: 10px;')
    pAnswers.appendChild(spanNum);
    divStatistics.appendChild(pAnswers);

    //questions_no_answers
   spanNum = document.createElement ('span');
    spanNum.setAttribute('class', 'statistic-value');
    pQNoA= document.createElement('p');
    pQNoA.innerText = 'Unanswered questions:';
    pQNoA.setAttribute('style', 'word-break: break-all;');
    spanNum.innerText = scores[2][3].q_no_a;
    spanNum.setAttribute('style', 'margin-right: 10px;')
    pQNoA.appendChild(spanNum);
    divStatistics.appendChild(pQNoA);
    
}

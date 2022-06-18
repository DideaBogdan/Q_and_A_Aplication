leftPannel = document.getElementsByClassName('left-pannel');
divAnswers = document.getElementById ('leaderboard_answer');

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
        console.log(data);
        scores= data;
        //data.slice(0,11).forEach(element => {
            //console.log(element);
        //}); 
    })
.catch(console.warn);

let index=1;
scores.slice(0,11).forEach(element => {
   console.log(element);
   spanElem=document.createElement('span');
   spanElem.setAttribute('class', 'ladeboard-row');

   pIndex= document.createElement('p');
   pName = document.createElement('p');
   pScore = document.createElement('p');
   
   pIndex.innerText= index;
   index++;
   
   pName.innerText = element.nume;

   pScore.innerText = element.score;

   spanElem.appendChild(pIndex);
   spanElem.appendChild(pName);
   spanElem.appendChild(pScore);

   console.log(spanElem);

   divAnswers.appendChild(spanElem);


});


}

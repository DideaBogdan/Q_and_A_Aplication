
let button = document.getElementById('formbutton');

button.addEventListener('click', createform);

function createform(e){
    e.preventDefault();
    let form = document.getElementById("formquestion");


    if (form.style.display === 'block') {
        form.style.display = 'none';
    } else {
        form.style.display = 'block';
      }
}

select = document.getElementById('category');

let urlget = 'http://localhost/Q_and_A_Aplication/api/post/getcategories.php';
let header2 = new Headers();
header2.append('Content-type', 'application/json');   
let request2 = new Request( urlget, {
    headers: header2,
    method: 'GET',
});
fetch(request2)
    .then((response) => response.json())
    .then((data)=>{
        console.log('Response from server');
        data.forEach(element => {
        option = document.createElement('option');
        option.setAttribute('value', element.name);
        option.innerText = element.name;
        select.appendChild(option);
        });
    })
.catch(console.warn);



let form = document.getElementById('formquestion').addEventListener('submit', createquestion);
const user_id = document.getElementById('session_var');

async function createquestion(e){
    e.preventDefault();


    let myQuestion = e.target;
    let formData = new FormData(myQuestion);
    let json = await convertToJSON(formData); 
    console.log(json);
   
    let url = 'http://localhost/Q_and_A_Aplication/api/post/createquestion.php';
    let header = new Headers();
    header.append('Content-type', 'application/json');
    let request = new Request( url, {
        headers: header,
        body: json,
        method: 'POST',
    });
    fetch(request)
        .then((response) => response.json())
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
        let noExtraSpaces = formData.get(key).replace(/\s+/g, ' ').trim();
        obj[key]= noExtraSpaces;
    }
    if(user_id.value === ""){
        obj['user_id'] = "";
        return JSON.stringify(obj);
    } else{
        obj['user_id'] = user_id.value;
        return JSON.stringify(obj);
    }
}

const textArea = document.getElementsByTagName("textarea");
for (let i = 0; i < textArea.length; i++) {
    textArea[i].setAttribute("style", "height: fit-content");
    textArea[i].addEventListener("input", OnInput, false);
}

function OnInput() {
  this.style.height = "auto";
  this.style.height = (this.scrollHeight) + "px";
}



searchBar = document.getElementById("search-question").addEventListener("input", showmatches);

const resultTemplate = document.querySelector("[result-template]");
const container = document.querySelector("[response-container]");

let questions = [];

async function showmatches(e){
    console.log(e.target.value );
    const value = e.target.value.toLowerCase();
    questions.forEach(question => {
        question.element.classList.toggle("hide", true);
      });
    const obj = {value : value};
    let json = JSON.stringify(obj); 
    let url = 'http://localhost/Q_and_A_Aplication/api/post/getsearch.php';
    let header = new Headers();
    header.append('Content-type', 'application/json');
    let request = new Request( url, {
        headers: header,
        body: json,
        method: 'POST',
    });
    await fetch(request)
        .then((response) => response.json())
        .then((data)=>{
            questions = data.map(question => {
                const card = resultTemplate.content.cloneNode(true).children[0];
                const text = card.querySelector("[question-text]");
                const category = card.querySelector("[question-category]");
                text.textContent = question.text;
                category.textContent = question.category;
                container.append(card);
                return { text: question.text, category: question.category, element: card };
              });
        })
    .catch(console.warn);
    }


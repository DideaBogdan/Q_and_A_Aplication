
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


let form = document.getElementById('formquestion').addEventListener('submit', createquestion);
const user_id = document.getElementById('session_var');

async function createquestion(e){
    e.preventDefault();


    let myQuestion = e.target;
    let formData = new FormData(myQuestion);
    let json = await convertToJSON(formData); 
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
        obj[key]=formData.get(key);
    }
    if(user_id.value === ""){
        obj['user_id'] = "";
        return JSON.stringify(obj);
    } else{
        obj['user_id'] = user_id.value;
        return JSON.stringify(obj);
    }
}
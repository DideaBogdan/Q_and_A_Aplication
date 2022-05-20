let form = document.getElementById('login').addEventListener('submit', submitlogin);

async function submitlogin(e){
    e.preventDefault();

    let myForm = e.target;
    let formData = new FormData(myForm);

    let json =  await convertToJSON(formData);

    let url = 'http://localhost/Q_and_A_Aplication/api/post/loginuser.php';
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
            let msg1 = document.getElementById('msg-login');
            if(data.message ==='Logged into the account!')
                window.location.replace("http://localhost/Q_and_A_Aplication/home.php");
            else msg1.textContent = data.message;
        })
        .catch(console.warn);
}


function convertToJSON(formData){
    let obj={};
    for(let key of formData.keys()){
        obj[key]=formData.get(key);
    }
    return JSON.stringify(obj);
}
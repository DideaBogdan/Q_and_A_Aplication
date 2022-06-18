let form = document.getElementById('contact').addEventListener('submit', createcontact);


async function createcontact(e){
    e.preventDefault();


    let myQuestion = e.target;
    let formData = new FormData(myQuestion);
    let json = await convertToJSON(formData); 
   
    let url = 'http://localhost/Q_and_A_Aplication/createcontact.php';
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
            console.log('Response from server');
            console.log(data);
        })
    .catch(console.warn);

    window.location.reload();
    
}

function convertToJSON(formData){
    let obj={};
    for(let key of formData.keys()){
        obj[key]= formData.get(key);
    }
    return JSON.stringify(obj);
}
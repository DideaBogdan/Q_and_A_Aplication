let username = document.getElementById("session_var").value;
let profileUser = document.getElementById("user_username").value;
let match = 0;
if(username === profileUser){
    match = 1;
}
console.log(username);
console.log(profileUser);
console.log(match);

let header = new Headers();
header.append('Content-type', 'application/json');
getinfo();

async function getinfo(){
    let obj = {username : profileUser};
    let json_id = JSON.stringify(obj);
    let url = 'http://localhost/Q_and_A_Aplication/api/post/userinfo.php';
    let request = new Request( url, {
        headers: header,
        body: json_id,
        method: 'POST',
    });
    await fetch(request)
            .then((response) => response.json())
            .then((data)=>{
                createpage(data);
            })
    .catch(console.warn);
}

function createpage(data){

    userInfo = document.getElementById('user-info');
    let info = data["user"];
    const keys = Object.keys(info);
    for(let key of keys){
       newP = document.createElement('p');
       console.log(key);
       if(key != "password" && key != "id")
       {
        newP.innerText = info[key];
        userInfo.appendChild(newP);
       }
       ///aici mai trebuie preluat jsonul pentru hobbby - si afisat 
    }

    container_questions = document.getElementById("container_questions");
    data["question_badges"].forEach(element => {
        badgeItem = document.createElement('div');
        badgeItem.setAttribute('class', 'badge-item');
        if(element ===  data["question_badges"][0]){
            if(data["total_questions"]["COUNT(*)"] >=5){
                img = document.createElement('img');
                img.setAttribute('title', element["description"]);
                img.setAttribute('src', element['image_path']);
                img.setAttribute('class', 'badge-image');

                badgeTitle = document.createElement('p');
                badgeTitle.setAttribute('class', 'badge-title');
                badgeTitle.innerText = element['title'];
            } else{
                img = document.createElement('img');
                img.setAttribute('title',  element["desk_locked"]);
                img.setAttribute('src',  data['locked_badge']['image_path']);
                img.setAttribute('class', 'badge-image');

                badgeTitle = document.createElement('p');
                badgeTitle.setAttribute('class', 'badge-title');
                badgeTitle.innerText = element['title'];
            }
            
            badgeItem.appendChild(img);
            badgeItem.appendChild(badgeTitle);
            container_questions.firstChild.nextSibling.appendChild(badgeItem);
    
        }

        if(element ===  data["question_badges"][1]){
            if(data["total_questions"]["COUNT(*)"] >=15){
                img = document.createElement('img');
                img.setAttribute('title', element["description"]);
                img.setAttribute('src', element['image_path']);
                img.setAttribute('class', 'badge-image');

                badgeTitle = document.createElement('p');
                badgeTitle.setAttribute('class', 'badge-title');
                badgeTitle.innerText = element['title'];
            } else{
                img = document.createElement('img');
                img.setAttribute('title',  element["desk_locked"]);
                img.setAttribute('src',  data['locked_badge']['image_path']);
                img.setAttribute('class', 'badge-image');

                badgeTitle = document.createElement('p');
                badgeTitle.setAttribute('class', 'badge-title');
                badgeTitle.innerText = element['title'];
            }
            
            badgeItem.appendChild(img);
            badgeItem.appendChild(badgeTitle);
            container_questions.firstChild.nextSibling.appendChild(badgeItem);
        }
        if(element ===  data["question_badges"][2]){
            if(data["total_questions"]["COUNT(*)"] >=50){
                img = document.createElement('img');
                img.setAttribute('title', element["description"]);
                img.setAttribute('src', element['image_path']);
                img.setAttribute('class', 'badge-image');

                badgeTitle = document.createElement('p');
                badgeTitle.setAttribute('class', 'badge-title');
                badgeTitle.innerText = element['title'];
            } else{
                img = document.createElement('img');
                img.setAttribute('title',  element["desk_locked"]);
                img.setAttribute('src',  data['locked_badge']['image_path']);
                img.setAttribute('class', 'badge-image');

                badgeTitle = document.createElement('p');
                badgeTitle.setAttribute('class', 'badge-title');
                badgeTitle.innerText = element['title'];
            }
            
            badgeItem.appendChild(img);
            badgeItem.appendChild(badgeTitle);
            container_questions.firstChild.nextSibling.appendChild(badgeItem);
        }
        if(element ===  data["question_badges"][3]){
            if(data["is_top_questioner"] === true){
                img = document.createElement('img');
                img.setAttribute('title', element["description"]);
                img.setAttribute('src', element['image_path']);
                img.setAttribute('class', 'badge-image');

                badgeTitle = document.createElement('p');
                badgeTitle.setAttribute('class', 'badge-title');
                badgeTitle.innerText = element['title'];
            } else{
                img = document.createElement('img');
                img.setAttribute('title',  element["desk_locked"]);
                img.setAttribute('src',  data['locked_badge']['image_path']);
                img.setAttribute('class', 'badge-image');

                badgeTitle = document.createElement('p');
                badgeTitle.setAttribute('class', 'badge-title');
                badgeTitle.innerText = element['title'];
            }
            
            badgeItem.appendChild(img);
            badgeItem.appendChild(badgeTitle);
            container_questions.firstChild.nextSibling.appendChild(badgeItem);
        }


    });

    container_answers = document.getElementById("container_answers");
    data["answer_badges"].forEach(element => {
        badgeItem = document.createElement('div');
        badgeItem.setAttribute('class', 'badge-item');
        if(element ===  data["answer_badges"][0]){
            if(data["total_answers"]["COUNT(*)"] >=10){
                img = document.createElement('img');
                img.setAttribute('title', element["description"]);
                img.setAttribute('src', element['image_path']);
                img.setAttribute('class', 'badge-image');

                badgeTitle = document.createElement('p');
                badgeTitle.setAttribute('class', 'badge-title');
                badgeTitle.innerText = element['title'];
            } else{
                img = document.createElement('img');
                img.setAttribute('title',  element["desk_locked"]);
                img.setAttribute('src',  data['locked_badge']['image_path']);
                img.setAttribute('class', 'badge-image');

                badgeTitle = document.createElement('p');
                badgeTitle.setAttribute('class', 'badge-title');
                badgeTitle.innerText = element['title'];
                
            }
            
            badgeItem.appendChild(img);
            badgeItem.appendChild(badgeTitle);
            container_answers.firstChild.nextSibling.appendChild(badgeItem);
    
        }

        if(element ===  data["answer_badges"][1]){
            if(data["total_answers"]["COUNT(*)"] >=25){
                img = document.createElement('img');
                img.setAttribute('title', element["description"]);
                img.setAttribute('src', element['image_path']);
                img.setAttribute('class', 'badge-image');

                badgeTitle = document.createElement('p');
                badgeTitle.setAttribute('class', 'badge-title');
                badgeTitle.innerText = element['title'];
            } else{
                img = document.createElement('img');
                img.setAttribute('title',  element["desk_locked"]);
                img.setAttribute('src',  data['locked_badge']['image_path']);
                img.setAttribute('class', 'badge-image');

                badgeTitle = document.createElement('p');
                badgeTitle.setAttribute('class', 'badge-title');
                badgeTitle.innerText = element['title'];
               
            }
            
            badgeItem.appendChild(img);
            badgeItem.appendChild(badgeTitle);
            container_answers.firstChild.nextSibling.appendChild(badgeItem);
        }
        if(element ===  data["answer_badges"][2]){
            if(data["total_answers"]["COUNT(*)"] >=100){
                img = document.createElement('img');
                img.setAttribute('title', element["description"]);
                img.setAttribute('src', element['image_path']);
                img.setAttribute('class', 'badge-image');

                badgeTitle = document.createElement('p');
                badgeTitle.setAttribute('class', 'badge-title');
                badgeTitle.innerText = element['title'];
            } else{
                img = document.createElement('img');
                img.setAttribute('title',  element["desk_locked"]);
                img.setAttribute('src',  data['locked_badge']['image_path']);
                img.setAttribute('class', 'badge-image');

                badgeTitle = document.createElement('p');
                badgeTitle.setAttribute('class', 'badge-title');
                badgeTitle.innerText = element['title'];
               
            }
            
            badgeItem.appendChild(img);
            badgeItem.appendChild(badgeTitle);
            container_answers.firstChild.nextSibling.appendChild(badgeItem);
        }
        if(element ===  data["answer_badges"][3]){
            if(data["is_top_answerer"] === true){
                img = document.createElement('img');
                img.setAttribute('title', element["description"]);
                img.setAttribute('src', element['image_path']);
                img.setAttribute('class', 'badge-image');

                badgeTitle = document.createElement('p');
                badgeTitle.setAttribute('class', 'badge-title');
                badgeTitle.innerText = element['title'];
            } else{
                img = document.createElement('img');
                img.setAttribute('title',  element["desk_locked"]);
                img.setAttribute('src',  data['locked_badge']['image_path']);
                img.setAttribute('class', 'badge-image');

                badgeTitle = document.createElement('p');
                badgeTitle.setAttribute('class', 'badge-title');
                badgeTitle.innerText = element['title'];
              
            }
            
            badgeItem.appendChild(img);
            badgeItem.appendChild(badgeTitle);
            container_answers.firstChild.nextSibling.appendChild(badgeItem);
        }
    });

    q_numb = document.getElementById('q_numb');
    q_numb.innerText += data["total_questions"]["COUNT(*)"];

    questionsArea = q_numb.nextSibling.nextSibling;
    data['questions'].forEach(element=>{
        divCont = document.createElement('div');

        goToQ = document.createElement('a');
        goToQ.setAttribute('href', "detailed.php?id=" + element['id']);
        goToQ.innerText = element['text'];
        divCont.appendChild(goToQ);

        inputID = document.createElement('input');
        inputID.setAttribute('type', 'hidden');
        inputID.setAttribute('value', element['id']);
        divCont.appendChild(inputID);

        if(match === 1){
            removeBtn = document.createElement('button');
            removeBtn.classList.add("edit-btn");
            removeBtn.addEventListener('click', forquestion);

            removeBtn.innerText = "Delete";
            divCont.appendChild(removeBtn);

            updateBtn = document.createElement('button');
            updateBtn.classList.add("edit-btn");
            updateBtn.addEventListener('click', forquestion);
            updateBtn.innerText = "Update";
            divCont.appendChild(updateBtn);
        }
        

        questionsArea.appendChild(divCont);
    });

    a_numb = document.getElementById('a_numb');
    a_numb.innerText += data["total_answers"]["COUNT(*)"];

    answersArea = a_numb.nextSibling.nextSibling;
    data['answers'].forEach(element=>{
        divCont = document.createElement('div');

        goToQ = document.createElement('a');
        goToQ.setAttribute('href', "detailed.php?id=" + element['question']);
        goToQ.innerText = element['text'];
        divCont.appendChild(goToQ);

        inputID = document.createElement('input');
        inputID.setAttribute('type', 'hidden');
        inputID.setAttribute('value', element['id']);
        divCont.appendChild(inputID);
       
        if(match == 1){
            removeBtn = document.createElement('button');
            removeBtn.classList.add("edit-btn");
            removeBtn.addEventListener('click', foranswer);
            removeBtn.innerText = "Delete";
            divCont.appendChild(removeBtn);


            updateBtn = document.createElement('button');
            updateBtn.classList.add("edit-btn");
            updateBtn.addEventListener('click', foranswer);
            updateBtn.innerText = "Update";
            divCont.appendChild(updateBtn);
        }

        answersArea.appendChild(divCont);
    });
}

async function foranswer(e){
    e.preventDefault();
    let get_input = e.target.parentNode.firstChild;
    let get_id;
    console.log(get_input);
    if(get_input.tagName.toLowerCase() === "a"){
        get_anchor = get_input.nextSibling;
    }
    while(get_input.nextSibling){
        if(get_input.nextSibling.tagName.toLowerCase() === "input"){
            get_id = get_input.nextSibling.value;
        }
        if(get_input.nextSibling.tagName.toLowerCase() === "a"){
            console.log(get_input.nextSibling.tagName);
            get_anchor = get_input.nextSibling;
        }
        get_input = get_input.nextSibling;
    }
    let op;
    let jsonop;
    let urledit = 'http://localhost/Q_and_A_Aplication/api/post/editanswer.php';
    if(e.target.innerText === "Update"){  

        div = e.target.parentNode;
        console.log(div);
        for(i=0;i<div.children.length;i++){
            div.children[i].setAttribute('style', 'display: none;');
        }
        
        formEdit = document.createElement('form');
        formEdit.setAttribute('id', 'editanswer');
        formEdit.setAttribute('name', 'editanswer');

        inputQ = document.createElement('textarea');
        inputQ.setAttribute('name', 'inputA');
        inputQ.setAttribute('id', 'inputA');
        inputQ.value =  div.firstChild.innerText;

        formEdit.appendChild(inputQ);

        subBtn = document.createElement('button');
        subBtn.setAttribute('class', 'edit-btn');
        subBtn.innerText = "Update";

        let updated;
        formEdit.addEventListener('submit', (e)=>{
            e.preventDefault();
            div = e.target.parentNode.parentNode;
            updated = inputQ.value;
            let trimed = updated.replace(/\s+/g, ' ').trim();
            op = {op : "update", id: get_id, text : trimed};
            jsonop = JSON.stringify(op);
            console.log(jsonop);

            let request = new Request( urledit, {
                headers: header,
                body: jsonop,
                method: 'POST',
            });
            fetch(request)
                    .then((response) => response.json())
                    .then((data)=>{
                        console.log('Response from server');
                        if(data['message'] === "Answer updated"){
                            showPopup("Answer was updated");
                        }
                    })
            .catch(console.warn);
            setTimeout(() => {
                window.location.reload();    
            }, "3000");
        })
        formEdit.appendChild(subBtn);
        
        div.appendChild(formEdit);
        const textArea = document.getElementById("inputA");
        for (let i = 0; i < textArea.length; i++) {
            textArea[i].setAttribute("style", "height: fit-content");
            textArea[i].addEventListener("input", OnInput, false);
        }
    } else {
        op = {op : "delete", id: get_id};
        jsonop = JSON.stringify(op);
        console.log(jsonop);
    
    let request = new Request( urledit, {
        headers: header,
        body: jsonop,
        method: 'POST',
    });
    await fetch(request)
            .then((response) => response.json())
            .then((data)=>{
                console.log('Response from server');
                if(data['message'] === "Answer deleted"){
                    showPopup("Answer was deleted");
                }
                else if(data['message'] === "Answer updated"){
                    showPopup("Answer was updated");
                }
            })
    .catch(console.warn);
    setTimeout(() => {
        window.location.reload();    
      }, "3000");
    }
    }

async function forquestion(e){
    e.preventDefault();
    let get_input = e.target.parentNode.firstChild;
    let get_id;
    let get_anchor;
    console.log(get_input);
    if(get_input.tagName.toLowerCase() === "a"){
        get_anchor = get_input.nextSibling;
    }
    while(get_input.nextSibling){
        if(get_input.nextSibling.tagName.toLowerCase() === "input"){
            get_id = get_input.nextSibling.value;
        }
        if(get_input.nextSibling.tagName.toLowerCase() === "a"){
            console.log(get_input.nextSibling.tagName);
            get_anchor = get_input.nextSibling;
        }
        get_input = get_input.nextSibling;
    }
    let op;
    let jsonop;
    let urledit = 'http://localhost/Q_and_A_Aplication/api/post/editquestion.php';
    if(e.target.innerText === "Update"){  

        div = e.target.parentNode;
        console.log(div);
        for(i=0;i<div.children.length;i++){
            div.children[i].setAttribute('style', 'display: none;');
        }
        
        formEdit = document.createElement('form');
        formEdit.setAttribute('id', 'editquestion');
        formEdit.setAttribute('name', 'editquestion');

        inputQ = document.createElement('textarea');
        inputQ.setAttribute('name', 'inputQ');
        inputQ.setAttribute('id', 'inputQ');
        inputQ.value =  div.firstChild.innerText;

        formEdit.appendChild(inputQ);

        subBtn = document.createElement('button');
        subBtn.setAttribute('class', 'edit-btn');
        subBtn.innerText = "Update";

        let updated;
        formEdit.addEventListener('submit', (e)=>{
            e.preventDefault();
            div = e.target.parentNode.parentNode;
            updated = inputQ.value;
            let trimed = updated.replace(/\s+/g, ' ').trim();
            op = {op : "update", id: get_id, text : trimed};
            jsonop = JSON.stringify(op);
            console.log(jsonop);

            let request = new Request( urledit, {
                headers: header,
                body: jsonop,
                method: 'POST',
            });
            fetch(request)
                    .then((response) => response.json())
                    .then((data)=>{
                        console.log('Response from server');
                        if(data['message'] === "Question updated"){
                            showPopup("Question was updated");
                        }
                    })
            .catch(console.warn);
            setTimeout(() => {
                window.location.reload();    
            }, "3000");
        })
        formEdit.appendChild(subBtn);
        
        div.appendChild(formEdit);
        const textArea = document.getElementById("inputQ");
        for (let i = 0; i < textArea.length; i++) {
            textArea[i].setAttribute("style", "height: fit-content");
            textArea[i].addEventListener("input", OnInput, false);
        }
    } else {
        op = {op : "delete", id: get_id};
        jsonop = JSON.stringify(op);
        console.log(jsonop);
    
    let request = new Request( urledit, {
        headers: header,
        body: jsonop,
        method: 'POST',
    });
    await fetch(request)
            .then((response) => response.json())
            .then((data)=>{
                console.log('Response from server');
                if(data['message'] === "Question deleted"){
                    console.log("intra aici");
                    showPopup("Question and all the answers of the question were deleted");
                }
                else if(data['message'] === "Question updated"){
                    showPopup("Question was updated");
                }
            })
    .catch(console.warn);
    setTimeout(() => {
        window.location.reload();    
      }, "3000");
    }
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
        }
    })

    closeBtn = document.getElementById('close');
    closeBtn.addEventListener('click', function(e){
        popUp.style.display = "none";
        container.style.display = "none";
    })
}



function OnInput() {
    this.style.height = "auto";
    this.style.height = (this.scrollHeight) + "px";
  }



updateForm = document.getElementById('update');
hobbyForm = document.getElementById('hobby');
updateForm.setAttribute("style", "display: none;");
hobbyForm.setAttribute("style", "display: none;");

showUpdateForm = document.getElementById('showUpdateForm');
if(match === 0 ){
    showUpdateForm.setAttribute("style", "display: none;");
}else {
    showUpdateForm.addEventListener('click',()=>{
        if(updateForm.style.display === "none"){
            updateForm.removeAttribute("style", "display: none;");
            hobbyForm.removeAttribute("style", "display: none;");
        }else{
            updateForm.setAttribute("style", "display: none;");
            hobbyForm.setAttribute("style", "display: none;");
        }
    });
}


<!DOCTYPE html>
<?php
  include_once '../Q_and_A_Aplication/api/models/Session.php';

  $session = new Session();

?>

<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <meta name="keywords" content="project, infoiasi, web">
    <title>QAW - Scholarly HTML</title>
    <link rel="stylesheet" href="assets/css/about.css">
    <link rel="stylesheet" href="assets/css/navbar.css">
    <script src="assets/js/about.js"></script>
  </head>
  <?php
    
    echo 
    '<div id="topnav">
      <a  href="home.php">Home</a>
      <a href="contact.php">Contact</a>
      <a class="active" href="about.php">About</a>
      <a href="report.php">Report</a>';
      if(!isset($_SESSION['user_id'])){
        echo'
          <a style="float:right;" href="sign-up.php">Sign Up</a>
          <a style="float:right;" href="login.php">Log In</a>
        </div>';
      } else {
        if(isset($_SESSION['user_id'])){
          echo ' 
          <a style="float:right;" href="profile.php?username='.$_SESSION['user_id'] .'">Profile</a>
          <a style="float:right;" href="logout.php">Logout</a>
        </div>';
        } else{
          echo ' 
          <a style="float:right;" href="profile.php">Profile</a>
          <a style="float:right;" href="logout.php">Logout</a>
          </div>';
        }
      }
  ?>


  <body prefix="schema: http://schema.org">
    <header>
      <h1>Documentatie QAW (Q&As on Web)</h1>
    </header>
    <div role="contentinfo">
      <dl>
        <dt>Autori</dt>
        <dd typeof="sa:ContributorRole" property="schema:author">
          <span typeof="schema:Person">
            <meta property="schema:givenName" content="Bogdan">
            <meta property="schema:additionalName" content="Marius">
						<meta property="schema:familyName" content="Didea">
            <span property="schema:name">Didea Bogdan-Marius</span>
            <ul>
              <li property="schema:roleContactPoint" typeof="schema:ContactPoint">
                <a href="mailto:bogdan.didea@info.uaic.ro" property="schema:email">bogdan.didea@info.uaic.ro</a>
              </li>
            </ul>
          </span>
        </dd>

        <dd typeof="sa:ContributorRole" property="schema:author">
          <span typeof="schema:Person">
            <meta property="schema:givenName" content="Sebastian">
            <meta property="schema:additionalName" content="Petru">
            <meta property="schema:familyName" content="Drumia">
            <span property="schema:name">Drumia Sebastian Petru</span>
            <ul>
              <li property="schema:roleContactPoint" typeof="schema:ContactPoint">
              <a href="mailto:petru.sebastian@info.uaic.ro" property="schema:email">petru.sebastian@info.uaic.ro</a>
              </li>
            </ul>
          </span>
        </dd>

        <dd typeof="sa:ContributorRole" property="schema:author">
          <span typeof="schema:Person">
          <meta property="schema:givenName" content="Cosmin">
          <meta property="schema:additionalName" content="Andrei">
          <meta property="schema:familyName" content="Ciobotaru">
          <span property="schema:name">Ciobotaru Cosmin-Andrei</span>
            <ul>
              <li property="schema:roleContactPoint" typeof="schema:ContactPoint">
              <a href="mailto:cosmin.ciobotaru@info.uaic.ro" property="schema:email">cosmin.ciobotaru@info.uaic.ro</a>
              </li>
            </ul>
          </span>
        </dd>
      </dl>
    </div>
    <section typeof="sa:Abstract" id="abstract" role="doc-abstract">
      <h2>Cerință</h2>
      <p>
      Să se imagineze un sistem Web capabil sa gestioneze o serie de întrebări puse de utilizatori (anonimi ori autentificați prin nume de cont + parolă) și răspunsurile aferente oferite de diverse persoane (la rândul lor, anonime sau autentificate). 
       Fiecărui utilizator i se va asocia un profil conținând date personale, interese, posibilități de contact etc., plus o serie de calificative (badges) obținute pe baza activității în cadrul aplicației, acordate în mod automat
       -- e.g., persoana cea mai curioasă (a pus un număr mare de întrebări), utilizatorul altruist (răspunde la orice întrebare apărută), cel mai informat (oferă cele mai bune răspunsuri) etc.
       Utilizatorii autentificați care au oferit deja minim R răspunsuri vor putea accepta ori considera ca fiind nepotrivite intrebările/răspunsurile introduse.
       Apoi, prin vot, atât întrebările, cât și răspunsurile vor putea fi apreciate/depreciate.
       Unei întrebari i se vor putea asocia o categorie, plus maxim T termeni de conținut (tag-uri) ce pot fi folosiți ulterior pentru căutare.
       Aplicația va genera -- în formatele HTML, Atom si JSON -- rapoarte vizând activitățile desfăsurate într-un anumit interval de timp (e.g., ultima oră, zi, săptămână),
       privind o categorie de întrebări sau răspunsuri date de utilizatorii dintr-o arie geografică.
    </p>
    </section>
    <section id="introduction" role="doc-introduction">
      <h2>Introducere</h2>
      <p>
      Aplicațiile de tipul "forum online" sunt foarte des întâlnite, în prezent, mai ales în contextul
        trecerii în mediul online a majorității activităților. Oamenii au trecut
        tot mai mult la interacțiunea/informarea prin intermediul aplicațiilor/site-urilor, în defavoarea mijloacelor clasice de interacțiune/informare (chiar și ajutare reciprocă).
        <b>"Knowledge Bag"</b> (QAW) preia majoritatea funcțiilor unui site tip "forum online" clasic, adăugând posibilitatea generării de rapoarte referitoare la 
        activitatea de pe site, funcționalitate ce permite îmbunătățirea, prin studiul acestor rapoarte. De asemenea, în pagina de pornire a
        aplicației, orice utilizator poate vedea o listă a celor mai recente intrebări, lucru care ajută în obținerea de badge-uri sau obținerea 
        dreptului de a modifica întrebări/răspunsuri. De asemenea, această funcționalitate îl poate ajuta pe utilizator în găsirea mai rapidă a unui răspuns.
      </p>
      <p>
      <b>"Knowledge Bag"</b> (QAW) este o aplicație prin care utilizatorii sunt ajutați sa se informeze, permițând utilizatorului să își creeze cont, să adreseze întrebări
        din diverse categorii și să ajute la rândul său, prin a răspunde la alte întrebări deja existente pe site. De asemenea, utilizatorii pot adresa întrebări sau răspunde la întrebări
        în mod anonim. 
      </p>
      <p>
      Acesta poate vedea întrebarea și răspunsurile la aceasta în pagina întrebării. Pentru fiecare utilizator logat va fi disponibilă o pagină de profil, în care 
        se vor regăsi toate bagde-urile sale (calificative acordate în funcție de activitatea sa), cât și informații despre acesta. Un utilizator care a raspuns la mai multe
        întrebări și a pus mai multe întrebări, poate valida intrebări/răspunsuri.
      </p>
    </section>
    <section id="user-guide">
      <h2>Ghid de utilizare</h2>
      <p>
        Ghidul de utilizare al aplicației este disponibil <a href="ghid.php">aici</a>.
      </p>
    </section>
    <section id="architecture">
      <h2>Arhitectura aplicației</h2>
      <p>
      Din punct de vedere arhitectural, aplicația este bazată pe modelul bine cunoscut <i>MVC (Model-View-Controller)</i>, adaptat la utilizarea unui API. 
      Succesul modelului se datorează izolării logicii de bussines față de considerentele interfeței cu utilizatorul, 
      rezultând o aplicație unde aspectul vizual sau/și nivelele inferioare ale regulilor de bussines sunt mai ușor de modificat, fară a afecta alte nivele.
      </p>
      <p>  
      Astfel, o parte din conținutul din <i>View</i> este adăugată dinamic din JavaScript, care folosește AJAX pentru a cere datele necesare de la API; 
      <i>Modelele</i> oferă o serie de funcții pentru acces direct la baza de date, fiind folosite de către API pentru executarea operațiilor; 
      <i>Controllerele</i> sunt folosite conform modelului MVC tradițional, pentru randarea view-urilor. 
      </p>
      <p>
        O structurare în profunzime a aplicației este prezentată în secțiunile următoare.
      </p>
    </section>
    <section id="configuration">
      <h2>Configurarea aplicației</h2>
      <p>
        Pentru configurarea aplicației, folosim o serie de variabile de mediu ce conțin datele confidențiale despre aplicație, 
        cum ar fi credențialele pentru baza de date.
      </p>
      <p>
        Pentru lucrul local, variabilele de mediu sunt setate în fișierul api/config.
      </p>
    </section>
    <section id="appcomponents">
        <h3>Componentele aplicației</h3>
        <p>
        Principalele componente ale aplicație sunt: Fornt-End, Back-End și Baza de Date. Acestea vor fi detaliate după cum urmează.
      </p>
      <section id="frontend">
      <h2>Front-End</h2>
      <p>
      Aici ne referim la toată partea de client, <span typeof="ComputerLanguage"><span property="schema:name">JavaScript</span>/
       <span typeof="ComputerLanguage"><span property="schema:name">HTML</span>/ 
       <span typeof="ComputerLanguage"><span property="schema:name">CSS</span>. În această componentă se regăsesc toate cele ce 
       țin de aspectul și structura paginilor, dar și o parte de logică pentru diverse evenimente. Aducem și trimitem date către server
       constant deoarece în final site-ul are scopul de a prezenta răspunsurile la  întrebările puse de utilizatori.
      </p>
      </section>
      <section id="backend">
      <h2>Back-End</h2>
      <p>
        Toată logica aplicației. Partea de server este scrisă în <span typeof="ComputerLanguage"><span property="schema:name">PHP</span>. 
        Avem un server REST simplu, care expune o serie de rute. Avem o serie funcții utilitare care construiesc un răspuns dat, bazat pe datele 
        primite și pe datele extrase din baza de date. Back-End-ul procesează datele primite de la Front-End, oferinâd acestuia informații din baza de date.
      </p>
      </section>

      <section id="database">
      <h2>Baza de date</h2>
      <p>
        Pentru stocarea de date am folosit o bază de date MySQL. In aceasta sunt, de asemenea, stocate și procedurile ce sunt apelate de către Back-End. 
        În continuare vom prezenta structura tabelelor din această bază de date.
      </p>
      <section id="users-table">
        <h3>Tabela "Users"</h3>
        <!--<figure typeof="sa:image">
          <img src="">
          <figcaption>Fig. 1 - Structura tabelei Users</figcaption>
        </figure> -->
        <p>
          Această tabelă conține datele despre utilizatorii aplicației. La click pe butonul <i>Log in</i> de pe pagina 
          principală, utilizatorul va fi redirecționat spre pagina de <i>Log In</i> unde își va introduce username-ul și parola pentru a se 
          conecta. Dacă username-ul respectiv nu a fost introdus deja în tabelul "Users", se va afișa un mesaj de eroare, iar utilizatorul v-a trebui să 
          se înregistreze folosind butonul <i>Sign up</i>. Câmpul "id" va fi incrementat automant, câmpul "username" va reține numele utilizatorului, 
          câmpul "password" va fi criptat cu un hash, iar restul informațiilor ("firstname", "lastname", "email","description") vor fi 
          introduse în baza de date la câmpurile corespunzătoare.
        </p>
        <p>
          Cheia primară este campul "id", ce va juca și rol de cheie străină în celelalte tabele.
        </p>
      </section>
      <section id="questions-table">
        <h3>Tabela "Questions"</h3>
        <p>
          Această tabelă conține date despre întrebările ce au fost puse. Câmpul "id" este folosit la gestionarea întrebărilor, câmpul 
          "user" este folosit pentru a memora posesorul întrebării, câmpul "text" va fi folosit pentru memorarea propriu-zisă a întrebării, 
          câmpurile "created_at" și "updated_at" vor fi folosite pentru gestiunea 
          temporală a evenimentelor, iar câmpul "category" va fi folosit pentru memorarea categoriei întrebării.  
        </p>
        <p>
          Cheia primară este "id", ce va fi folosită ca și cheie străină pentru tabela "answers".
        </p>
        <figure typeof="sa:image">
          <img src="images\doc\questions.jpg">
          <figcaption>Fig. 2 - Structura tabelei Questions</figcaption>
        </figure> 
      </section>
      <section id="answers-table">
        <h3>Tabela "Answers"</h3>
        <p>
          Această tabelă conține date despre răspunsurile fiecărui utilizator la întrebările din baza de date.  
          Este inserată o intrare nouă atunci când utilizatorul adaugă un răspuns. Când un utilizator dă submit la 
          răspuns, este incrementat câmpul "id" și sunt completate celelalte câmpuri: "user" pentru a reține autorul răspunsului, 
          "question" pentru a reține întrebarea corespunzătoare, iar "created_at" si "updated_at" pentru informațiile legate de 
          data când au fost create sau actualizate întrebările.
        </p>
        <p>
          Cheia primară este "id".
        </p>
        <figure typeof="sa:image">
          <img src="images\doc\answers.jpg">
          <figcaption>Fig. 3 - Structura tabelei Answers</figcaption>
        </figure> 
      </section>
      <section id="categories-table">
        <h3>Tabela "Categories"</h3>
        <p>
          Acesată tabelă conține toate categoriile în care o întrebare poate fi încadrată. Câmpul "questions_count" va memora câte întrebări din fiecare categorie există.
        </p>
        <figure typeof="sa:image">
          <img src="images\doc\categories.jpg">
          <figcaption>Fig. 4 - Structura tabelei Categories</figcaption>
        </figure> 
      </section>
      <section id="reactions-table">
        <h3>Tabela "Reactions"</h3>
        <p>
          Acesată tabelă conține toate reacțiile, inclusiv <i>report</i>. În funcție de tipul reacției vor fi completate coloanele corespunzătoare. Câmpurile 
          "id_post" și "user" ajută la identificarea postării.
        </p>
        <figure typeof="sa:image">
          <img src="images\doc\reactions.jpg">
          <figcaption>Fig. 5 - Structura tabelei Reactions</figcaption>
        </figure> 
      </section>
      <section id="badges-table">
        <h3>Tabela "Badges"</h3>
        <p>
          Acesată tabelă conține badge-urile pe care un utilizator le poate debloca prin utilizarea site-ului. Câmpul "description" reține cerința pentru deblocarea acelui badge.
        </p>
        <figure typeof="sa:image">
          <img src="images\doc\badges.jpg">
          <figcaption>Fig. 6 - Structura tabelei Badges</figcaption>
        </figure> 
      </section>
      <section id="procedures">
        <h3>Proceduri</h3>
        <p>
          Acestea sunt procedurile pentru Prepared Statements.
        </p>
        <figure typeof="sa:image">
          <img src="images\doc\procedures.jpg">
          <figcaption>Fig. 7 - Proceduri</figcaption>
        </figure> 
      </section>
    </section>
    <section id="security">
        <h3>Securitate</h3>
        <p>
          Pentru a preveni SQL Injections, operațiile pe baza de date folosesc Prepared Statements.
        </p>
      </section>
    </section>
      
    
    <section id="rest-api">
      <h3>API</h3>
      <p>
        Aplicația se folosește de un API bazat pe REST, ce oferă avantajul unei experiențe mai bune pentru utilizator, nefiind necesar 
        refresh-ul paginii la postarea unei întrebări. Acest API se găsește in folderul "api", ce conține toată logica aplicației. Front-End-ul face cereri, 
        iar Back-End-ul le procesează, trimițând prin <span typeof="ComputerLanguage"><span property="schema:name">JavaScript</span> răspunsul înapoi.
      </p>
      <section id="rest-api-detalii-implementare">
        <h4>Detalii de implementare</h4>
        <p>
          Call-urile catre URL-uri sunt facute in JavaScript. Acestea se găsesc în folderul api/post, unde sunt implementate principalele funcționalități ale aplicației.
          Majoritatea funcționalitățile sunt realizate fără a se reîncărca pagina, acest lucru fiind posibil prin îmbinarea REST API-ului cu tehnologia AJAX, toate actualizările 
          făcându-se automat. Headerele pentru comunicarea cu clientul sunt setate la început, pentru rezolvarea CORS-ului și setarea tipului de conținut trimis peste http.
        </p>
        <p>
          De asemenea, tot API-ul face legătura cu baza de date prin fișierul api/config/Database.php, care contine toate datele de conectare la baza de date.
        </p>
        <p>
          Un exemplu de configurări (extras din api/config/Database.php):
        </p>
        <figure typeof="schema:SoftwareSourceCode">
          <pre>
            <code>
            class Database {
        private $host = 'localhost';
        private $db_name = 'q&a_app';
        private $username = 'root';
        private $password = '';
        private $conn;

        public function connect(){
            $this->conn = null;

            try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e) {
                echo 'Connection Error' . $e->getMessage();
            }
            return $this->conn;
        }
    }
            </code>
          </pre>
        </figure>
      </section>
    </section>
    <section id="interfata-cu-utilizatorul">
      <h3>Interfața cu utilizatorul</h3>
      <p>
        Așa cum am amintit și în <a href="#introduction">Introducere</a>, principala intenție este ca site-ul să fie cât mai atractiv, prietenos și intuitiv,  
        așa că am ales o temă simplă, stilul site-ului fiind unul familiar, asemănător cu majoritatea aplicațiilor web din acest segemnt.
        La încărcarea site-ului, utilizatorului îi sunt afișate întrebările recente și opținile pe care le are în ceea ce privește 
        autentificarea. De asemenea, acesta va avea acces și la celelalte pagini (About, pagina fiecărei întrebări, etc. ) și va putea răspunde la întrebări, 
        indiferent de statusul său (autentificat sau nu).
      </p>
      <section id="interfata-home-page">
        <h4>Pagina principală</h4>
        <!--<figure typeof="sa:image">
          <img src="">
          <figcaption>Fig. 8 - Pagina principala. </figcaption>
        </figure> --->
        <p>
          Această pagină reprezintă principalul punct în care se concentrează atenția utilizatorului, deoarece îi sunt afișate denumirea site-ului, sloganul site-ului, cele mai recente 
          întrebări, navbar-ul ce cuprinde toate butoanele necesare navigării. 
          Aspectul este foarte prietenos: în stânga și dreapta se vor afișa statistici privind întrebările și răspunsurile. 
          În cazul ecranelor înguste orientate portrait (de exemplu telefonul), vor fi afișate întrebările, iar statisticile nu vor mai apărea. 
        </p>
        <p>
          În cazul în care utilizatorul este logat, va apărea numele său și va avea acces la profil.
        </p>
        <!--<table>
          <tr>
            <td>
              <figure typeof="sa:image">
                <img src="">
                <figcaption>Fig. 9 - Statisitică stânga</figcaption>
              </figure>
            </td>
            <td>
              <figure typeof="sa:image">
                <img src="">
                <figcaption>Fig. 10 - Statistică dreapta</figcaption>
              </figure>
            </td>
          </tr>
        </table> -->
      </section>
      <section id="interfata-pagina-login">
        <h4>Pagina de autentificare</h4>
        <p>
          Aceasta este pagina de autentificare, unde utilizatorului îi sunt afișate un formular în care își completează datele și un buton de logare.
          Aspectul este foarte minimalist: în partea centrală este concentrată toată atenția. 
        </p>
        <figure typeof="sa:image">
          <img src="images\doc\auth.jpg">
          <figcaption>Fig. 11 - Pagina de autentificare</figcaption>
        </figure>
        <p>
          Codul pentru trimiterea formularului din pagina de autentificare:
        </p>
        <figure typeof="schema:SoftwareSourceCode">
          <pre>
            <code>
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/json');
            header('Access-Control-Allow-Methods: POST');
            header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Autorization, X-Requested-With');

            include_once '../../api/config/Database.php';
            include_once '../../api/models/User.php';
            include_once '../../api/models/Session.php';

            $database = new Database();
            $db = $database->connect();

            $user = new User($db);

            $data = json_decode(file_get_contents("php://input"));

            if($data->username == ''){
                $user->email = $data->email;
            } else {
                $user->username = $data->username;
            }
            $user->password = $data->password;

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $user = $user->loginuser();
                $session = new Session();
                $session->login($user);
            }
            </code>
          </pre>
        </figure>
      </section>
      <section id="interfata-sign-up">
        <h4>Pagina de înregistrare</h4>
        <p>
        Aceasta este pagina de înregistrare, unde utilizatorului îi este afișat un formular în care completează datele și un buton de submit.
        Aspectul este foarte minimalist: în partea centrală este concentrată toată atenția.
        </p>
        <figure typeof="sa:image">
          <img src="images/doc/signup.jpg">
          <figcaption>Fig. 13 - Pagina de autentificare</figcaption>
        </figure>
        <figure typeof="schema:SoftwareSourceCode">
          <pre>
            <code>
              public function create() {
            
            $stmt = $this->conn->prepare("CALL used_username(:username, :email)");

            $stmt->bindParam(':username', $this->username, PDO::PARAM_STR);
            $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);

            $stmt->execute();
            $count = 0;
            while ($stmt->fetch())
            {
                $count++;
            }

            if($count != 0){
                echo json_encode(array('message' => 'Username or email already in use'));
                return false;
            }

            $stmt = $this->conn->prepare("CALL create_user(:username, :password, :firstname, :lastname, :email)");
            
            $stmt->bindParam(':username', $this->username, PDO::PARAM_STR);
            $stmt->bindParam(':password', $this->password, PDO::PARAM_STR);
            $stmt->bindParam(':firstname', $this->firstname, PDO::PARAM_STR);
            $stmt->bindParam(':lastname', $this->lastname, PDO::PARAM_STR);
            $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
            
            if($stmt->execute()){
                echo json_encode(array('message'=> 'Account created'));
                return $this->username;
            } else {
                printf("ERROR: %s. \n", $stmt->error);
                echo json_encode(array('message'=> 'User Not Created'));
                return false;
            }
        }
            </code>
          </pre>
        </figure>
      </section>
      <section id="interfata-intrebare">
        <h4>Pagina unei întrebări</h4>
        <p>
          Odată ajunși la pagina unei întrebări putem observa că vor apărea toate răspunsurile pentru acea întrebare.
        </p>
        <!-- <figure typeof="sa:image">
          <img src="" width="790">
          <figcaption> Fig. 14 - Pagina pagina unei întrebări</figcaption>
        </figure> -->
        <p>
          Întrebarea va fi prima afișată și va fi marcată cu portocaliu, iar răspunsurile vor fi marcate cu un chenar albastru fiecare.
        </p>
      </section>
      <section id="interfata-profil">
        <h4>Pagina de profil</h4>
        <!-- <figure typeof="sa:image">
          <img src="">
          <figcaption>Fig. 15 - Pagina Profile</figcaption>
        </figure> -->
        <p>Pagina de profil afișează diverse informații despre utilizator și anume:</p>
        <ul>
          <li>informațiile despre utilizator</li>
          <li>
            numărul de întrebări puse
          </li>
          <li>numărul de răspunsuri date</li>
          <li>badge-urile obținute</li>
          <li>posibiltatea de actualiza informațiile despre acesta</li>
        </ul>
      </section>
      <section id="interfata-contact">
        <h4>Pagina de contact</h4>
        <figure typeof="sa:image">
          <img src="images/doc/contact.jpg">
          <figcaption>Fig. 16 - Pagina Contact</figcaption>
        </figure>
        <p>Pagina de contact afișează un formular prin care utilizatorul poate lasa sugestii, nemulțumiri și alte informații ce vor ajuta la îmbunătățirea site-ului.</p>
      </section>

    </section>
    <section id="github">
      <h3>Version control</h3>
      <p>
        Ca sistem de version control, am folosit GitHub. În cazul de față, git-ul este utilizat pentru a oferi acces la codul sursa. Fiecare a lucrat pe branch-urile sale, iar la 
        final s-a făcut merge pe branch-ul main.
      </p>
    </section>

    <section id="biblio-references">
      <h3>Referinte</h3>
        <ul>
          <li property="schema:linkReferences" typeof="schema:References">
            <a href="https://profs.info.uaic.ro/~busaco/teach/courses/web/web-projects.html" property="schema:linkTW" target="_blank">Pagina Cursului</a>
          </li>

          <li property="schema:linkReferences" typeof="schema:References">
            <a href="https://www.w3schools.com/" property="schema:linkTW" target="_blank">W3School</a>
          </li>

          <li property="schema:linkReferences" typeof="schema:References">
            <a href="https://developer.mozilla.org/en-US/" property="schema:linkTW" target="_blank">Mozilla Developer</a>
          </li>
        <li property="schema:linkReferences" typeof="schema:References">
            <a href="https://stackoverflow.com" property="schema:linkTW" target="_blank">Stackoverflow</a>
        </ul>
    </section>

    <button onclick="topFunction()" id="topBtn">Top</button>
    <script type="text/javascript" src="assets/js/scripts.js"></script>
    
  </body>
</html>

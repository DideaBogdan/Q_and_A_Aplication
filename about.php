<!DOCTYPE html>
<?php
  include_once '../Q_and_A_Aplication/api/models/Session.php';

  $session = new Session();

?>

<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
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
          câmpul "password" va fi cripatata cu un hash, iar restul informațiilor ("firstname", "lastname", "email","description") vor fi 
          introduse în baza de date la câmpurile corespunzătoare.
        </p>
        <p>
          Cheia primară este campul "id", ce va juca și rol de cheie străină în celelalte tabele.
        </p>
      </section>
      <section id="questions-table">
        <h3>Tabela "Questions"</h3>
        <figure typeof="sa:image">
          <img src="images\doc\questions.jpg">
          <figcaption>Fig. 2 - Structura tabelei Questions</figcaption>
        </figure> 
        <p>
          Această tabelă conține date despre întrebările ce au fost puse. Câmpul "id" este folosit la gestionarea întrebărilor, câmpul 
          "user" este folosit pentru a memora posesorul întrebării, câmpul "text" va fi folosit pentru memorarea propriu-zisă a întrebării, 
          câmpurile "created_at" și "updated_at" vor fi folosite pentru gestiunea 
          temporală a evenimentelor, iar câmpul "category" va fi folosit pentru memorarea categoriei întrebării.  
        </p>
        <p>
          Cheia primară este "id", ce va fi folosită ca și cheie străină pentru tabela "answers".
        </p>
      </section>
      <section id="answers-table">
        <h3>Tabela "Answers"</h3>
        <figure typeof="sa:image">
          <img src="images\doc\answers.jpg">
          <figcaption>Fig. 3 - Structura tabelei Answers</figcaption>
        </figure> 
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
      </section>
      <section id="categories-table">
        <h3>Tabela "Categories"</h3>
        <!--<figure typeof="sa:image">
          <img src="">
          <figcaption>Fig. 4 - Structura tabelei Categories</figcaption>
        </figure> -->
        <p>
          Acest tabel conține toate categoriile in care o intrebare poate fi incadrata.
        </p>
      </section>
      <section id="security">
        <h3>Securitate</h3>
        <p>
          Pentru a preveni SQL Injections, operațiile pe baza de date folosesc Prepared Statements.
        </p>
      </section>
    </section>
        
    </section>
      
    
    <section id="rest-api">
      <h3>REST API <b> DE COMPLETAT!!</b></h3>
      <p>
        Aplicația se folosește de un API REST, ce oferă avantajul unei experiențe mai bune pentru utilizator, nefiind necesar 
        refresh-ul paginii la postarea unei intrebari.
      </p>
      <section id="rest-api-detalii-implementare">
        <h4>Detalii de implementare</h4>
        <p>
          Call-urile catre URL-uri sunt facute in JavaScript.
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
        Așa cum am amintit și în <a href="#introduction">Introducere</a>, am dorit ca site-ul să fie cât mai atractiv, prietenos și intuitiv,  
        asa ca am ales o tema simpla, stilul site-ului fiind unul familiar, asemanator cu majoritatea aplicatiilor web din acest segemnt.
        La încărcarea site-ului, utilizatorului îi sunt afișate intrebarile recente si optinile pe care le are in ceea ce priveste 
        autentificarea. De asemenea, acesta va avea acces și la celelalte pagini (About, pagina fiecarei intrebari, etc. ) si va putea raspunde la intrebari, 
        indiferent de statusul sau (autentificat sau nu).
      </p>
      <section id="interfata-home-page">
        <h4>Pagina principala</h4>
        <!--<figure typeof="sa:image">
          <img src="">
          <figcaption>Fig. 5 - Pagina principala. </figcaption>
        </figure> --->
        <p>
          Aceasta este pagina princiapala, unde utilizatorului îi sunt afișate denumirea aplicației, sloganul site-ului, cele mai recente 
          intrebari, navbar-ul ce cuprinde toate butoanele necesare navigarii. 
          Aspectul este foarte prietenos: în stânga și dreapta se vor afișa statistici privind intrebarile si raspunsurile, 
          În cazul ecranelor înguste orientate portrat (de exemplu, telefonul), vor fi afisate intrebarile, iar statisticile vor aparea in partea de jos. 
        </p>
        <p>
          În cazul în care utilizatorul este logat, va aparea numele sau si va avea acces la profil.
        </p>
        <!--<table>
          <tr>
            <td>
              <figure typeof="sa:image">
                <img src="">
                <figcaption>Fig. 6 - Statisitica</figcaption>
              </figure>
            </td>
            <td>
              <figure typeof="sa:image">
                <img src="img/hamburger.png">
                <figcaption>Fig. 7 - Statistica</figcaption>
              </figure>
            </td>
          </tr>
        </table> -->
      </section>
      <section id="interfata-pagina-login">
        <h4>Pagina de autentificare</h4>
        <!--<figure typeof="sa:image">
          <img src="">
          <figcaption>Fig. 8 - Pagina de autentificare</figcaption>
        </figure> --->
        <p>
          Aceasta este pagina de autentificare, unde utilizatorului îi sunt afișate un formular in care isi completeaza datele si un buton de logare.
          Aspectul este foarte minimalist: in partea centrala este concentrata toata atentia. 
        </p>
        <!--<figure typeof="sa:image">
          <img src="img/application-login.png">
          <figcaption>Fig. 9 - Pagina de autentificare</figcaption>
        </figure> 
        <p>
          Codul pentru trimiterea formularului din pagina de autentificare:
        </p>
        <figure typeof="schema:SoftwareSourceCode">
          <pre>
            <code>
            </code>
          </pre>
        </figure> -->

      </section>
      <section id="interfata-sign-up">
        <h4>Pagina de inregistrare</h4>
        <p>
        Aceasta este pagina de inregistrare, unde utilizatorului îi este afișat un formular in care completeaza datele si un buton de submit.
        Aspectul este foarte minimalist: in partea centrala este concentrata toata atentia.
        </p>
        <!--<figure typeof="sa:image">
          <img src="">
          <figcaption>Fig. 10 - Pagina de autentificare</figcaption>
        </figure> -->
        
        <!--<figure typeof="schema:SoftwareSourceCode">
          <pre>
            <code>
            </code>
          </pre>
        </figure> -->

      </section>
      <section id="interfata-intrebare">
        <h4>Pagina unei intrebari</h4>
        <p>
          Odată ajunși la pagina unei intrebari putem observa că vor aparea toate raspunsurile pentru acea intrebare.
        </p>
        <!-- <figure typeof="sa:image">
          <img src="" width="790">
          <figcaption> Fig. 11 - Pagina pagina unei intrebari</figcaption>
        </figure> -->
        <p>
          Intrebarea va fi prima afisata si va fi marcata cu un chenar portocaliu, iar raspunsurile vor fi marcate cu un chenar albastru fiecare.
        </p>
      </section>
      <section id="interfata-profil">
        <h4>Pagina de profil</h4>
        <!-- <figure typeof="sa:image">
          <img src="">
          <figcaption>Fig. 14 - Pagina Profile</figcaption>
        </figure> -->
        <p>Pagina de profil afișează diverse informații despre utilizator și anume:</p>
        <ul>
          <li>
            imaginea de profil care <b>( generate cu ajutorul API-ului de la <a href="http://avatars.adorable.io" target="_blank" rel="noopener noreferrer">Adorable
            Avatars</a> ) </b>
          </li>
          <li>numele de utilizator</li>
          <li>
            numarul de intrebari puse
          </li>
          <li>numarul de raspunsuri date</li>
          <li>badge-urile obtinute</li>
        </ul>
        <!-- <p>
          Codul pentru afișarea informațiilor în pagină:
        </p>
        <figure typeof="schema:SoftwareSourceCode">
          <pre>
            <code>
            </code>
          </pre>
        </figure> --> 
      </section>
    </section>
    <section id="deployment-and-github">
      <h3>Version control și deployment</h3>
      <p>
        Ca sistem de version control, am folosit GitHub In cazul de fata, git-ul este utilizat pentru a oferi acces la codul sursa. .
      </p>
      <p>
        <b>(Atât baza de date, cât și site-ul sunt găzduite pe Heroku.) Site-ul poate fi accesat <a href="home.php">aici</a>.
        Ca metodă de deploy, am folosit deploy automat de pe branch-ul main de pe GitHub. Noi am lucrat pe branch-uri separate, 
        iar la adăugarea unui feature nou se facea pull request și merge pe main.
      </p>
    </section>

    <section id="biblio-references">
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

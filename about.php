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
      <a class="active" href="about.php">About</a>';
      if(!isset($_SESSION['user_id'])){
        echo'
          <a style="float:right;" href="sign-up.php">Sign Up</a>
          <a style="float:right;" href="login.php">Log In</a>
        </div>';
      } else {
        echo ' 
          <a style="float:right;" href="profile.php">Profile</a>
          <a style="float:right;" href="logout.php">Logout</a>
        </div>';
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
      Sa se imagineze un sistem Web capabil sa gestioneze o serie de intrebari puse de utilizatori (anonimi ori autentificati prin nume de cont + parola) si raspunsurile aferente oferite de diverse persoane (la randul lor, anonime sau autentificate). 
       Fiecarui utilizator i se va asocia un profil continand date personale, interese, posibilitati de contact etc., plus o serie de calificative (badges) obtinute pe baza activitatii in cadrul aplicatiei, acordate in mod automat
       -- e.g., persoana cea mai curioasa (a pus un numar mare de intrebari), utilizatorul altruist (raspunde la orice intrebare aparuta), cel mai informat (ofera cele mai bune raspunsuri) etc.
       Utilizatorii autentificati care au oferit deja minim R raspunsuri vor putea accepta ori considera ca fiind nepotrivite intrebarile/raspunsurile introduse.
       Apoi, prin vot, atat intrebarile, cat si raspunsurile vor putea fi apreciate/depreciate.
       Unei intrebari i se vor putea asocia o categorie, plus maxim T termeni de continut (tag-uri) ce pot fi folositi ulterior pentru cautare.
       Aplicatia va genera -- in formatele HTML, Atom si JSON -- rapoarte vizand activitatile desfasurate intr-un anumit interval de timp (e.g., ultima ora, zi, saptamana),
       privind o categorie de intrebari sau raspunsuri date de utilizatorii dintr-o arie geografica.
    </p>
    </section>
    <section id="introduction" role="doc-introduction">
      <h2>Introducere</h2>
      <p>
      Aplicatiile de tipul "forum online" sunt foarte des intalnite, in prezent, mai ales in contextul
        trecerii in mediul online a majoritatii activitatilor. Oamenii au trecut
        tot mai mult la interactiunea/informarea prin intermediul aplicatiilor/site-urilor in defavoarea mijloacelor clasice de interactiune/informare (chiar si ajutare reciproca).
        QAW preia majoritatea functiilor unui site tip "forum online" clasic, adaugand posibilitatea generarii de rapoarte referitoare la o arie geografica 
        sau la o anumita categorie de intrebari, functionalitate ce permite imbunatatirea prin studiul acestor rapoarte. De asemenea, in pagina de pornire a
        aplicatiei, orice utilizator poate vedea o lista a celor mai recente intrebari, lucru care poate sa il ajute in obtinerea de badge-uri sau obtinerea 
        dreptului de a modifica intreabri/raspunsuri. De asemenea, aceasta functionalitate il poate ajuta pe utilizator in gasirea mai rapida a unui raspuns.
      </p>
      <p>
      QAW este o aplicatie de tip "forum online", ce permite utilizatorului sa isi creeze cont, sa adreseze intrebari
        din diverse categorii si sa raspunda la alte intrebari deja existente pe site. De asemenea utilizatorii pot adresa intrebari sau raspunde la intrebari
        in mod anonim. 
      </p>
      <p>
      Acesta poate vedea intrebare si raspunsurile in pagina intreabrii. Pentru fiecare utilizator logat va fi disponibila o pagina de profil, in care 
        se vor regasi toate bagde-urile sale (calificative acordate in functie de activitatea sa), cat si informatii despre acesta. Un utilizator care a raspuns la mai multe
        intrebari, poate valida intreabri/raspunsuri.
      </p>
    </section>
    <section id="user-guide">
      <h2>Ghid de utilizare</h2>
      <p>
        Ghidul de utilizare al aplicatiei este disponibil <a href="ghid.php">aici</a>.
      </p>
    </section>
    <section id="architecture">
      <h2>Arhitectura aplicației</h2>
      <p>
      Din punct de vedere arhitectural, aplicatia este bazata pe modelul bine cunoscut MVC (Model-View-Controller), adaptat la utilizarea unui API.
        Succesul modelului se datoreaza izolarii logicii de bussines fata de considerentele interfetei cu utilizatorul,
        rezultand o aplicatie unde aspectul vizual sau/si nivelele inferioare ale regulilor de bussines sunt mai usor
        de modificat, fara a afecta alte nivele.
      </p>
      <p>  
      Astfel, o parte din conținutul din View este adăugat dinamic din JavaScript, 
        care folosește Ajax pentru a cere datele necesare de la API; Modelele oferă o serie de funcții pentru acces direct la baza de date, 
        fiind folosite de către API pentru executarea operațiilor; Controllerele sunt folosite conform modelului MVC tradițional, 
        pentru randarea view-urilor.
        O structurare in profunzime a aplicatiei sunt prezentate in sectiunile urmatoare.
      </p>
    </section>
    <section id="configuration">
      <h2>Configurarea aplicației</h2>
      <p>
        Pentru configurarea aplicației, folosim o serie de variabile de mediu ce conțin datele confidențiale despre aplicație, 
        cum ar fi credențialele pentru baza de date.
      </p>
      <p>
        Pentru lucrul local, variabilele de mediu sunt setate în fișierul api/config. <b>(!!!!!!!!!În mediul de deploy, aceste variabile 
        de mediu sunt setate din setările proiectului pe Heroku.) </b>
      </p>
    </section>
    <section id="appcomponents">
        <h3>Componentele Aplicatiei</h3>
        <p>
        Principalele componente ale aplicatie sunt: Fornt-End, Back-End si Baza de Date. Acestea vor fi detaliate dupa cum urmeaza.
      </p>
      <section id="frontend">
      <h2>Front-End</h2>
      <p>
      Aici ne referim la toata partea de client, <span typeof="ComputerLanguage"><span property="schema:name">JavaScript</span>/
       <span typeof="ComputerLanguage"><span property="schema:name">HTML</span>/ 
       <span typeof="ComputerLanguage"><span property="schema:name">CSS</span>. In aceasta componenta se regasesc toate cele ce 
       tin de aspectul si structura paginilor, dar si o parte de logica pentru diverse evenimente. Aducem si trimitem date catre server
       constant deoarece in final site-ul are
       scopul de prezenta raspunsurile la  intreabrile puse de utilizatori.
      </p>
      </section>
      <section id="backend">
      <h2>Back-End</h2>
      <p>
        Toata logica aplicatiei. Partea de server este scrisa in <span typeof="ComputerLanguage"><span property="schema:name">PHP</span>. 
        Avem un server REST simplu, care expune o serie de rute. Avem o functii utilitare care construiesc un raspuns dat, bazat pe datele 
        primite si pe datele extrase din baza de date.<b> DE COMPLETAT!!</b>
      </p>
      </section>

      <section id="database">
      <h2>Baza de date</h2>
      <p>
        Pentru stocarea de date am folosit o bază de date MySQL <b>(găzduită pe Heroku, același mediu în care am făcut
        deploy)</b>. Acest lucru a simplificat mult și lucrul local la proiect, nefiind nevoie ca membrii echipei să
        introducă manual datele. În continuare vom prezenta structura tabelelor din această bază de date.
      </p>
      <section id="users-table">
        <h3>Tabela "Users"</h3>
        <!--<figure typeof="sa:image">
          <img src="">
          <figcaption>Fig. 1 - Structura tabelei Users</figcaption>
        </figure> -->
        <p>
          Aceasta tabela conține datele despre utilizatorii aplicației. La click pe butonul Log in de pe pagina 
          principala, utilizatorul va fi redirectionat spre pagina de Log In unde isi va introduce andresa de username-ul si parola pentru a se 
          conecta. Dacă username-ul respectiv nu a fost introdus deja în tabelul Users, se va afisa un mesaj de eroare, iar utilizatorul v-a trebui sa 
          se inregistreze folosind butonul Sign up. Câmpul "id" va fi incrementat automant, campul "username" va retine numele utilizatorului 
          campul "password" va fi cripatata cu un hash, iar restul informatiilor ("firstname", "lastname", "email" ) vor fi 
          introduse in baza de date la campurile corespunzatoarea.
        </p>
        <p>
          Cheia primara este campul "id", ce va juca si rol de cheie straina in celelalte tabele.
        </p>
      </section>
      <section id="questions-table">
        <h3>Tabela "Questions"</h3>
        <!--<figure typeof="sa:image">
          <img src="">
          <figcaption>Fig. 2 - Structura tabelei Questions</figcaption>
        </figure> -->
        <p>
          Aceastaa tabela conține date despre intrebarile ce au fost puse. Câmpul "id" este folosit la gestionarea intrebarilor, campul 
          "user" este folost pentru a memora posesorul intrebarii, campul "text" va fi folosit pentru memorarea propriu-zisa a intrebarii, 
          campurile "created_at" si "updated_at" vor fi folosite pentru gestiunea 
          temporala a evenimentelor, iar campul "category" va fi folosit pentru memorarea categoriei intrebarii.  
        </p>
        <p>
          Cheia primara este "id", ce va fi folosita ca si cheie straina pentru tabela "answers".
        </p>
      </section>
      <section id="answers-table">
        <h3>Tabela "Answers"</h3>
        <!--<figure typeof="sa:image">
          <img src="">
          <figcaption>Fig. 3 - Structura tabelei Answers</figcaption>
        </figure> -->
        <p>
          Aceasta tabela conține date despre raspunsurile fiecărui utilizator la intrebarile din baza de date.  
          Este inserată o intrare nouă atunci când utilizatorul adauga un raspuns. Când un utilizator dă submit la 
          raspuns, este incrementat câmpul "id" si sunt completate celelalte campuri: "user" pentru a retine autorul raspunsului, 
          "question" pentru a retine intrebarea corespunzatoare, iar "created_at" si "updated_at" pentru informatiile legate de 
          data cand au fost create sau actualizate intrebarile.
        </p>
        <p>
          Cheia primara este "id".
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

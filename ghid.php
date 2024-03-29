<!DOCTYPE html>
<?php
  include_once '../Q_and_A_Aplication/api/models/Session.php';

  $session = new Session();

?>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>QAW - Ghid utilizator</title>
    <link rel="stylesheet" href="assets/css/about.css">
    <link rel="stylesheet" href="assets/css/navbar.css">
    <script src="assets/js/about.js"></script>
  </head>
  <!--Nav bar-->
  <?php
    
    echo 
    '<div id="topnav">
      <a href="home.php">Home</a>
      <a href="contact.php">Contact</a>
      <a href="about.php">About</a>';
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
      <h1>QAW - Ghidul Utilizatorului</h1>
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
      <dt>Licență</dt>
        <dd>
          <a href="https://opensource.org/licenses/MIT">MIT</a>
        </dd>
    </div>
    <section id="user-authentication">
        <h2>Inregistrarea</h2>
        <p>
          Pentru a accesa anumite functionalitati, este necesara inregistrarea, aceasta facandu-se apasand pe butonul <i>Sign Up</i>
          care va redirecta utilizatorul catre pagina de inregistrare, unde va trebui sa completeze un formular. Dupa completarea datelor, 
          utilizatorul va apasa butonul de <i>Sign Up</i> si va fi conectat automat.
        </p>
      </section>

    <section id="connecting">
      <h2>Conectarea</h2>
      <section id="user-connection">
        <h3>Conectarea pentru utilizatori ce nu sunt inregistrarti</h3>
        <p>
          Utilizatorii ce nu au un cont creat, nu trebuie sa se conecteze; ei doar vor utiliza aplicatia pentru a pune si/sau raspunde 
          la intrebari in mod anonim. Acestia vor avea acces la pagina principala cu intrebari si la celelalte pagini (exclusa fiind pagina de profil).
        </p>
      </section>
      <section id="user-connection-aut">
        <h3>Conectarea pentru utilizatori ce sunt inregistrarti</h3>
        <p>
          Utilizatorii ce au un cont, vor apasa pe butonul <i>Log In</i> aflat in dreapta sus. Acestia vor fi redirecționați catre pagina 
          de login, unde vor trebui sa introduca datele necesare accesarii contului. Dupa apasarea butonului <i>Log In</i> acesata va fi redirectat 
          la pagina principala, unde ii vor aparea intrebarile la care poate raspunde, optiunea de a pune intrebari, numele de utilizator si un buton pentru accesarea 
          profilului.
        </p>
      </section>
    </section>

    <section id="profile">
      <h2>Pagina de profil</h2>
        <p>
          Aceasta pagina poate fi accesata prin apasarea butonului <i>Profile</i> sau prin apasarea pe numele unui utilizator. Va contine informatii cu privire 
          la utilizator; de asemenea tot din aceasta pagina se vor putea modifica anumite date ce tin de profilul acestuia.
        </p>
    </section>

    <section id="main-menu">
      <h2>Meniul principal</h2>
      <p>
        După autentificare, veți fi redirecționați către pagina principala. În partea de sus a paginii se regășește meniul de navigare, 
        cu câte un buton ce reprezintă o legătură pentru fiecare din paginile site-ului. Butonul corespunzător paginii curente 
        va fi evidențiat cu un fundal albastru (pentru butoanele din dreapta) sau portocaliu (pentru butoanele din stanga). 
        De asemenea vor aparea statisticile, lucru comun celor doua tipuri de utilizatori. 
      </p>
      <p>
        Butoanele din meniul principal vor insoti utilizatorul pe tot parcursul utilizarii aplicatiei si funcționează astfel: 
      </p>
      <ul>
        <li>
          <i>Home</i> - redirectioneaza catre pagina principala a site-ului; aici sunt afisate statisticile, intrebarile frecvente, numele utilizatorului (dupa caz). Tot 
          aici se gaseste si butonul de adaugat intrebari, iar fiecare intrebare are buton pentru a raspunde. 
        </li>
        <li>
          <i>Contact</i> - redirectioneaza catre pagina de contact, unde se gaseste un formular (prin care se vor trimite anumite informatii referitoare la site si alte aspecte 
          ce trebuie cunoscute de administratori); de asemenea, tot aici se gasesc datele de contact (email, numar de telefon).
        </li>
        <li>
          <i>About</i> - redirectioneaza catre pagina Documentatie; de asemenea tot aici, la sectiunea <i>Ghide de utilizare</i> se gaseste o scurta descriere a modului de 
          utilizare al site-ului.
        </li>
        <li>
          <i>Report</i> - redirectioneaza catre pagina Report, unde se regaseste o modalitate de a genera rapoarte dupa anumite criterii.
        </li>
        <li>
          <i>Log In</i> - redirectioneaza catre pagina de login, unde, dupa completarea username-ului si a parolei, utilizatorul se va autentifica pe site.
        </li>
        <li>
          <i>Log Out</i> (daca utilizatorul este conectat) - inlocuieste butonul de <i>Log In</i>. Deconecteaza utilizatorul, mentinand pagina principala cu intrebari.
        </li>
        <li>
          <i>Sign Up</i> redirectioneaza catre pagina de signup, unde utilizatorul isi poate crea un cont nou.
        </li>
        <li>
          <i>Profile</i> (daca utilizatroul este conectat) - inlocuieste butonul de <i>Sign Up</i>. Redirectioneaza catre pagina de profil al fiecarui user.
        </li>
      </ul>
    </section>
    <section id="disconnecting">
      <h2>Deconectarea</h2>
      <p>
        Pentru a vă deconecta de pe site, se va apasa pe butonul <i>Log Out</i> aflat in dreapta sus, in meniul de navigare (topnav-ul) al site-ului. 
      </p>
    </section>
    <section id="practicing">
      <h2>Postarea unei intrebari</h2>
      <p>
        Postarea unei intrebari nu depinde de statutul utilizatorului (conectat sau anonim). Aceasta se face astfel: se apasa butonul <i>Ask question</i> care va deschide un 
        un formular unde se regasesc doua campuri de completat si anume: categoria si intrebarea propriu-zisa. Dupa completarea acestui formular, se apasa pe butonul <i>Submit</i>. 
        Intrebarea va aparea prima in lista de intrebari afisata pe pagina principala.
      </p>
    </section>
    <section id="answer">
      <h2>Raspsunurile pentru intrebari</h2>
      <p>
      Pentru a raspunde la o intrebare trebuie apasat pe aceasta, iar utilizatorul va fi redirectionat catre pagina intrebarii. Aici vor aparea toate raspunsurile pe care acea intrebare 
      le-a primit. De asemenea, va aparea si un formular in care se va introduce raspunsul. Dupa introducerea raspunsului, se va apasa butonul <i>Submit</i>, iar raspunsul va aparea 
      primul in lista de raspunsuri.
      </p>

    </section>
      <section id="score">
        <h2>Like-uri, Dislike-uri, Report-uri</h2>
        <p>
        Atat intrebarile cat si raspunsurile pot primi 3 reactii: like, dislike si report, cea din urma fiind specifica doar utilizatorilor cu drept de "admin". Like-urile si dislike-urile 
        pot fi date cu conditia de a fi logat pe site, in caz contrar va aparea un pop-up. 
        </p>
        <p>
          De mentionat faptul ca la un anumit numar de raportari, intrebarea/raspunsul vor fi sterse automat, considerandu-se nepotrivite de catre utilizatorii cu drept de "admin".
        </p>
      </section>

      <section id="badges">
        <h2>Badge-urile utilizatorilor</h2>
      <p>
      Aceste badge-uri sunt folosite pentru motivarea utilizatorilor. Sunt oferite in mod automat la indeplinirea anumitor criterii, ce sunt specificate daca se pozitioneaza cursorul 
      mouse-ului deasupra badge-ului respectiv.
      </p>
      </section>

      <section id="search">
        <h2>Cautarea unei intrebari</h2>
      <p>
      Aceasta se face cu ajutorul search bar-ului din pagina principala.
      </p>
      </section>


    <button onclick="topFunction()" id="topBtn">Top</button>
    <script type="text/javascript" src="assets/js/scripts.js"></script>

  </body>
  
</html>

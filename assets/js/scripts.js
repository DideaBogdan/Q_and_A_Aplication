const topNav = document.getElementById("topnav");
const topNavChildren = [...topNav.children];

topNavChildren.forEach(child => {
  child.addEventListener("click", () => {
    removeActiveClassFromNavbar();

    child.classList.add("active");
  });
});

const removeActiveClassFromNavbar = () => {
  topNavChildren.forEach(child => child.classList.remove("active"));
}


//UpButton
  var mybutton = document.getElementById("topBtn");
  window.onscroll = function() {scrollFunction()};
  function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
      mybutton.style.display = "block";
    } else {
      mybutton.style.display = "none";
    }
  }
  function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
  }


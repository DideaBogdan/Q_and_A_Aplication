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
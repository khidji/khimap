// HEADER (STICKY CLASS)
// quand l'utilisateur scroll et que le haut de la page arrive au niveau du menu, celui ci prend la class sticky

window.onscroll = function() {myFunction()};

var header = document.getElementById("menu");

var sticky = header.offsetTop;

function myFunction() {
  if (window.pageYOffset > sticky) {
    header.classList.add("sticky");
  } else {
    header.classList.remove("sticky");
  }
}
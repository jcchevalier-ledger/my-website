window.onscroll = function () {
    add_sticky();
};

var navbar = document.getElementById("navbar");
var aboutme = document.getElementById("about-me");

function add_sticky() {

    if (window.pageYOffset >= aboutme.offsetTop - navbar.offsetTop) {
        navbar.classList.add("sticky-top");
    } else {
        navbar.classList.remove("sticky-top");
    }
}

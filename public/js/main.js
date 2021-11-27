//Navbar buttons dynamics
$(document).ready(function() {
    $(".button-close").click(function() {
        $(".sidebar").css("display", "none");
        changeWidth();
    });
    $(".button-open").click(function() {
        $(".sidebar").css("display", "block");
        changeWidth();
    });
    $(".button-bell").click(function() {
        $(".button-bell").toggleClass("active-bell");
    });
});

//Sidebar adding class ACTIVE
var btnContainer = document.querySelector(".menu-part");
var btns = btnContainer.getElementsByClassName("menu-item");
for (var i = 0; i < btns.length; i++) {
    btns[i].addEventListener("click", function() {
        var current = document.getElementsByClassName("active");
        current[0].className = current[0].className.replace(" active", "");
        this.className += " active";
        document.querySelector(".active-bell").classList.remove("active-bell");
    });
}

// var pageContainer = document.querySelector(".main-part");
// var pages = pageContainer.getElementsByTagName("section");
// var btnContainer = document.querySelector(".menu-part");
// var btns = btnContainer.getElementsByClassName("menu-item");
// for (var i = 0; i < btns.length; i++) {
//   btns[i].addEventListener("click", function() {
//     var w = window.innerWidth;
//     if (w < 576) {
//       document.querySelector(".sidebar").style.display = "none";
//     }
//   });
// }
// Changing width of main-part
function changeWidth() {
    var w = window.innerWidth;
    if (document.querySelector(".sidebar").style.display == "none") {
        if (w > 1024 && w < 1200) {
            document.querySelector(".main-part").style.maxWidth = "125%";
            document.querySelector(".main-part").style.left = "0px";
        } else if (w > 768) {
            document.querySelector(".main-part").style.maxWidth = "125%";
            document.querySelector(".main-part").style.left = "0px";
        } else if (w > 576) {
            document.querySelector(".main-part").style.maxWidth = "150%";
            document.querySelector(".main-part").style.left = "0px";
        }
    } else {
        if (w < 576) {} else if (w > 576 && w < 768) {
            document.querySelector(".main-part").style.maxWidth = "66.666666667%";
            document.querySelector(".main-part").style.left = "240px";
        } else if (w > 768 && w < 1024) {
            document.querySelector(".main-part").style.maxWidth = "75%";
            document.querySelector(".main-part").style.left = "240x";
        } else if (w < 1200) {
            document.querySelector(".main-part").style.maxWidth = "75%";
            document.querySelector(".main-part").style.left = "280px";
        } else {
            document.querySelector(".main-part").style.maxWidth = "75%";
            document.querySelector(".main-part").style.left = "360px";
        }
    }
}


window.dataLayer = window.dataLayer || [];

function gtag() { dataLayer.push(arguments); }
gtag('js', new Date());
gtag('config', 'UA-76614800-1');

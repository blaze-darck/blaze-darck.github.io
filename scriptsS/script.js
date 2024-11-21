// Funciones para la barra de navegación
const header = document.querySelector('header');
function fixedNavbar() {
    if (window.pageYOffset > 0) {
        header.classList.add('scroll');
    } else {
        header.classList.remove('scroll');
    }
}
window.addEventListener('scroll', fixedNavbar);

let menu = document.querySelector('#menu-btn');
let userBtn = document.querySelector('#user-btn');
let nav = document.querySelector('.navbar');
let userBox = document.querySelector('.user-box');

if (menu) {
    menu.addEventListener('click', function() {
        nav.classList.toggle('active');
    });
}

if (userBtn) {
    userBtn.addEventListener('click', function() {
        userBox.classList.toggle('active');
    });
}

"use strict"
const leftArrow = document.querySelector('.left-arrow .bxs-left-arrow'),
      rigthArrow = document.querySelector('.right-arrow .bxs-right-arrow'),
      slider = document.querySelector('.slider');

/* Funcion para girar el scroll a la derecha */
function scrollRigth(){
    if(slider.scrollWidth - slider.clientWidth === slider.scrollLeft){
        slider.scrollTo({
            left: 0,
            behavior: "smooth"
        });
    }else slider.scrollBy({
        left: window.innerWidth,
        behavior: "smooth"
    })
}
/* Funcion para girar el scroll a la izquierda */
function scrollLeft(){
    slider.scrollBy({
        left: -window.innerWidth,
        behavior: "smooth"
    })
}
/*Estableciendo un tiempo de ejecucion de la funcion scrollRigth con un tiempo de 7 segundos*/
let timerId = setInterval(scrollRigth, 7000);
/*Restableciendo el tiempo de ejecucion */
function resetTime(){
    clearInterval(timerId);
    timerId = setInterval(scrollRigth, 7000);
}
/*Creando el evento del scroll */
slider.addEventListener('click' ,function (ev){
    if(ev.target === leftArrow){
        scrollLeft();
        resetTime();
    }
})

slider.addEventListener('click' ,function (ev){
    if(ev.target === rigthArrow){
        scrollRigth();
        resetTime();
    }
})


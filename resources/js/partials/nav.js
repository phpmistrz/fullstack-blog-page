const hamburgerBtn = document.querySelector(".hamburger");
const mobileMenu = document.querySelector(".mobile-menu");
const body = document.querySelector("body");

const hamburgerHandler = () => {
    hamburgerBtn.classList.toggle("is-active");
    mobileMenu.classList.toggle("translate-y-[110%]");
    body.classList.toggle("overflow-y-hidden");
};

hamburgerBtn.addEventListener("click", hamburgerHandler);

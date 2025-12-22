const images = [
  "Produk/Img/hidangan/makanan1.jpeg",
  "Produk/Img/hidangan/makanan2.jpeg",
  "Produk/Img/hidangan/makanan3.jpeg",
  "Produk/Img/hidangan/makanan4.jpeg",
  "Produk/Img/hidangan/makanan5.jpeg",
  "Produk/Img/hidangan/makanan6.jpeg",
  "Produk/Img/hidangan/makanan7.jpeg",
  "Produk/Img/hidangan/makanan8.jpeg",
  "Produk/Img/hidangan/makanan9.jpeg",
  "Produk/Img/hidangan/makanan10.jpeg",
  "Produk/Img/hidangan/makanan11.jpeg",
  "Produk/Img/hidangan/makanan12.jpeg",
];

const slides = document.querySelectorAll(".bg-slide");

let index = 0;
slides[0].style.backgroundImage = `url(${images[0]})`;
slides[1].style.backgroundImage = `url(${images[1]})`;

let activeSlide = 0;

setInterval(() => {
  const nextIndex = (index + 1) % images.length;
  const nextSlide = (activeSlide + 1) % 2;

  slides[nextSlide].style.backgroundImage = `url(${images[nextIndex]})`;

  slides[nextSlide].classList.add("active");
  slides[activeSlide].classList.remove("active");

  activeSlide = nextSlide;
  index = nextIndex;
}, 4000); // ⏱️ ganti tiap 4 detik

const loginForm = document.getElementById("loginForm");
const registerForm = document.getElementById("registerForm");

const btnLogin = document.getElementById("btnLogin");
const btnRegister = document.getElementById("btnRegister");

function showLogin() {
  loginForm.classList.add("active");
  registerForm.classList.remove("active");

  btnLogin.classList.add("active");
  btnRegister.classList.remove("active");
}

function showRegister() {
  registerForm.classList.add("active");
  loginForm.classList.remove("active");

  btnRegister.classList.add("active");
  btnLogin.classList.remove("active");
}

btnLogin.onclick = showLogin;
btnRegister.onclick = showRegister;

const typingText = "Terhubung bersama kami";
const typingSpeed = 80;
let typingIndex = 0;

function typeText() {
  if (typingIndex < typingText.length) {
    document.getElementById("typing-text").textContent +=
      typingText.charAt(typingIndex);
    typingIndex++;
    setTimeout(typeText, typingSpeed);
  }
}

// mulai saat halaman siap
window.addEventListener("load", typeText);

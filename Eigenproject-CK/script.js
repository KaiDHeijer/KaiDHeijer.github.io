const homebutton = document.querySelector('#HomeButton').addEventListener('click', () => {
    window.location.href = "index.html";
});

const locationbutton = document.querySelector('#LocationButton').addEventListener('click', () => {
    window.location.href = "Location.html";
});

const signupButton = document.querySelector('#SignupButton').addEventListener('click', () => {
    window.location.href = "BecomeACobra.html";
});

const snakeButton = document.querySelector('.logo').addEventListener('click', () => {
    window.location.href = "BecomeACobra.html";
    console.log("Logo clicked");
});
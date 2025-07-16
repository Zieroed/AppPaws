function showRegister(){
    document.getElementById("register").classList.remove("hidden");
    document.getElementById("nonregister").classList.add("blur");
    document.getElementById("main-footer").classList.add("blur");
    document.getElementById("main-header").classList.add("blur");
}
function closeRegister(){
    document.getElementById("register").classList.add("hidden");
    document.getElementById("nonregister").classList.remove("blur");
    document.getElementById("main-header").classList.remove("blur");
    document.getElementById("main-footer").classList.remove("blur");
}
function confirmPassword(){
    const pass = document.getElementById("pass").value;
    const confirm_pass = document.getElementById("confirm_pass").value;
    document.getElementById("pass").classList.add("notMatch");
    document.getElementById("confirm_pass").classList.add("notMatch");
}
function showLogin() {
    document.getElementById("login-popup").classList.remove("hidden");
    document.getElementById("nonregister").classList.add("blur");
    document.getElementById("main-header").classList.add("blur");
    document.getElementById("main-footer").classList.add("blur");
}
function closeLogin() {
    document.getElementById("login-popup").classList.add("hidden");
    document.getElementById("nonregister").classList.remove("blur");
    document.getElementById("main-header").classList.remove("blur");
    document.getElementById("main-footer").classList.remove("blur");
}
function switchToRegister() {
    closeLogin();
    showRegister();
}
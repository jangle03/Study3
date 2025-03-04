function handleLike(button) {
    document.getElementById("likePopup").style.display = "flex";
}

function closePopup() {
    document.getElementById("likePopup").style.display = "none";
}

function redirectToLogin() {
    window.location.href = "/login/";
}

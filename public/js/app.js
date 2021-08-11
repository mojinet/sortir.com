function hideFlashMessage() {
    let a = document.getElementById('flash-message');
    a.classList.toggle('dnone');
}

function sortParticipants(){
    let b = document.querySelectorAll(".participants-length");
    console.log(b);
}

setTimeout(
    function() {
        var id200 = document.getElementById("flash-id");
        id200.style.transition = "opacity " + 3 + "s";
        id200.style.opacity = 0;
        id200.addEventListener("transitionend", function() {
            id200.style.display = "none";
        });
    }, 2000
);


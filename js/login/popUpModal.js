
// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("popUpPanelButton");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

//Dışarı tıkladığında kapanmasını kapattım elim çarpıp duruyor

window.onclick = function(event) {
  
  if (event.target == modal) {
    modal.style.display = "none";
  }
}


document.addEventListener("keyup", function(e) {
  if (e.key === "Escape") {
    modal.style.display = "none";
  }
})

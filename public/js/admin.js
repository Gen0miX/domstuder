var URL = "http://localhost/domstuder/";

window.addEventListener("popstate", (event) => {
 
});
window.onpopstate = (event) => {
  console.log("popstate");
};

var btnsDelImg = document.querySelectorAll(".btn.btn-outline-danger.round");
btnsDelImg.forEach(function (btn) {
  btn.onclick = function () {
    var imgId = this.getAttribute("data-imgId");
  };
});

$(document).ready(function () {
  $("#imageModal").on("show.bs.modal", function (e) {
    var imgPath = $(e.relatedTarget).data("img-path");
    var imageElement = document.getElementById("imageModalElement");
    imageElement.setAttribute("src", imgPath);
  });
});


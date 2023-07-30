$(document).ready(function () {
  $("#imageModal").on("show.bs.modal", function (e) {
    var imgPath = $(e.relatedTarget).data("img-path");
    var imageElement = document.getElementById("imageModalElement");
    imageElement.setAttribute("src", imgPath);
  });
});

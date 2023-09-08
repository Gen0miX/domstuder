function updateInfo(title, summary, cat) {
  switch (cat) {
    case "g":
      document.querySelector("h2.details-title.graph").textContent = title;
      document.querySelector("p.details-summary.graph").textContent = summary;
      break;
    case "i":
      document.querySelector("h2.details-title.illu").textContent = title;
      document.querySelector("p.details-summary.illu").textContent = summary;
      break;
    case "p":
      document.querySelector("h2.details-title.paints").textContent = title;
      document.querySelector("p.details-summary.paints").textContent = summary;
      break;
  }
}

document.querySelectorAll(".cont-img-showcase").forEach(function (div) {
  div.addEventListener("mouseenter", function () {
    var id = div.getAttribute("art-id");
    var cat = div.getAttribute("cat");

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "/domstuder/ajax", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        var data = JSON.parse(xhr.responseText);
        updateInfo(data.h2, data.p, data.cat);
      }
    };
    var idToSend = "id=" + encodeURIComponent(id);
    var catToSend = "cat=" + encodeURIComponent(cat);

    var dataToSend = idToSend + "&" + catToSend;

    xhr.send(dataToSend);
  });
});

document.querySelectorAll(".cont-img-showcase").forEach(function (div) {
  div.addEventListener("mouseleave", function () {
    var cat = div.getAttribute("cat");

    switch (cat) {
      case "g":
        updateInfo(
          "Détails Graphisme",
          "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Tenetur doloremque dolor, odit voluptatum reprehenderit sunt earum.",
          cat
        );
        break;
      case "i":
        updateInfo(
          "Détails Illustration",
          "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Tenetur doloremque dolor, odit voluptatum reprehenderit sunt earum.",
          cat
        );
        break;
      case "p":
        updateInfo(
          "Détails Peinture",
          "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Tenetur doloremque dolor, odit voluptatum reprehenderit sunt earum.",
          cat
        );
        break;
    }
  });
});

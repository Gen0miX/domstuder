gsap.registerPlugin(ScrollTrigger);

const sections = document.querySelectorAll("section");
const image = document.querySelector("#logo-changer");
const logoTxt = document.querySelector(".logoH2");

// Calculer la durée de l'épinglage basée sur la hauteur de la section "home"
let pinDuration = document.querySelector("#section1").offsetHeight + 800;

// Épingler la section 'home' pendant le défilement parallaxe
let homeST = gsap.to("#section1", {
  scrollTrigger: {
    trigger: "#section1",
    start: "top top",
    end: `+=${pinDuration}px`,
    pin: true,
    scrub: true,
    anticipatePin: 1,
  },
});

document.querySelectorAll(".parallax-image").forEach((layer, i) => {
  let depth = 1 + i * 0.1;
  let movement = layer.offsetHeight * depth + 650;

  gsap.fromTo(
    layer,
    {
      y: movement,
    },
    {
      y: -movement,
      ease: "none",
      scrollTrigger: {
        trigger: homeST.scrollTrigger.pinSpacer, // Utilisez le conteneur épinglé comme déclencheur
        scrub: true,
        start: "top top",
        end: `+=${pinDuration}px`,
      },
    }
  );
});

sections.forEach((section, index) => {
  const changeImageAnimation = () => {
    switch (index) {
      case 1:
      case 3:
        image.src = "public/images/logos/logo_petit_w.png";
        logoTxt.style.color = "white";
        break;
      case 0:
      case 2:
      case 4:
        image.src = "public/images/logos/logo_petit_b.png";
        logoTxt.style.color = "black";
        break;
    }
  };
  const changeImageAnimationReverse = () => {
    switch (index) {
      case 1:
      case 3:
        image.src = "public/images/logos/logo_petit_b.png";
        logoTxt.style.color = "black";
        break;
      case 2:
      case 4:
        image.src = "public/images/logos/logo_petit_w.png";
        logoTxt.style.color = "white";
        break;
    }
  };

  ScrollTrigger.create({
    trigger: section,
    start: "top 0%",
    onEnter: () => {
      changeImageAnimation();
    },
    onLeaveBack: () => {
      changeImageAnimationReverse();
    },
  });
});

const textAnimG = document.querySelector(".text-animation.graph");
const textAnimI = document.querySelector(".text-animation.illu");
const textAnimP = document.querySelector(".text-animation.paints");

let typewriterG, typewriterI, typewriterP;

function updateInfoWTypeW(title, summary, cat) {
  switch (cat) {
    case "g":
      typewriterG = new Typewriter(textAnimG, {
        loop: false,
        deleteSpeed: 20,
        cursor: "",
      });
      typewriterG
        .changeDelay("natural")
        .typeString('<h2 class="details-title graph">' + title + "</h2>")
        .changeDelay(15)
        .typeString('<p class="details-summary graph">' + summary + "</p>")
        .start();
      break;
    case "i":
      typewriterI = new Typewriter(textAnimI, {
        loop: false,
        deleteSpeed: 20,
        cursor: "",
      });
      typewriterI
        .changeDelay("natural")
        .typeString('<h2 class="details-title illu">' + title + "</h2>")
        .changeDelay(20)
        .typeString('<p class="details-summary illu">' + summary + "</p>")
        .start();
      break;
    case "p":
      typewriterP = new Typewriter(textAnimP, {
        loop: false,
        deleteSpeed: 20,
        cursor: "",
      });
      typewriterP
        .changeDelay("natural")
        .typeString('<h2 class="details-title paints">' + title + "</h2>")
        .changeDelay(20)
        .typeString('<p class="details-summary paints">' + summary + "</p>")
        .start();
      break;
  }
}

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

const divShowcases = document.querySelectorAll(".cont-img-showcase");

divShowcases.forEach(function (div) {
  div.addEventListener("mouseenter", function () {
    var id = div.getAttribute("art-id");
    var cat = div.getAttribute("cat");

    //Add class BW:
    addClassBW(cat, div);

    setTimeout(function () {
      getTextsShowCase(id, cat);
    }, 598);
  });

  div.addEventListener("mouseleave", function () {
    var cat = div.getAttribute("cat");

    //Remove class BW
    divShowcases.forEach((otherDiv) => {
      if (otherDiv !== div) {
        otherDiv.classList.remove("bw");
      }
    });

    setTimeout(function () {
      resetTextsShowcase(cat);
    }, 600);
  });
});

function getTextsShowCase(artId, cat) {
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "/domstuder/ajax", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      var data = JSON.parse(xhr.responseText);
      updateInfoWTypeW(data.h2, data.p, data.cat);
    }
  };
  var idToSend = "id=" + encodeURIComponent(artId);
  var catToSend = "cat=" + encodeURIComponent(cat);

  var dataToSend = idToSend + "&" + catToSend;

  xhr.send(dataToSend);
}

function resetTextsShowcase(cat) {
  switch (cat) {
    case "g":
      typewriterG.stop();
      updateInfoWTypeW(
        "Détails Graphisme",
        "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Tenetur doloremque dolor, odit voluptatum reprehenderit sunt earum.",
        cat
      );
      break;
    case "i":
      typewriterI.stop();
      updateInfoWTypeW(
        "Détails Illustration",
        "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Tenetur doloremque dolor, odit voluptatum reprehenderit sunt earum.",
        cat
      );
      break;
    case "p":
      typewriterP.stop();
      updateInfoWTypeW(
        "Détails Peinture",
        "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Tenetur doloremque dolor, odit voluptatum reprehenderit sunt earum.",
        cat
      );
      break;
  }
}

function addClassBW(cat, div) {
  switch (cat) {
    case "g":
      const divsG = document.querySelectorAll(".cont-img-showcase.graph");
      divsG.forEach((otherDiv) => {
        if (otherDiv !== div) {
          otherDiv.classList.add("bw");
        }
      });
      break;
    case "i":
      const divsI = document.querySelectorAll(".cont-img-showcase.illu");
      divsI.forEach((otherDiv) => {
        if (otherDiv !== div) {
          otherDiv.classList.add("bw");
        }
      });
      break;
    case "p":
      const divsP = document.querySelectorAll(".cont-img-showcase.paints");
      divsP.forEach((otherDiv) => {
        if (otherDiv !== div) {
          otherDiv.classList.add("bw");
        }
      });
      break;
  }
}

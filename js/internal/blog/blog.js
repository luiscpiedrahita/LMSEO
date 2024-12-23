import { Dropdown } from "bootstrap";
import Lightbox from "bs5-lightbox";
import AOS from "aos";
import { bsToggle } from "../../utilities/navbar";

const options = {
  keyboard: true,
  size: "fullscreen",
  constrain: false,
};
document.querySelectorAll(".catalog-industries").forEach((el) =>
  el.addEventListener("click", (e) => {
    e.preventDefault();
    const lightbox = new Lightbox(el, options);
    lightbox.show();
  })
);
document.addEventListener("click", function (e) {
  // Hamburger menu
  // console.log(e.target.classList.contains("hamburger-toggle"));
  if (e.target.classList.contains("hamburger-toggle")) {
    // console.log(e.target.children[0].classList);
    e.target.children[0].classList.toggle("active");
  }
});

AOS.init({
  offset: 0,
  once: false,
  mirror: false,
});

bsToggle.init();

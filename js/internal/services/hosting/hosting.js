import { Navbar } from "bootstrap";
import { bsToggle } from "../../../utilities/navbar";
import { gsapImp } from "../../../utilities/gsapImp";

document.addEventListener("click", function (e) {
  // Hamburger menu
  if (e.target.classList.contains("hamburger-toggle")) {
    e.target.children[0].classList.toggle("active");
  }
});
// GSAP Implementation
gsapImp.init();

// Bootstrap Mobile Navbar
bsToggle.init();

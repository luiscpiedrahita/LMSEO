import { Navbar, Popper } from "bootstrap";
import AOS from "aos";
import { bsToggle } from "../../utilities/navbar";
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

import { Dropdown } from "bootstrap";
import Lightbox from "bs5-lightbox";
import AOS from "aos";
import { bsToggle } from "./utilities/navbar";

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
// wpcf7mailsent — Fires when an Ajax form submission has completed successfully, and mail has been sent.
// wpcf7invalid — Fires when an Ajax form submission has completed successfully, but mail hasn’t been sent because there are fields with invalid input.
// wpcf7spam — Fires when an Ajax form submission has completed successfully, but mail hasn’t been sent because a possible spam activity has been detected.
// wpcf7mailfailed — Fires when an Ajax form submission has completed successfully, but it has failed in sending mail.
// wpcf7submit — Fires when an Ajax form submission has completed successfully, regardless of other incidents.
// let cf7 = document.getElementById("wpcf7-f1985-o1");

// let emailAlertBootstrapClass = (status) => {
//   let cf7BottomRes = cf7.getElementsByClassName("wpcf7-response-output")[0];
//   let cf7TopRes = cf7.getElementsByClassName("screen-reader-response")[0];

//   if (cf7BottomRes.classList.length > 1) {
//     cf7BottomRes.className = "wpcf7-response-output";
//     cf7TopRes.className = "screen-reader-response";
//   }
//   switch (status) {
//     case "wpcf7mailsent":
//       cf7BottomRes.classList?.add("alert", "alert-success");
//       cf7TopRes.classList?.add("alert", "alert-success");
//       break;
//     case "wpcf7invalid":
//       cf7BottomRes.classList?.add("alert", "alert-danger");
//       cf7TopRes.classList?.add("alert", "alert-danger");
//       break;
//   }
// };
// let cf7Events = [
//   "wpcf7mailsent",
//   "wpcf7invalid",
//   // "wpcf7spam",
//   // "wpcf7mailfailed",
//   // "wpcf7submit",
// ];
// cf7Events.forEach((eve) =>
//   cf7.addEventListener(
//     eve,
//     function (e) {
//       if ("1985" == e.detail.contactFormId) {
//         emailAlertBootstrapClass(eve);
//       }
//     },
//     false
//   )
// );

// document.addEventListener(
//   "wpcf7invalid",
//   function (event) {
//     if ("1985" == event.detail.contactFormId) {
//       console.log(event);

//       emailAlertBootstrapClass(1);
//     }
//   },
//   false
// );

AOS.init({
  offset: 0,
  once: false,
  mirror: false,
});

bsToggle.init();

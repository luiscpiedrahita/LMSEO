import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

let gsapImp = {
  init: function () {
    let dataAosSections = gsap.utils.toArray("[data-aos]");
    let fadeLeftSections = gsap.utils.toArray(".fade-left");
    let fadeRightSections = gsap.utils.toArray(".fade-right");
    gsap.registerPlugin(ScrollTrigger);
    const tl0 = gsap.timeline({});

    // Above the fold animation
    this.aboveFoldAnimation(fadeLeftSections, tl0);
    this.aboveFoldAnimation(fadeRightSections, tl0, "left");

    // Emulate AOS animmation
    // Assign default AOS properties to elements
    let aos = document.querySelectorAll("[data-aos]");
    aos.forEach((i) => {
      i.setAttribute("data-aos-easing", this.default.easing);
      i.setAttribute("data-aos-duration", this.default.duration);
      i.setAttribute("data-aos-delay", this.default.delay);
      // It signals to the rest of the script that the element has been init
      i.classList.add("aos-init");
    });
    dataAosSections.forEach((element) => {
      if (element) {
        // There is no JS aniamation so We use the create method instead
        ScrollTrigger.create({
          trigger: element,
          start: "top 80%",
          end: "bottom 30% ",
          toggleClass: "aos-animate",
          toggleAction: "play restart reverse none",
          scrub: true,
          pin: false,
        });
      }
    });
    // Scale image full screen animation
    let expandFull = gsap.utils.toArray(".expand-full");
    expandFull.forEach((el) => {
      let q = gsap.utils.selector(el);
      let imgExpand = q("img.expand-img");
      let imgWrapperExpand = q(".expand-img-wrapper");
      tl0.to(imgWrapperExpand, {
        y: 0,
        clipPath: "polygon(0% 0%, 100% 0%, 100% 100%, 0% 100%)",
        yPercent: 0,
        scrollTrigger: {
          trigger: imgWrapperExpand,
          start: "top center",
          end: () => "+=" + imgWrapperExpand.offsetHeight / 3,
          scrub: 1,
          toggleAction: "play restart reverse none",
        },
        // Only run parallax animation when scale animation is completed
        onComplete: () => {
          this.parallax(imgExpand, el, tl0);
        },
      });
    });
  },
  default: {
    offset: 120,
    delay: 0,
    easing: "ease",
    duration: 400,
    disable: false,
    once: false,
    mirror: false,
    anchorPlacement: "top-bottom",
    startEvent: "DOMContentLoaded",
    animatedClassName: "aos-animate",
    initClassName: "aos-init",
    useClassNames: false,
    disableMutationObserver: false,
    throttleDelay: 99,
    debounceDelay: 50,
  },
  // If we wait for JS animation above the fold
  // the page gets penalized by Google
  // https://web.dev/articles/vitals
  aboveFoldAnimation(trigger, timeline, fadeOutEffect) {
    //Default is fade-right
    const x = fadeOutEffect == "left" ? -400 : 400;
    trigger.forEach((element) => {
      if (element) {
        timeline.to(element, {
          opacity: 0,
          x: x,
          y: 100,
          scrollTrigger: {
            trigger: element,
            start: "top 10%",
            end: "bottom 30% ",
            scrub: 3,
            toggleAction: "play restart reverse none",
          },
        });
      }
    });
  },
  /**
   * Greets a user with a personalized message.
   *
   * @param {string} el - The name of the user.
   * @returns {string} - A greeting message.
   */
  parallax(el, trigger, timeline) {
    timeline.to(el, {
      y: 50,
      scrollTrigger: {
        trigger: trigger,
        start: "top 50%",
        end: "bottom bottom",
        scrub: true,
        toggleAction: "play restart reverse none",
      },
    });
  },
};
export { gsapImp };

//dataset.bsToggle = "dropdown" allows Boostrap navbar to listen to click events collapsing or expanding dropdowns. However, this behavior is only want on mobile devices as we are currently using hover events on pages larger than 992px wide

let bsToggle = {
  init: function () {
    window.addEventListener("resize", this.setBsToggle, false);
    window.addEventListener("load", this.setBsToggle, false);
  },
  setBsToggle: function (e) {
    document.querySelectorAll("a[data-bs-toggle]").forEach((el) => {
      // if (window.innerWidth < 992) {
      if (e.currentTarget.innerWidth < 992) {
        el.dataset.bsToggle = "dropdown";
      } else {
        el.dataset.bsToggle = "";
      }
    });
  },
};
export { bsToggle };

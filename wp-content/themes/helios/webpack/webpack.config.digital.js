const outputPath = "../../dist/internal/services/digital";
const localDomain = "http://lmseo.test";
const publicPath = "/wp-content/themes/helios/dist/internal/services/digital/";
const servicesEntryPoints = [
  "./js/internal/services/digital/digital.js",
  "./scss/internal/services/digital/digital.scss",
];
module.exports = require("./templates/dev.template")(
  servicesEntryPoints,
  outputPath,
  localDomain,
  publicPath,
  "",
  true
);

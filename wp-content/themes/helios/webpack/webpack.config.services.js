const outputPath = "../../dist/internal/services";
const localDomain = "http://lmseo.test";
const publicPath = "/wp-content/themes/helios/dist/internal/services/";
const servicesEntryPoints = [
  "./js/internal/services/services.js",
  "./scss/internal/services/services.scss",
];
module.exports = require("./templates/dev.template")(
  servicesEntryPoints,
  outputPath,
  localDomain,
  publicPath,
  "",
  true
);

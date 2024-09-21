const outputPath = "../../dist/internal/services/definitions";
const localDomain = "http://lmseo.test";
const publicPath =
  "/wp-content/themes/helios/dist/internal/services/definitions/";
const servicesEntryPoints = [
  "./js/internal/services/definitions/definitions.js",
  "./scss/internal/services/definitions/definitions.scss",
];
module.exports = require("./templates/dev.template")(
  servicesEntryPoints,
  outputPath,
  localDomain,
  publicPath,
  "",
  true
);

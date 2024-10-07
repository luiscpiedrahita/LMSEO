const outputPath = "../../dist/internal/search";
const localDomain = "http://lmseo.test";
const publicPath = "/wp-content/themes/helios/dist/internal/search/";
const servicesEntryPoints = [
  "./js/internal/search/search.js",
  "./scss/internal/search/search.scss",
];
module.exports = require("./templates/dev.template")(
  servicesEntryPoints,
  outputPath,
  localDomain,
  publicPath,
  "",
  true
);

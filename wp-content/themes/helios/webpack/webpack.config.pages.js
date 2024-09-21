const outputPath = "../../dist/internal/pages";
const localDomain = "http://lmseo.test";
const publicPath = "/wp-content/themes/helios/dist/internal/pages/";
const pagestEntryPoints = [
  "./js/internal/pages/app.js",
  "./scss/internal/pages/pages.scss",
];
module.exports = require("./templates/dev.template")(
  pagestEntryPoints,
  outputPath,
  localDomain,
  publicPath,
  "",
  true
);

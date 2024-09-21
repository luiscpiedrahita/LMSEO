const publicPath = "/wp-content/themes/helios/dist/homepage/";
const outputPath = "../../dist/homepage";
const localDomain = "http://lmseo.test";
const homePageEntryPoints = ["./js/app.js", "./scss/style.scss"];
const filename = "../../style.css";

module.exports = require("./templates/dev.template")(
  homePageEntryPoints,
  outputPath,
  localDomain,
  publicPath,
  filename,
  "",
  true
);

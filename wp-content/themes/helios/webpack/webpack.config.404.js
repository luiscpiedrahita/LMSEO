const publicPath = "/wp-content/themes/helios/errors/404/";
const outputPath = "../../dist/errors/404";
const localDomain = "http://lmseo.test";
const error404EntryPoints = [
  "./js/errors/404/404.js",
  "./scss/errors/404/404.scss",
];
module.exports = require("./templates/dev.template")(
  error404EntryPoints,
  outputPath,
  localDomain,
  publicPath,
  "",
  true
);

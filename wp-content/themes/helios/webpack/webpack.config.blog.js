const outputPath = "../../dist/internal/blog";
const localDomain = "http://lmseo.test";
const publicPath = "/wp-content/themes/helios/dist/internal/blog/";
const entryPoints = [
  "./js/internal/blog/blog.js",
  "./scss/internal/blog/blog.scss",
];

module.exports = require("./templates/dev.template")(
  entryPoints,
  outputPath,
  localDomain,
  publicPath,
  "",
  true
);

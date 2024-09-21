const outputPath = "../../dist/internal/blog/index/";
const localDomain = "http://lmseo.test";
const publicPath = "/wp-content/themes/helios/dist/internal/blog/index/";
const entryPoints = [
  "./js/internal/blog/index/blogIndex.js",
  "./scss/internal/blog/index/blogIndex.scss",
];
module.exports = require("./templates/dev.template")(
  entryPoints,
  outputPath,
  localDomain,
  publicPath,
  "",
  true
);

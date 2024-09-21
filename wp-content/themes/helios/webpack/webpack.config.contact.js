const outputPath = "../../dist/internal/contact";
const localDomain = "http://lmseo.test";
const publicPath = "/wp-content/themes/helios/dist/internal/contact/";
const contactEntryPoints = [
  "./js/internal/contact/contact.js",
  "./scss/internal/contact/contact.scss",
];

module.exports = require("./templates/dev.template")(
  contactEntryPoints,
  outputPath,
  localDomain,
  publicPath,
  "",
  true
);

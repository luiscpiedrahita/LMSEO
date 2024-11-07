// This webpack file is a build for the entire website at once
// hence it is very slow
// Use individual webpack configs to build individual
// WordPress templates
const webpackConfig = require("./webpack/templates/dev.template");
const config404 = require("./webpack/templates/404");
const configBlog = require("./webpack/templates/blog");
const configBlogIndex = require("./webpack/templates/blogIndex");
const configContact = require("./webpack/templates/contact");
const configHomepage = require("./webpack/templates/homepage");
const configPages = require("./webpack/templates/pages");
const configSearch = require("./webpack/templates/search");
const configServices = require("./webpack/templates/services");
const configServicesDef = require("./webpack/templates/servicesDef");
const configServicesDev = require("./webpack/templates/servicesDevelopment");
const configServicesDigital = require("./webpack/templates/servicesDigital");
const configTeams = require("./webpack/templates/teams");

let config = [];
const wordpressSections = [
  config404,
  configBlog,
  configBlogIndex,
  configContact,
  configHomepage,
  configPages,
  configSearch,
  configServices,
  configServicesDef,
  configServicesDigital,
  configServicesDev,
  configTeams,
];
// lastArrayElem i + 1 === row.length ? true : false
// determines is it is the las config and launches
// BrowserSync once
wordpressSections.map((section, i, row) =>
  config.push(
    ...webpackConfig(
      section.entryPoints,
      section.outputPath,
      section.localDomain,
      section.publicPath,
      section.filename,
      i + 1 === row.length ? true : false
    )
  )
);
// console.log(config);
module.exports = [...config];

// This webpack file is a build for the entire website at once
// hence it is very slow
// Use individual webpack configs to build individual
// WordPress templates
const webpackConfig = require("./webpack/templates/dev.template");
let config = [];
const wordpressSections = [
  {
    publicPath: "/wp-content/themes/helios/errors/404/",
    outputPath: "../../dist/errors/404",
    entryPoints: ["./js/errors/404/404.js", "./scss/errors/404/404.scss"],
    localDomain: "http://lmseo.test",
    filename: "",
  },
  {
    publicPath: "/wp-content/themes/helios/dist/internal/blog/",
    outputPath: "../../dist/internal/blog",
    entryPoints: [
      "./js/internal/blog/blog.js",
      "./scss/internal/blog/blog.scss",
    ],
    localDomain: "http://lmseo.test",
    filename: "",
  },
  {
    publicPath: "/wp-content/themes/helios/dist/internal/blog/index/",
    outputPath: "../../dist/internal/blog/index/",
    entryPoints: [
      "./js/internal/blog/index/blogIndex.js",
      "./scss/internal/blog/index/blogIndex.scss",
    ],
    localDomain: "http://lmseo.test",
    filename: "",
  },
  {
    publicPath: "/wp-content/themes/helios/dist/internal/contact/",
    outputPath: "../../dist/internal/contact",
    entryPoints: [
      "./js/internal/contact/contact.js",
      "./scss/internal/contact/contact.scss",
    ],
    localDomain: "http://lmseo.test",
    filename: "",
  },
  {
    publicPath: "/wp-content/themes/helios/dist/homepage/",
    outputPath: "../../dist/homepage",
    entryPoints: ["./js/app.js", "./scss/style.scss"],
    localDomain: "http://lmseo.test",
    filename: "../../style.css",
  },
  {
    publicPath: "/wp-content/themes/helios/dist/internal/pages/",
    outputPath: "../../dist/internal/pages",
    entryPoints: [
      "./js/internal/pages/app.js",
      "./scss/internal/pages/pages.scss",
    ],
    localDomain: "http://lmseo.test",
    filename: "",
  },
  {
    publicPath: "/wp-content/themes/helios/dist/internal/services/",
    outputPath: "../../dist/internal/services",
    entryPoints: [
      "./js/internal/services/services.js",
      "./scss/internal/services/services.scss",
    ],
    localDomain: "http://lmseo.test",
    filename: "",
  },
  {
    publicPath: "/wp-content/themes/helios/dist/internal/services/definitions/",
    outputPath: "../../dist/internal/services/definitions",
    entryPoints: [
      "./js/internal/services/definitions/definitions.js",
      "./scss/internal/services/definitions/definitions.scss",
    ],
    localDomain: "http://lmseo.test",
    filename: "",
  },
  {
    publicPath: "/wp-content/themes/helios/dist/internal/teams/",
    outputPath: "../../dist/internal/teams",
    entryPoints: [
      "./js/internal/teams/teams.js",
      "./scss/internal/teams/teams.scss",
    ],
    localDomain: "http://lmseo.test",
    filename: "",
  },
];
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

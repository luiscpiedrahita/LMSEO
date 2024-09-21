const outputPath = "../../dist/internal/teams";
const localDomain = "http://lmseo.test";
const publicPath = "/wp-content/themes/helios/dist/internal/teams/";
const teamsEntryPoints = [
  "./js/internal/teams/teams.js",
  "./scss/internal/teams/teams.scss",
];
module.exports = require("./templates/dev.template")(
  teamsEntryPoints,
  outputPath,
  localDomain,
  publicPath,
  "",
  true
);

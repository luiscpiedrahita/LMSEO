const config = require("./templates/servicesGoogle");

module.exports = require("./templates/dev.template")(
  config.entryPoints,
  config.outputPath,
  config.localDomain,
  config.publicPath,
  config.filename,
  true
);

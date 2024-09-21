const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const BrowserSyncPlugin = require("browser-sync-webpack-plugin");
const WebpackBar = require("webpackbar");
const path = require("path");

module.exports = (
  entryPoints,
  outputPath,
  localDomain,
  publicPath,
  filename = "style.css",
  lastArrayElem = false
) => {
  const bSyncConf = new BrowserSyncPlugin(
    {
      proxy: localDomain,
      files: ["/*.css"],
      injectCss: false,
    },
    { reload: true }
  );
  return [
    {
      entry: entryPoints,
      stats: "errors-only",
      devtool: "source-map",
      resolve: {
        extensions: ["*", ".js"],
      },
      output: {
        path: path.resolve(__dirname, outputPath),
        filename: "js/app.js",
        publicPath: publicPath,
        assetModuleFilename: "images/[name][ext][query]",
      },
      plugins: [
        new WebpackBar(),
        new MiniCssExtractPlugin({
          filename: filename === "" ? "style.css" : filename,
        }),
        lastArrayElem === false ? "" : bSyncConf,
      ],
      module: {
        rules: [
          {
            test: /\.s?[c]ss$/i,
            exclude: /node_modules/,
            use: [
              {
                loader: MiniCssExtractPlugin.loader,
              },
              "css-loader",
              {
                loader: "postcss-loader",
                options: {
                  postcssOptions: {
                    plugins: () => [require("autoprefixer")],
                  },
                },
              },
              {
                loader: "sass-loader",
                options: {
                  sassOptions: {
                    includePaths: ["node_modules/bootstrap/scss/", "fonts/"],
                  },
                },
              },
            ],
          },
          {
            mimetype: "image/svg+xml",
            scheme: "data",
            type: "asset/resource",
            generator: {
              filename: "icons/[name]-[hash].svg[query]",
            },
          },
          {
            test: /\.(png|jpg|jpeg|gif)$/i,
            type: "asset/resource",
          },
          {
            test: /\.(woff|woff2|eot|ttf|otf)$/i,
            type: "asset/resource",
          },
          {
            test: /\.js$/,
            exclude: /(node_modules|bower_components)/,
            use: {
              loader: "babel-loader",
            },
          },
        ],
      },
    },
  ];
};

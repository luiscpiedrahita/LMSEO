const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const BrowserSyncPlugin = require("browser-sync-webpack-plugin");
const WebpackBar = require("webpackbar");
const path = require("path");

const outputPath = "dist";
const localDomain = "http://lmseo.test";
const homePageEntryPoints = {
  app: "./js/app.js",
  style: "./scss/style.scss",
};
const servicesEntryPoints = {
  app: "./js/internal/services/services.js",
  style: "./scss/internal/services/services.scss",
};
const servicesDefinitionsEntryPoints = {
  app: "./js/internal/services/definitions/definitions.js",
  style: "./scss/internal/services/definitions/definitions.scss",
};
const contactEntryPoints = {
  app: "./js/internal/contact/contact.js",
  style: "./scss/internal/contact/contact.scss",
};
const pageEntryPoints = {
  app: "./js/internal/pages/app.js",
  style: "./scss/internal/pages/pages.scss",
};
const blogEntryPoints = {
  app: "./js/internal/blog/blog.js",
  style: "./scss/internal/blog/blog.scss",
};

module.exports = [
  {
    entry: homePageEntryPoints,
    stats: "errors-only",
    devtool: "source-map",
    resolve: {
      extensions: ["*", ".js"],
    },
    output: {
      path: path.resolve(__dirname, outputPath),
      filename: "homepage/js/[name].js",
      publicPath: "/wp-content/themes/helios/dist/",
      assetModuleFilename: "homepage/images/[name][ext][query]",
    },
    plugins: [
      new WebpackBar(),
      new MiniCssExtractPlugin({
        filename: "../[name].css",
      }),
    ],
    module: {
      rules: [
        {
          test: /\.s?[c]ss$/i,
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
            "sass-loader",
          ],
        },
        {
          mimetype: "image/svg+xml",
          scheme: "data",
          type: "asset/resource",
          generator: {
            filename: "homepage/icons/[name]-[hash].svg[query]",
          },
        },
        {
          test: /\.(png|svg|jpg|jpeg|gif)$/i,
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
  {
    entry: servicesEntryPoints,
    stats: "errors-only",
    devtool: "source-map",
    devServer: {
      static: "./dist",
      hot: true,
    },
    resolve: {
      extensions: ["*", ".js"],
    },
    output: {
      path: path.resolve(__dirname, outputPath),
      filename: "internal/services/js/[name].js",
      publicPath: "/wp-content/themes/helios/dist/",
      assetModuleFilename: "internal/services/images/[name][ext][query]",
    },
    plugins: [
      new WebpackBar(),
      new MiniCssExtractPlugin({
        filename: "internal/services/[name].css",
      }),
    ],
    module: {
      rules: [
        {
          test: /\.s?[c]ss$/i,
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
                  includePaths: ["node_modules/bootstrap/scss/"],
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
            filename: "internal/services/icons/[name]-[hash].svg[query]",
          },
        },
        {
          test: /\.(png|svg|jpg|jpeg|gif)$/i,
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
            options: {
              presets: [],
            },
          },
        },
      ],
    },
  },
  {
    entry: servicesDefinitionsEntryPoints,
    devtool: "source-map",
    resolve: {
      extensions: ["*", ".js"],
    },
    output: {
      path: path.resolve(__dirname, outputPath),
      filename: "internal/services/definitions/js/[name].js",
      publicPath: "/wp-content/themes/helios/dist/",
      assetModuleFilename:
        "internal/services/definitions/images/[name][ext][query]",
    },
    plugins: [
      new WebpackBar(),
      new MiniCssExtractPlugin({
        filename: "internal/services/definitions/[name].css",
      }),
    ],
    module: {
      rules: [
        {
          test: /\.s?[c]ss$/i,
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
                  includePaths: ["node_modules/bootstrap/scss/"],
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
            filename:
              "internal/services/definitions/icons/[name]-[hash].svg[query]",
          },
        },
        {
          test: /\.(png|svg|jpg|jpeg|gif)$/i,
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
  {
    entry: contactEntryPoints,
    devtool: "source-map",
    resolve: {
      extensions: ["*", ".js"],
    },
    output: {
      path: path.resolve(__dirname, outputPath),
      filename: "internal/contact/js/[name].js",
      publicPath: "/wp-content/themes/helios/dist/",
      assetModuleFilename: "internal/contact/images/[name][ext][query]",
    },
    plugins: [
      new WebpackBar(),
      new MiniCssExtractPlugin({
        filename: "internal/contact/[name].css",
      }),
    ],
    module: {
      rules: [
        {
          test: /\.s?[c]ss$/i,
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
            filename: "internal/contact/icons/[name]-[hash].svg[query]",
          },
        },
        {
          test: /\.(png|svg|jpg|jpeg|gif)$/i,
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
  {
    entry: pageEntryPoints,
    devtool: "source-map",
    resolve: {
      extensions: ["*", ".js"],
    },
    output: {
      path: path.resolve(__dirname, outputPath),
      filename: "internal/pages/js/[name].js",
      publicPath: "/wp-content/themes/helios/dist/",
      assetModuleFilename: "internal/pages/images/[name][ext][query]",
    },
    plugins: [
      new WebpackBar(),
      new MiniCssExtractPlugin({
        filename: "internal/pages/[name].css",
      }),
      new BrowserSyncPlugin(
        {
          proxy: localDomain,
          files: ["/*.css"],
          injectCss: false,
        },
        { reload: true }
      ),
    ],
    module: {
      rules: [
        {
          test: /\.s?[c]ss$/i,
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
            filename: "internal/pages/icons/[name]-[hash].svg[query]",
          },
        },
        {
          test: /\.(png|svg|jpg|jpeg|gif)$/i,
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
  {
    entry: blogEntryPoints,
    devtool: "source-map",
    resolve: {
      extensions: ["*", ".js"],
    },
    output: {
      path: path.resolve(__dirname, outputPath),
      filename: "internal/blog/js/[name].js",
      publicPath: "/wp-content/themes/helios/dist/",
      assetModuleFilename: "internal/pages/images/[name][ext][query]",
    },
    plugins: [
      new WebpackBar(),
      new MiniCssExtractPlugin({
        filename: "internal/pages/[name].css",
      }),
      new BrowserSyncPlugin(
        {
          proxy: localDomain,
          files: ["/*.css"],
          injectCss: false,
        },
        { reload: true }
      ),
    ],
    module: {
      rules: [
        {
          test: /\.s?[c]ss$/i,
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
            filename: "internal/pages/icons/[name]-[hash].svg[query]",
          },
        },
        {
          test: /\.(png|svg|jpg|jpeg|gif)$/i,
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

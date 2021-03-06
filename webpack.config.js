const webpack = require('webpack');
const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CssMinimizerPlugin = require('css-minimizer-webpack-plugin');
const TerserPlugin = require("terser-webpack-plugin");

const noSourceMap = [ /scroll-triggers/, /tinybounce/, /domassist/, /attrobj/ ];

const isDev = process.env.NODE_ENV === 'development';
const isProduction = !isDev;

const activePlugins = [
    new webpack.ProvidePlugin({
        $: 'jquery',
        jQuery: 'jquery',
    }),
    new MiniCssExtractPlugin()
];
if (isDev) {
    activePlugins.push(
      new webpack.SourceMapDevToolPlugin({
          filename: "[file].map"
      })
    );
}

module.exports = {
    entry: {
        general: path.resolve(__dirname, './js/general.js'),
        homepage: path.resolve(__dirname, './js/homepage.js'),
        reservation: path.resolve(__dirname, './js/reservation.js'),
        reviews: path.resolve(__dirname, './js/reviews.js'),
        checkout: path.resolve(__dirname, './js/checkout.js')
    },
    output: {
        path: path.resolve(__dirname, './dist'),
        filename: '[name].bundle.js',
        chunkFilename: '[id].js',
    },
    plugins: activePlugins,
    optimization: {
        minimize: isProduction,
        minimizer: [
            new CssMinimizerPlugin(),
            new TerserPlugin()
        ],
    },
    module: {
        rules: [
            {
                test: [/\.js?$/, /\.ts?$/, /\.jsx?$/, /\.tsx?$/],
                enforce: 'pre',
                exclude: noSourceMap,
                use: ['source-map-loader'],
            },
            {
                test: [/\.js?$/, /\.ts?$/, /\.jsx?$/, /\.tsx?$/],
                exclude: /(node_modules|bower_components)/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ["@babel/preset-env"]
                    }
                }
            },
            {
                test: /\.css$/i,
                use: [MiniCssExtractPlugin.loader, "css-loader", "postcss-loader"],
            },
            {
                test: /\.s[ac]ss$/i,
                use: [MiniCssExtractPlugin.loader, "css-loader", "sass-loader", "postcss-loader"],
            },
            {
                test: /\.png$/i,
                use: ['file-loader']
            }
        ],
    },
    node: {
        __dirname: true
    }
}
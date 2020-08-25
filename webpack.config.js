const path = require('path');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const webpack = require('webpack');
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const autoprefixer = require('autoprefixer');
const { VueLoaderPlugin } = require('vue-loader');
const TerserPlugin = require('terser-webpack-plugin');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const ManifestPlugin = require('webpack-manifest-plugin');

module.exports = (env, options) => {
    let devHost = 'http://localhost';
    var baseDir = process.env.DIR;
    const isProduction = process.env.NODE_ENV === 'production';

    var cssLoaders = [isProduction ? {
        loader: MiniCssExtractPlugin.loader,
        options: {
            hmr: !isProduction,
            reloadAll: !isProduction,
        }
    } : 'style-loader', 'css-loader', 'postcss-loader'];
    var sassLoaders = cssLoaders.slice();
    sassLoaders.push('sass-loader');

    var plugins = [
        new CleanWebpackPlugin(),
        new ManifestPlugin({
            fileName: 'mix-manifest.json'
        }),
        new VueLoaderPlugin(),
        new MiniCssExtractPlugin({
            filename: isProduction ? '[name].[hash].css' : '[name].css',
            chunkFilename: isProduction ? '[id].[hash].css' : '[id].css',
        }),
    ];
    if(isProduction){
        plugins.push(
            new OptimizeCSSAssetsPlugin({}),
            new webpack.optimize.ModuleConcatenationPlugin(),

            new webpack.LoaderOptionsPlugin({
                options: {
                    postcss: [
                        autoprefixer()
                    ]
                }
            }),
        );
    }

    var portPropIndex = process.argv.indexOf('--port') + 1;
    var port = process.argv[portPropIndex];

    const jsLoaders = () => ['babel-loader', 'eslint-loader'];

    return {
        entry: path.resolve(__dirname, './' + baseDir + '/main.js'),
        mode: isProduction ? 'production' : 'development',
        output: {
            filename: isProduction ? '[name].[hash].js' : '[name].js',
            path: path.resolve(__dirname, './public/' + baseDir),
            publicPath: options.mode === 'production' ? '/' + baseDir + '/' : devHost + ':' + port + '/dist/',
            chunkFilename: "js/chunks/[id].chunk.js?id=[chunkhash]",
        },

        module: {
            rules: [
                {
                    test: /\.scss/,
                    use: sassLoaders
                },
                {
                    test: /\.vue$/,
                    loader: 'vue-loader',
                    options: {
                        loaders: {
                            css: cssLoaders,
                            js: jsLoaders(),
                        }
                    }
                },
                {
                    test: /\.js$/,
                    use: jsLoaders(),
                    exclude: /node_modules/,
                },
                {
                    test: /\.css/,
                    use: cssLoaders
                },
                {
                    test: /\.(png|jpg|gif|svg|webp)$/,
                    loader: 'file-loader',
                    options: {
                        name: '[name].[hash].[ext]'
                    }
                },
                {
                    test: /\.(ttf|eot|gif|woff|woff2)(\?v=[0-9]\.[0-9]\.[0-9])?$/,
                    use: [{
                        loader: 'file-loader'
                    }]
                },
            ]
        },

        devServer: {
            overlay: true,
            headers: {
                'Access-Control-Allow-Origin': '*'
            },

            disableHostCheck: true,
            hot: true,
            historyApiFallback: true,
        },

        resolve: {
            alias: {
                'vue$': 'vue/dist/vue.esm.js'
            },
            extensions: ['.js', '.vue', '.json']
        },

        devtool: isProduction ? false : 'source-map',

        plugins,
        cache: !isProduction,

        optimization: {
            minimize: isProduction,
            minimizer: [new TerserPlugin()],
        },
    };
};

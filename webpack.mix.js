const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');

//　icon用に追加してもダメ
// module.exports = {
//     module: {
//         rules: [
//         {
//             test: /\.css$/,
//                 use:[{
//             loader: "css-loader"
//         }]
//         },
//             {
//                 test: /\.svg(\?v=\d+\.\d+\.\d+)?$/,
//                 use: [{
//                     loader: 'url-loader?mimetype=image/svg+xml'
//                 }],
//             },
//             {
//                 test: /\.woff(\d+)?(\?v=\d+\.\d+\.\d+)?$/,
//                 use: [{
//                     loader: 'url-loader?mimetype=application/font-woff'
//                 }],
//             },
//             {
//                 test: /\.eot(\?v=\d+\.\d+\.\d+)?$/,
//                 use: [{
//                     loader: 'url-loader?mimetype=application/font-woff'
//                 }],
//             },
//             {
//                 test: /\.ttf(\?v=\d+\.\d+\.\d+)?$/,
//                 use: [{
//                     loader: 'url-loader?mimetype=application/font-woff'
//                 }],
//             },
//         ]
//     },
// };
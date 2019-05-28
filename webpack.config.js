const webpack = require('webpack');
const path = require('path');

const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CleanWebpackPlugin = require('clean-webpack-plugin');
const OptimizeCssAssetsPlugin = require('optimize-css-assets-webpack-plugin');

// directories
const srcDir = path.join(__dirname, 'client-side');
let distDir = path.join(__dirname, 'assets');

module.exports = (env, argv) => {
	const production = argv.mode === 'production';

	if (!production) {
		distDir = path.join(__dirname, '../../../../www/assets');
	}

	const options = {
		entry: {
			admin: path.join(srcDir, 'index.js')
		},
		output: {
			path: distDir,
			filename: '[name].js'
		},
		resolve: {
			extensions: [ '.js' ]
		},
		module: {
			rules: [
				{
					test: /\.js?$/,
					exclude: [/node_modules/],
					loader: 'babel-loader',
					query: {
						plugins: [
							'@babel/plugin-proposal-nullish-coalescing-operator',
							'@babel/plugin-proposal-optional-chaining',
							'@babel/plugin-proposal-private-methods',
							'@babel/plugin-proposal-class-properties',
						],
						presets: [
							[
								'@babel/preset-env', {
									useBuiltIns: 'usage',
									targets: {
										ie: '11',
										chrome: '58',
										safari: '9'
									},
									corejs: 2,
								}
							]
						]
					},
				},
				{
					test: /\.s?css$/,
					use: [
						MiniCssExtractPlugin.loader,
						{
							loader: 'css-loader'
						},
						{
							loader: 'sass-loader'
						},
					]
				},
				{
					test: /\.(ttf|eot|svg|woff|woff2)(\?[\s\S]+)?$/,
					use: 'file-loader',
				},
				{
					test: /\.(jpe?g|png|gif|svg)$/i,
					use: [
						'file-loader?name=images/[name].[ext]',
					]
				},
			]
		},
		plugins: [
			new MiniCssExtractPlugin({
				filename: '[name].css',
			}),
			new CleanWebpackPlugin(),
		]
	};

	if (production) {
		options.plugins.push(new OptimizeCssAssetsPlugin());
	}

	return options;
};

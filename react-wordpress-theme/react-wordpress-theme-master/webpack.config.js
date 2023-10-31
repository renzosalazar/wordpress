const HtmlWebPackPlugin = require( 'html-webpack-plugin' );
const path = require( 'path' );
const CopyPlugin = require( 'copy-webpack-plugin' );

/**
 * Webpack module exports.
 *
 * @type {Object}
 */
module.exports = {
	context: __dirname,
	entry: './src/index.js',
	output: {
		path: path.resolve( __dirname, 'build' ),
		filename: 'main.js',
		publicPath: '/',
	},
	devServer: {
		historyApiFallback: true,
	},
	module: {
		rules: [
			{
				test: /\.js?$/,
				exclude: /node_modules/,
				use: 'babel-loader',
			},
			{
				test: /node_modules[/\\]jsonstream/i,
				loader: 'shebang-loader',
			},
			{
				test: /\.s[ac]ss$/i,
				use: [
					// Creates `style` nodes from JS strings
					'style-loader',
					// Translates CSS into CommonJS
					'css-loader',
					// Compiles Sass to CSS
					'sass-loader',
				],
			},
			{
				test: /\.(png|jp?g|svg|gif)$/,
				use: [
					{
						loader: 'file-loader',
						options: {
							name: '[name].[ext]',
							outputPath: 'images/',
							publicPath: 'images/',
						},
					},
				],
			},
		],
	},
	plugins: [
		new HtmlWebPackPlugin( {
			template: path.resolve( __dirname, 'public/index.html' ),
			filename: 'index.html',
		} ),

		new CopyPlugin( [
			{ from: './src/lib', to: path.resolve( __dirname, 'build/lib' ) },
			{
				from: './src/external/gutenberg.css',
				to: path.resolve( __dirname, 'build/' ),
			},
		] ),
	],
};

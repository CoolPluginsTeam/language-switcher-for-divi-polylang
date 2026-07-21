const fs = require( 'fs' );
const path = require( 'path' );

const srcDir = path.resolve( __dirname, 'src' );
const pluginRoot = path.resolve( __dirname, '../..' );

/**
 * Recursively collect all JS/JSX files under src/.
 *
 * @param {string} dir
 * @param {string[]} files
 * @return {string[]}
 */
function collectSrcFiles( dir, files = [] ) {
	for ( const entry of fs.readdirSync( dir, { withFileTypes: true } ) ) {
		const fullPath = path.join( dir, entry.name );

		if ( entry.isDirectory() ) {
			collectSrcFiles( fullPath, files );
			continue;
		}

		if ( /\.(js|jsx)$/i.test( entry.name ) ) {
			files.push( fullPath );
		}
	}

	return files;
}

const srcFiles = collectSrcFiles( srcDir ).map( ( filePath ) =>
	'./' + path.relative( __dirname, filePath ).split( path.sep ).join( '/' )
);

// Keep the real bootstrap first; remaining src files are forced into the graph
// so nothing under src/ is left out of the build even if forgotten in imports.
const entryFiles = [
	'./src/index.jsx',
	...srcFiles.filter( ( filePath ) => filePath !== './src/index.jsx' ),
];

module.exports = ( env, argv ) => {
	const isProduction = argv.mode === 'production';

	return {
		entry: {
			bundle: entryFiles,
		},

		context: __dirname,

		externals: {
			underscore: '_',
			react: [ 'vendor', 'React' ],
			'react-dom': [ 'vendor', 'ReactDOM' ],
			jquery: 'jQuery',
			'@wordpress/hooks': [ 'vendor', 'wp', 'hooks' ],
			'@wordpress/i18n': [ 'vendor', 'wp', 'i18n' ],
		},

		module: {
			rules: [
				{
					test: /\.jsx?$/,
					exclude: /node_modules/,
					use: [
						{
							loader: 'thread-loader',
							options: {
								workers: -1,
							},
						},
						{
							loader: 'babel-loader',
							options: {
								compact: isProduction,
								presets: [
									[
										'@babel/preset-env',
										{
											modules: false,
											targets: '> 5%',
										},
									],
									'@babel/preset-react',
								],
								cacheDirectory: ! isProduction,
							},
						},
					],
				},
				{
					test: /\.json$/,
					type: 'json',
				},
			],
		},

		resolve: {
			extensions: [ '.js', '.jsx', '.json' ],
			alias: {
				'@lsdp/shared': path.join( pluginRoot, 'includes/modules/render_content' ),
			},
		},

		output: {
			filename: 'language-switcher-for-divi-polylang-build.js',
			path: path.resolve( __dirname, 'build' ),
			clean: true,
		},

		devtool: isProduction ? false : 'source-map',

		stats: {
			errorDetails: true,
			modules: true,
			moduleAssets: false,
			nestedModules: false,
			modulesSpace: 50,
		},

		plugins: [
			{
				apply( compiler ) {
					compiler.hooks.done.tap( 'LSDPListSrcModules', ( stats ) => {
						if ( stats.hasErrors() ) {
							return;
						}

						console.log( '\nIncluded src files:' );
						srcFiles.forEach( ( filePath ) => console.log( `  ${ filePath }` ) );
						console.log(
							`\nOutput: build/language-switcher-for-divi-polylang-build.js (${ srcFiles.length } src files)\n`
						);
					} );
				},
			},
		],
	};
};

const esbuild = require('esbuild');
const { sassPlugin } = require('esbuild-sass-plugin');
const stylePlugin = require('esbuild-style-plugin');

// Bundler options common to all bundle jobs.
const options = {
  outdir: './dist',
  bundle: true,
  minify: true,
  sourcemap: 'external',
  sourcesContent: false,
  logLevel: 'error',
};

// Get CLI arguments for optional overrides.
const ARGS = process.argv.slice(2);


/**
 * Bundle Core StatusPage JavaScript.
 */
async function bundleStatusPage() {
  const entryPoints = {
    statuspage: 'src/index.ts',
    'statuspage-alpine': 'src/alpine/index.ts',
  };
  try {
    const result = await esbuild.build({
      ...options,
      entryPoints,
      target: 'es2018',
    });
    if (result.errors.length === 0) {
      for (const [targetName, sourceName] of Object.entries(entryPoints)) {
        const source = sourceName.split('/')[1];
        console.log(`✅ Bundled source file '${source}' to '${targetName}.js'`);
      }
    }
  } catch (err) {
    console.error(err);
  }
}

/**
 * Run script bundle jobs.
 */
async function bundleScripts() {
  for (const bundle of [bundleStatusPage]) {
    await bundle();
  }
}

/**
 * Bundle Tailwind Styles
 */
async function bundleTailwindStyles() {
  try {
    const entryPoints = {
      'statuspage-tailwind': 'styles/styles.css',
      'statuspage-ss-select-styles': 'styles/select-styles.css',
    };
    const pluginOptions = {
      postcss: {
        plugins: [require('tailwindcss'), require('autoprefixer')],
      },
    };
    let result = await esbuild.build({
      ...options,
      // Disable sourcemaps for CSS/SCSS files
      sourcemap: false,
      entryPoints,
      plugins: [stylePlugin(pluginOptions)],
      loader: {
        '.eot': 'file',
        '.woff': 'file',
        '.woff2': 'file',
        '.svg': 'file',
        '.ttf': 'file',
      },
    });
    if (result.errors.length === 0) {
      for (const [targetName, sourceName] of Object.entries(entryPoints)) {
        const source = sourceName.split('/')[1];
        console.log(`✅ Bundled source file '${source}' to '${targetName}.css'`);
      }
    }
  } catch (err) {
    console.error(err);
  }
}

/**
 * Bundle SASS Styles
 */
async function bundleSassStyles() {
  try {
    const entryPoints = {
      'statuspage': 'styles/_statuspage.scss',
      'statuspage-external': 'styles/_external.scss',
    };
    const pluginOptions = { outputStyle: 'compressed' };
    // Allow cache disabling.
    if (ARGS.includes('--no-cache')) {
      pluginOptions.cache = false;
    }
    let result = await esbuild.build({
      ...options,
      // Disable sourcemaps for CSS/SCSS files
      sourcemap: false,
      entryPoints,
      plugins: [sassPlugin(pluginOptions)],
      loader: {
        '.eot': 'file',
        '.woff': 'file',
        '.woff2': 'file',
        '.svg': 'file',
        '.ttf': 'file',
      },
    });
    if (result.errors.length === 0) {
      for (const [targetName, sourceName] of Object.entries(entryPoints)) {
        const source = sourceName.split('/')[1];
        console.log(`✅ Bundled source file '${source}' to '${targetName}.css'`);
      }
    }
  } catch (err) {
    console.error(err);
  }
}

/**
 * Run style bundle jobs.
 */
async function bundleStyles() {
  for (const bundle of [bundleTailwindStyles, bundleSassStyles]) {
    await bundle();
  }
}

/**
 * Run all bundle jobs.
 */
async function bundleAll() {
  if (ARGS.includes('--styles')) {
    // Only run style jobs.
    return await bundleStyles();
  } else if (ARGS.includes('--scripts')) {
    // Only run script jobs.
    return await bundleScripts();
  }
  await bundleStyles();
  await bundleScripts();
}

bundleAll();

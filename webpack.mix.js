let mix = require('laravel-mix');
require('laravel-mix-polyfill');

const dest = 'public';

mix
  .setPublicPath(dest)
  .js('resources/js/app.js', `${dest}/js/app.js`)
  .polyfill({
    enabled: true,
    useBuiltIns: 'usage',
    targets: false,
    corejs: 3
  })
  .extract()
  .options({ processCssUrls: false })
  .sass('resources/scss/app.scss', `${dest}/css/app.css`)
  .copyDirectory(
    'node_modules/@fortawesome/fontawesome-free/webfonts',
    'public/vendor/fonts/fontawesome-free'
  )
  .disableNotifications();

if (mix.inProduction) {
  mix.version();
}

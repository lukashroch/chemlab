let mix = require('laravel-mix');

const dest = 'public';

mix
  .setPublicPath(dest)
  .js('resources/js/app.js', `${dest}/js/app.js`)
  .vue()
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

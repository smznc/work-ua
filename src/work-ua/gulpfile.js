const gulp = require('gulp');
const uglify = require('gulp-uglify');
const tap = require('gulp-tap');
const buffer = require('gulp-buffer');
const browserify = require('browserify');
const babelify = require('babelify');
const sass = require('gulp-sass')(require('sass'));
const autoprefixer = require('gulp-autoprefixer');
const clean_css = require('gulp-clean-css');
const rename = require('gulp-rename');

const PATH = {};

/*
 * Base PATH
 */
PATH.assets = {
  src: __dirname + '/assets/src', dist: __dirname + '/assets/dist',
};

/*
 * Styles PATH
 */
PATH.styles = {
  src: [
    PATH.assets.src + '/styles/main.scss',
  ], watch: [PATH.assets.src + '/styles/**/*.scss'],
};

/*
 * Styles Vendor PATH
 */
PATH.styles_vendor = {
  src: [PATH.assets.src + '/styles/vendor/*'],
  watch: [PATH.assets.src + '/styles/vendor/*'],
};

/*
 * Scripts PATH
 */
PATH.scripts = {
  src: [
    PATH.assets.src + '/scripts/main.js',
  ], watch: [PATH.assets.src + '/scripts/**/*.js'],
};

/*
 * Scripts Vendor PATH
 */
PATH.scripts_vendor = {
  src: [PATH.assets.src + '/scripts/vendor/*'],
  watch: [PATH.assets.src + '/scripts/vendor/*'],
};

/*
 * Tasks
 */
const scripts_vendor = () => {
  return (
      gulp.src(PATH.scripts_vendor.src).
          pipe(gulp.dest(
              file => file.base.replace(PATH.assets.src, PATH.assets.dist)))
  );
};

const scripts = () => {
  return (
      gulp.src(PATH.scripts.src, {read: false}).
          pipe(tap((file) => {
            file.contents = browserify(file.path).transform(babelify, {
              presets: ['@babel/preset-env'],
            }).bundle();
          })).
          pipe(buffer()).
          pipe(uglify()).
          pipe(rename({suffix: '.min'})).
          pipe(gulp.dest(
              file => file.base.replace(PATH.assets.src, PATH.assets.dist)))
  );
};

exports.scripts = gulp.series(scripts_vendor, scripts);

const styles_vendor = () => {
  return (
      gulp.src(PATH.styles_vendor.src).
          pipe(gulp.dest(
              file => file.base.replace(PATH.assets.src, PATH.assets.dist)))
  );
};

const styles = () => {
  return (
      gulp.src(PATH.styles.src).
          pipe(sass()).
          pipe(autoprefixer({
            cascade: false,
          })).
          pipe(clean_css()).
          pipe(rename({suffix: '.min'})).
          pipe(gulp.dest(
              file => file.base.replace(PATH.assets.src, PATH.assets.dist)))
  );
};

exports.styles = gulp.series(styles_vendor, styles);

const watch = () => {
  gulp.watch(PATH.scripts_vendor.watch, scripts_vendor);
  gulp.watch(PATH.scripts.watch, scripts);
  gulp.watch(PATH.styles_vendor.watch, styles_vendor);
  gulp.watch(PATH.styles.watch, styles);
};

exports.default = gulp.series(
    gulp.parallel(scripts_vendor, scripts, styles_vendor, styles), watch);

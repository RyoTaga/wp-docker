const gulp = require('gulp');
const $ = require("gulp-load-plugins")();

const Path = {
  SCSS: 'src/scss/',
  DIST: './',
};

const tasks = [
  'scss',
];

const outputStyle =  'compressed';

gulp.task('scss', () => {
  gulp.src(`${Path.SCSS}style.scss`)
    .pipe($.plumber())
    .pipe($.sourcemaps.init())
    .pipe($.sass({
      outputStyle,
    }))
    .pipe($.autoprefixer({
      browsers: ['last 3 version', 'ie >= 8'],
    }))
    .pipe($.sourcemaps.write('./'))
    .pipe(gulp.dest(`${Path.DIST}css/`));
});

gulp.task('default', tasks, () => {
  gulp.watch([`${Path.SCSS}**.scss`, `${Path.SCSS}**/**.scss`], ['scss']);
});

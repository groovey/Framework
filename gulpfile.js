/*
| -------------------------------------------------------------------
| Automated and enhanced workflow
| -------------------------------------------------------------------
| $ gulp
*/

var gulp         = require('gulp');
var del          = require('del');
var argv         = require('yargs').argv;
var imagemin     = require('gulp-imagemin');
var gulpif       = require('gulp-if');
var autoprefixer = require('gulp-autoprefixer');
var minifycss    = require('gulp-minify-css');
var stripdebug   = require('gulp-strip-debug');
var rename       = require('gulp-rename');
var jshint       = require('gulp-jshint');
var jslint       = require('gulp-jslint');
var changed      = require('gulp-changed');
var cache        = require('gulp-cache');
var concat       = require('gulp-concat');
var uglify       = require('gulp-uglify');
var gutil        = require('gulp-util');
var notify       = require('gulp-notify');
var plumber      = require('gulp-plumber');
var sass         = require('gulp-sass');
var phpcs        = require('gulp-phpcs');
var shell        = require('gulp-shell');
var sourcemaps   = require('gulp-sourcemaps');

/*
| -------------------------------------------------------------------
| Deletes all specific directores.
| -------------------------------------------------------------------
| $ gulp clean
*/
gulp.task('clean', function(cb) {
    del([
            './public/css',
            './public/js',
            './public/images',
            './public/bootstrap',
            './public/groovey',
    ], cb);
});

/*
| -------------------------------------------------------------------
| Compiles all js file that includes strip debugin, uglify and jshit.
| -------------------------------------------------------------------
| $ gulp js --production
*/
gulp.task('js', function() {
    gulp.src('./resources/js/**/*.js')
        .pipe(jshint())
        .pipe(jshint.reporter('default'))
        .pipe(gulpif(argv.production, stripdebug()))
        .pipe(gulpif(argv.production, uglify()))
        .pipe(gulp.dest('./public/js'));
});

/*
| -------------------------------------------------------------------
| Minify css files.
| -------------------------------------------------------------------
| $ gulp css --production
*/
gulp.task('css', function() {

    gulp.src('./resources/sass/**/*.scss')
        .pipe(plumber())
        .pipe(sourcemaps.init())
        .pipe(sass())
        .on('error', function(err) {
            console.log(err);
            this.emit('end');
        })
        .pipe(gulpif(argv.production, minifycss()))
        .pipe(gulpif(!argv.production, sourcemaps.write('./')))
        .pipe(gulp.dest('./public/css/'));

});

/*
| -------------------------------------------------------------------
| Move all images to public folder.
| -------------------------------------------------------------------
| $ gulp images
*/
gulp.task('images', function() {

    var src  = './resources/images/**/*';
    var dist = './public/images';

    gulp.src(src)
        .pipe(changed(dist))
        .pipe(gulp.dest(dist));
});

/*
| -------------------------------------------------------------------
| Compression for images.
| -------------------------------------------------------------------
| $ gulp imagemin
*/
gulp.task('imagemin', function() {

    var imagemin = require('gulp-imagemin');

    var src  = './resources/images/**/*';
    var dist = './public/images';

    gulp.src(src)
        .pipe(changed(dist))
        .pipe(imagemin({
            optimizationLevel: 3,
            progressive: true,
            interlaced: true
        }))
        .pipe(gulp.dest(dist));
});

/*
| -------------------------------------------------------------------
| File watcher.
| -------------------------------------------------------------------
| $ gulp watch
*/
gulp.task('watch', function() {
    gulp.watch('./resources/js/*.js', ['js']);
    gulp.watch('./resources/sass/**/*.scss', ['css']);
    gulp.watch('./resources/images/*.*', ['images']);
});

/*
| -------------------------------------------------------------------
| Default calling of gulp.
| -------------------------------------------------------------------
| $ gulp --production
*/
gulp.task('default', ['clean'], function() {
    gulp.start('js', 'css', 'images');
});

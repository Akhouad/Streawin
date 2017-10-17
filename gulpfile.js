var gulp = require("gulp");
gulp.task("default", function(){});

var dist = "./public/dist";
var src = "./public/src";
var views = "./App/Views/";

// gulp modules
var compass = require('gulp-compass');
var cssmin = require('gulp-cssmin');
var rename = require('gulp-rename');
var livereload = require('gulp-livereload');
 

 // compass
gulp.task('compass', function() {
  gulp.src(src + '/sass/**/*.scss')
    .pipe(compass({
      css: dist + '/css',
      sass: src + '/sass'
    }))
    .pipe(gulp.dest(dist + "/css/"));
});
 

 // css minifier
gulp.task('css-minify', function () {
  gulp.src(dist + "/css/*.css")
		.pipe(cssmin())
		.pipe(rename({suffix: '.min'}))
		.pipe(gulp.dest(dist + "/css/min/"));
});


// live reload
gulp.task('updated', function() {
  gulp.src([dist + '/css/style.css', 'index.html', 'index.php'])
    .pipe(livereload());
});
 

 // gulp watch
gulp.task('watch', function () {
  gulp.watch(src + '/sass/**/*.scss', ['compass']);
  // gulp.watch(dist + "/css/*.css", ['css-minify']);
  livereload.listen();
  gulp.watch([dist + '/css/style.css', 'index.html', 'index.php'],
   ['updated']);
});
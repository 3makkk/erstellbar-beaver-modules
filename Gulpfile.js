var gulp = require('gulp');
var $ = require('gulp-load-plugins');

var config = {
    "css" : [
        "assets/components/slick-carousel/slick/*.css"
    ],
    "js": [
        "assets/components/slick-carousel/slick/*.min.js"
    ]
};

gulp.task('copy', function() {
    gulp.src(config.css)
        .pipe(gulp.dest('./assets/css'));

    gulp.src(config.js)
        .pipe(gulp.dest('./assets/js'));
});



gulp.task('default', ['copy', 'copy']);
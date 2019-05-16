
var gulp = require('gulp'),
    vars = require('../variables');

gulp.task('default', function () {

    gulp.start('sprite-normal');
    gulp.start('js:build');
    gulp.start('image:build');
    gulp.start('style:build');

    //gulp.start('html:build');
    //gulp.start('webserver');

    gulp.watch(vars.watch.js, ['js:build']);
    gulp.watch(vars.watch.styles, ['style:build']);
    gulp.watch(vars.src.img, ['image:build']);
    //gulp.watch(vars.watch.html, ['html:build']);

    gulp.watch(['src/sprite/*.png'], ['sprite-normal']);

});
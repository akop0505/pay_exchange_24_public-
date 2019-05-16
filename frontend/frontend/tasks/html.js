'use strict';

var gulp = require('gulp'),
    browserSync = require('browser-sync'),
    reload = browserSync.reload,
    rigger = require('gulp-rigger'),
    vars = require('../variables');

gulp.task('html:build', function () {
    gulp.src(vars.src.html)
        .pipe(rigger())
        .pipe(gulp.dest(vars.build.html))
        .pipe(reload({stream: true}));
});
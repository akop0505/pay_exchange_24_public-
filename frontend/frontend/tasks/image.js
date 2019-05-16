'use strict';

var gulp = require('gulp'),
    browserSync = require('browser-sync'),
    reload = browserSync.reload,
    rename = require('gulp-rename'),
    vars = require('../variables');

gulp.task('image:build', function () {
    gulp.src(vars.src.img)
        .pipe(rename({dirname: ''}))
        .pipe(gulp.dest(vars.build.img))
        .pipe(reload({stream: true}));
});
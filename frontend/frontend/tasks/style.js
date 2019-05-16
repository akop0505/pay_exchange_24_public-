'use strict';

var gulp = require('gulp'),
    prefixer = require('gulp-autoprefixer'),
    browserSync = require('browser-sync'),
    reload = browserSync.reload,
    sass = require('gulp-sass'),
    cssmin = require('gulp-minify-css'),
    rename = require('gulp-rename'),
    vars = require('../variables');

gulp.task('style:build', function () {
    gulp.src(vars.src.styles)
        .pipe(sass({
            sourceMap: true,
            errLogToConsole: false,
        }))
        .on('error', function (er) {
            console.log(er);
        })
        .pipe(prefixer())
        .pipe(cssmin())
        .pipe(rename('main.css'))
        .pipe(gulp.dest(vars.build.css))
        .pipe(reload({stream: true}));
});
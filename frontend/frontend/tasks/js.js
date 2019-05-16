'use strict';

var gulp = require('gulp'),
    rigger = require('gulp-rigger'),
    browserSync = require('browser-sync'),
    uglify = require('gulp-uglify'),
    reload = browserSync.reload,
    sourcemaps = require('gulp-sourcemaps'),
    babel = require("gulp-babel"),
    vars = require('../variables');

gulp.task('js:build', function () {
    gulp.src(vars.src.js)
        .pipe(sourcemaps.init())
        .pipe(rigger())
        .pipe(babel())
        /*.pipe(uglify().on('error', function(e){
            console.log(e);
        }))*/
        .pipe(sourcemaps.write())
        .pipe(gulp.dest(vars.build.js));
});
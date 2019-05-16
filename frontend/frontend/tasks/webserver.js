'use strict';

var gulp = require('gulp'),
    browserSync = require('browser-sync'),
    vars = require('../variables');

gulp.task('webserver', function () {
    browserSync(vars.config);
});
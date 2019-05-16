'use strict';

/**
 * Создание спрайта
 */

var gulp = require('gulp'),
    buffer = require('vinyl-buffer'),
    spritesmith = require('gulp.spritesmith'),
    newer = require('gulp-newer'),
    imagemin = require('gulp-imagemin');


gulp.task('sprite-normal', function () {
    var spriteData;

    spriteData = gulp.src('src/sprite/*.png')
        .pipe(newer('../web/images/sprite.png'))
        .pipe(spritesmith({
            imgPath: '../images/sprite.png',
            imgName: 'sprite.png',
            cssName: 'sprite.scss',
            padding: 2
        }));

    spriteData.img
        .pipe(buffer())
        //.pipe(imagemin())
        .pipe(gulp.dest('../web/images/'));

    spriteData.css
        .pipe(gulp.dest('src/styles'));

    return spriteData;
});
module.exports = {
    build: {
        html: 'build/',
        img: '../web/images/',
        js: '../web/js/',
        css: '../web/css/'
    },
    src: {
        html: 'src/html/*.html',
        js: ['src/js/main.js'],
        img: ['src/images/*.*'],
        styles: ['src/styles/main.scss']
    },
    watch: {
        html: ['src/html/*/*.html', 'src/html/*.html'],
        img: ['src/images/*.*'],
        js: ['src/js/*.js' , 'src/js/app/*.js'],
        styles: ['src/styles/*.scss', 'src/styles/*/*.scss']
    },
    clean: './build',
    config: {
        server: {
            baseDir: './build'
        },
        tunnel: false,
        host: 'localhost',
        port: 9000,
        logPrefix: "alar"
    }
};
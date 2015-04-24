var gulp = require( 'gulp' ),
    plumber = require( 'gulp-plumber' ),
    watch = require( 'gulp-watch' ),
    livereload = require( 'gulp-livereload' ),
    minifycss = require( 'gulp-minify-css' ),
    jshint = require( 'gulp-jshint' ),
    stylish = require( 'jshint-stylish' ),
    uglify = require( 'gulp-uglify' ),
    rename = require( 'gulp-rename' ),
    include = require( 'gulp-include' ),
    sass = require( 'gulp-sass' );

var onError = function( err ) {
    console.log( 'An error occurred:', err );
    console.log(err);
    this.emit( 'end' );
};

gulp.task( 'scss', function() {
    return gulp.src( './sass/style.scss' )
        .pipe( plumber( { errorHandler: onError } ) )
        .pipe( sass() )
        .pipe( minifycss() )
        //.pipe( rename( { suffix: '.min' } ) )
        .pipe( gulp.dest( '.' ) )
        .pipe( livereload() );
} );


gulp.task( 'jshint', function() {
    return gulp.src( './js/src/*.js' )
        .pipe( jshint( '.jshintrc' ) )
        .pipe( jshint.reporter( stylish ) )
        .pipe( jshint.reporter( 'fail' ) );
});

gulp.task( 'js_main', function() {
    return gulp.src( './js/manifest_main.js' )
        .pipe( include() )
        .pipe( rename( { basename: 'main' } ) )
        .pipe( gulp.dest( './js/dist' ) )
        .pipe( uglify() )
        .pipe( rename( { suffix: '.min' } ) )
        .pipe( gulp.dest( './js/dist' ) )
        .pipe( livereload() );
} );

gulp.task( 'js_single', function() {
    return gulp.src( './js/manifest_single.js' )
        .pipe( include() )
        .pipe( rename( { basename: 'single' } ) )
        .pipe( gulp.dest( './js/dist' ) )
        .pipe( uglify() )
        .pipe( rename( { suffix: '.min' } ) )
        .pipe( gulp.dest( './js/dist' ) )
        .pipe( livereload() );
} );

gulp.task( 'watch', function() {
    livereload.listen();
    gulp.watch( './sass/**/*.scss', [ 'scss' ] );
    gulp.watch( './js/dev/**/*.js', [ 'js_single' ] );

    gulp.watch( './**/*.php' ).on( 'change', function( file ) {
        livereload.changed( file );
    } );
} );

gulp.task( 'default', ['watch'], function() {
} );
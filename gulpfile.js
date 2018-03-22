// Load Gulp...of course
var gulp = require('gulp');

// CSS related plugins
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');
var minifycss = require('gulp-uglifycss');

// JS related plugins
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var babelify = require('babelify');
var browserify = require('browserify');
var source = require('vinyl-source-stream');
var buffer = require('vinyl-buffer');
var stripDebug = require('gulp-strip-debug');

// Utility plugins
var rename = require('gulp-rename');
var sourcemaps = require('gulp-sourcemaps');
var notify = require('gulp-notify');
var plumber = require('gulp-plumber');
var options = require('gulp-options');
var gulpif = require('gulp-if');

// Browers related plugins
var browserSync = require('browser-sync').create();
var reload = browserSync.reload;

// Project related variables
var projectURL = 'http://localhost/plugin/';

var styleName = "style";
var scriptName = "script";

var styleSRCAdmin = 'src/admin/scss/' + styleName + '.scss';
var styleURLAdmin = './assets/admin/';
var mapURL = './';

var jsSRCAdmin = 'src/admin/js/' + scriptName + '.js';
var jsURLAdmin = './assets/admin/';

var styleWatchAdmin = 'src/admin/scss/**/*.scss';
var jsWatchAdmin = 'src/admin/js/**/*.js';


var styleSRC = 'src/front/scss/' + styleName + '.scss';
var styleURL = './assets/front/';


var jsSRC = 'src/front/js/' + scriptName + '.js';
var jsURL = './assets/front/';

var styleWatch = 'src/front/scss/**/*.scss';
var jsWatch = 'src/front/js/**/*.js';


var phpWatch = '**/*.php';

// Tasks
gulp.task('browser-sync', function () {
	browserSync.init({
		proxy: projectURL,
		injectChanges: true
	});
});

gulp.task('adminStyles', function () {
	gulp.src(styleSRCAdmin)
		.pipe(sourcemaps.init())
		.pipe(sass({
			errLogToConsole: true,
			outputStyle: 'compressed'
		}))
		.on('error', console.error.bind(console))
		.pipe(autoprefixer({
			browsers: ['last 2 versions', '> 5%', 'Firefox ESR']
		}))
		.pipe(sourcemaps.write(mapURL))
		.pipe(gulp.dest(styleURLAdmin))
		.pipe(browserSync.stream());
});

gulp.task('frontStyles', function () {
	gulp.src(styleSRC)
		.pipe(sourcemaps.init())
		.pipe(sass({
			errLogToConsole: true,
			outputStyle: 'compressed'
		}))
		.on('error', console.error.bind(console))
		.pipe(autoprefixer({
			browsers: ['last 2 versions', '> 5%', 'Firefox ESR']
		}))
		.pipe(sourcemaps.write(mapURL))
		.pipe(gulp.dest(styleURL))
		.pipe(browserSync.stream());
});

gulp.task('adminJs', function () {
	return browserify({
			entries: [jsSRCAdmin]
		})
		.transform(babelify, {
			presets: ['env']
		})
		.bundle()
		.pipe(source(scriptName + '.js'))
		.pipe(buffer())
		.pipe(gulpif(options.has('production'), stripDebug()))
		.pipe(sourcemaps.init({
			loadMaps: true
		}))
		.pipe(uglify())
		.pipe(sourcemaps.write('.'))
		.pipe(gulp.dest(jsURLAdmin))
		.pipe(browserSync.stream());
});

gulp.task('frontJs', function () {
	return browserify({
			entries: [jsSRC]
		})
		.transform(babelify, {
			presets: ['env']
		})
		.bundle()
		.pipe(source(scriptName + '.js'))
		.pipe(buffer())
		.pipe(gulpif(options.has('production'), stripDebug()))
		.pipe(sourcemaps.init({
			loadMaps: true
		}))
		.pipe(uglify())
		.pipe(sourcemaps.write('.'))
		.pipe(gulp.dest(jsURL))
		.pipe(browserSync.stream());
});

function triggerPlumber(src, url) {
	return gulp.src(src)
		.pipe(plumber())
		.pipe(gulp.dest(url));
}

gulp.task('default', ['adminStyles', 'adminJs', 'frontStyles', 'frontJs'], function () {
	gulp.src(jsURLAdmin + scriptName +'.min.js')
	gulp.src(jsURL + scriptName +'.min.js')
		.pipe(notify({
			message: 'Assets Compiled!'
		}));
});

gulp.task('watch', ['default', 'browser-sync'], function () {
	gulp.watch(phpWatch, reload);
	gulp.watch(styleWatchAdmin, ['adminStyles']);
	gulp.watch(styleWatch, ['frontStyles']);
	gulp.watch(jsWatchAdmin, ['adminJs', reload]);
	gulp.watch(jsWatch, ['frontJs', reload]);
	gulp.src(jsURLAdmin + scriptName + '.min.js')
	gulp.src(jsURL + scriptName + '.min.js')
		.pipe(notify({
			message: 'Gulp is Watching, Happy Coding!'
		}));
});
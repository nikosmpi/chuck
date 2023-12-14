'use strict';
var gulp = require('gulp');
var sass = require('gulp-sass')(require('sass'));
var uglify = require('gulp-uglify');
var babel = require('gulp-babel');
var webpack = require('webpack-stream');
var autoprefixer = require('gulp-autoprefixer');
var stripCssComments = require('gulp-strip-css-comments');
var sveltePreprocess = require('svelte-preprocess');
var named = require('vinyl-named');

gulp.task('styles', function () {
	return gulp.src('assets/source-scss/*.scss')
		.pipe(stripCssComments())
		.pipe(sass({ outputStyle: 'compressed' }))
		.pipe(autoprefixer({
			cascade: false
		}))
		.pipe(gulp.dest('assets/dist-css'))
});

gulp.task('scripts', function () {
	return gulp.src('assets/source-js/*.js')
		.pipe(named())
		.pipe(
			webpack({
				mode: 'production',
				output: {
					filename: '[name].js',
				},
				module:{
					rules:[{
							test: /\.js$/,
							loader: 'esbuild-loader',
							options: {
								//loader: 'jsx', // Remove this if you're not using JSX
								target: 'es2015' // Syntax to compile to (see options below for possible values)
							}
						},
						{
							test: /\.svelte$/,
							use: {
								loader: 'svelte-loader',
								options: {
									preprocess: sveltePreprocess()
								},
							},
						},
					]
				},
				externals: {
					jquery: 'jQuery'
				}
			})
		)
		.pipe(babel({
			presets: ['@babel/env']
		}))
		.pipe(uglify())
		.pipe(gulp.dest('assets/dist-js'));
});

gulp.task('default', function () {
	gulp.watch('assets/source-scss/**/*.scss', gulp.series('styles'));
	gulp.watch(['assets/source-js/**/*.js', 'assets/source-js/**/*.svelte'], gulp.series('scripts'));
});

gulp.task('build', gulp.series('scripts', 'styles'));
/**
 * Required Modules.
 *
 * @type {Gulp}
 */
const gulp = require('gulp'),
    concat = require('gulp-concat'),
    terser = require('gulp-terser'),
    cleanCSS = require('gulp-clean-css');

/**
 * Source and Destiny directories.
 *
 * @type {string}
 */
const jsDest = 'public/dist/js'
    , cssDest = 'public/dist/css';


/**
 * Compressing *.css files
 */
gulp.task('admin_css', function () {
    return gulp.src(
        [
            'vendor/almasaeed2010/adminlte/plugins/fontawesome-free/css/all.min.css',
            'vendor/almasaeed2010/adminlte/dist/css/adminlte.min.css',
            'vendor/almasaeed2010/adminlte/plugins/bootstrap-switch/css/bootstrap3/bootstrap-switch.css',
        ])
        .pipe(concat('admin_css.min.css'))
        .pipe(cleanCSS({compatibility: 'ie8'}))
        .pipe(gulp.dest(cssDest));
});
gulp.task('admin_css_select2', function () {
    return gulp.src(
        [
            'vendor/almasaeed2010/adminlte/plugins/select2/css/select2.min.css',
            'vendor/almasaeed2010/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css',
        ])
        .pipe(concat('admin_css_select2.min.css'))
        .pipe(cleanCSS({compatibility: 'ie8'}))
        .pipe(gulp.dest(cssDest));
});
gulp.task('admin_css_datatable_css', function () {
    return gulp.src(
        [
            'vendor/almasaeed2010/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css',
            'vendor/almasaeed2010/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css',
            'vendor/almasaeed2010/adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css',
        ])
        .pipe(concat('admin_css_datatable_css.css'))
        .pipe(gulp.dest(cssDest));
});
gulp.task('admin_layout_login_css', function () {
    return gulp.src(
        [
            'vendor/almasaeed2010/adminlte/plugins/fontawesome-free/css/all.min.css',
            'vendor/almasaeed2010/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css',
            'vendor/almasaeed2010/adminlte/dist/css/adminlte.min.css',
        ])
        .pipe(concat('admin_layout_login_css.css'))
        .pipe(gulp.dest(cssDest));
});
gulp.task('admin_toastr_css', function () {
    return gulp.src(
        [
            'vendor/almasaeed2010/adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css',
            'vendor/almasaeed2010/adminlte/plugins/toastr/toastr.min.css',
        ])
        .pipe(concat('admin_toastr_css.css'))
        .pipe(cleanCSS({compatibility: 'ie8'}))
        .pipe(gulp.dest(cssDest));
});
gulp.task('admin_login_css', function () {
    return gulp.src(
        [
            'vendor/almasaeed2010/adminlte/plugins/fontawesome-free/css/all.min.css',
            'vendor/almasaeed2010/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css',
            'vendor/almasaeed2010/adminlte/dist/css/adminlte.min.css',
        ])
        .pipe(concat('admin_login_css.css'))
        .pipe(cleanCSS({compatibility: 'ie8'}))
        .pipe(gulp.dest(cssDest));
});

gulp.task('front_css', function () {
    return gulp.src(
        [
            'node_modules/bootstrap/dist/css/bootstrap.min.css'
        ])
        .pipe(concat('front_css.css'))
        .pipe(cleanCSS({compatibility: 'ie8'}))
        .pipe(gulp.dest(cssDest));
});


/**
 * Compressing *.js files
 */
gulp.task('admin_js', function () {
    return gulp.src(
        [
            'vendor/almasaeed2010/adminlte/plugins/jquery/jquery.min.js',
            'vendor/almasaeed2010/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js',
            'vendor/almasaeed2010/adminlte/dist/js/adminlte.min.js',
            'vendor/almasaeed2010/adminlte/plugins/bootstrap-switch/js/bootstrap-switch.js',
            'vendor/almasaeed2010/adminlte/plugins/jquery-validation/jquery.validate.min.js',
            'vendor/almasaeed2010/adminlte/plugins/jquery-validation/additional-methods.min.js',

        ])
        .pipe(concat('admin_js.min.js'))
        .pipe(terser())
        .pipe(gulp.dest(jsDest));
});
gulp.task('admin_js_select2', function () {
    return gulp.src(
        [
            'vendor/almasaeed2010/adminlte/plugins/select2/js/select2.full.min.js',

        ])
        .pipe(concat('admin_js_select2.min.js'))
        .pipe(terser())
        .pipe(gulp.dest(jsDest));
});
gulp.task('admin_js_datatable_js', function () {
    return gulp.src(
        [
            'vendor/almasaeed2010/adminlte/plugins/datatables/jquery.dataTables.min.js',
            'vendor/almasaeed2010/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js',
            'vendor/almasaeed2010/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js',
            'vendor/almasaeed2010/adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js',
            'vendor/almasaeed2010/adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js',
            'vendor/almasaeed2010/adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js',
            'vendor/almasaeed2010/adminlte/plugins/jszip/jszip.min.js',
            'vendor/almasaeed2010/adminlte/plugins/pdfmake/pdfmake.min.js',
            'vendor/almasaeed2010/adminlte/plugins/pdfmake/vfs_fonts.js',
            'vendor/almasaeed2010/adminlte/plugins/datatables-buttons/js/buttons.html5.min.js',
            'vendor/almasaeed2010/adminlte/plugins/datatables-buttons/js/buttons.print.min.js',
            'vendor/almasaeed2010/adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js',
        ])
        .pipe(concat('admin_js_datatable_js.js'))
        .pipe(terser())
        .pipe(gulp.dest(jsDest));
});
gulp.task('admin_layout_login_js', function () {
    return gulp.src(
        [
            'vendor/almasaeed2010/adminlte/plugins/jquery/jquery.min.js',
            'vendor/almasaeed2010/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js',
            'vendor/almasaeed2010/adminlte/dist/js/adminlte.min.js',
            'vendor/almasaeed2010/adminlte/plugins/jquery-validation/jquery.validate.min.js',
            'vendor/almasaeed2010/adminlte/plugins/jquery-validation/additional-methods.min.js',
            'node_modules/jquery-validation/dist/jquery.validate.min.js',
        ])
        .pipe(concat('admin_layout_login_js.js'))
        .pipe(terser())
        .pipe(gulp.dest(jsDest));
});
gulp.task('admin_toastr_js', function () {
    return gulp.src(
        [
            'vendor/almasaeed2010/adminlte/plugins/sweetalert2/sweetalert2.min.js',
            'vendor/almasaeed2010/adminlte/plugins/toastr/toastr.min.js',
        ])
        .pipe(concat('admin_toastr_js.js'))
        .pipe(terser())
        .pipe(gulp.dest(jsDest));
});
gulp.task('cleave_js', function () {
    return gulp.src(
        [
            'node_modules/cleave.js/dist/cleave.min.js',
        ])
        .pipe(concat('cleave_js.js'))
        .pipe(terser())
        .pipe(gulp.dest(jsDest));
});
gulp.task('admin_login_js', function () {
    return gulp.src(
        [
            'vendor/almasaeed2010/adminlte/plugins/jquery/jquery.min.js',
            'vendor/almasaeed2010/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js',
            'vendor/almasaeed2010/adminlte/dist/js/adminlte.min.js',
        ])
        .pipe(concat('admin_login_js.js'))
        .pipe(terser())
        .pipe(gulp.dest(jsDest));
});
gulp.task('admin_input_mask', function () {
    return gulp.src(
        [
            'vendor/almasaeed2010/adminlte/plugins/moment/moment.min.js',
            'vendor/almasaeed2010/adminlte/plugins/inputmask/jquery.inputmask.min.js',
        ])
        .pipe(concat('admin_input_mask.js'))
        .pipe(terser())
        .pipe(gulp.dest('public/dist/js'));
});
gulp.task('admin_auto_form_format_js', function () {
    return gulp.src(
        [
            'vendor/yjmorales/php-core/src/JS/components/form/auto-phone-format.js',
        ])
        .pipe(concat('admin_auto_form_format_js.js'))
        .pipe(terser())
        .pipe(gulp.dest('public/dist/js'));
});

gulp.task('front_js', function () {
    return gulp.src(['node_modules/bootstrap/dist/js/bootstrap.bundle.min.js',])
        .pipe(concat('front_js.js'))
        .pipe(terser())
        .pipe(gulp.dest(jsDest));
});

gulp.task('front_jquery_js', function () {
    return gulp.src(['node_modules/jquery/dist/jquery.min.js',])
        .pipe(concat('front_jquery_js.js'))
        .pipe(terser())
        .pipe(gulp.dest(jsDest));
});


/**
 * Compressing fonts
 */
gulp.task('fonts', function () {
    return gulp.src(
        [
            'vendor/almasaeed2010/adminlte/plugins/fontawesome-free/webfonts/fa-solid-900.woff2',
            'vendor/almasaeed2010/adminlte/plugins/fontawesome-free/webfonts/fa-regular-400.woff2',
            'vendor/almasaeed2010/adminlte/plugins/fontawesome-free/webfonts/fa-solid-900.woff',
            'vendor/almasaeed2010/adminlte/plugins/fontawesome-free/webfonts/fa-regular-400.woff',
            'vendor/almasaeed2010/adminlte/plugins/fontawesome-free/webfonts/fa-solid-900.ttf',
            'vendor/almasaeed2010/adminlte/plugins/fontawesome-free/webfonts/fa-regular-400.ttf',
        ])
        .pipe(gulp.dest('public/dist/webfonts'));
});


/**
 * Runs all tasks
 */
gulp.task('run', gulp.parallel(
    'admin_css',
    'admin_css_select2',
    'admin_css_datatable_css',
    'admin_layout_login_css',
    'admin_toastr_css',
    'admin_js',
    'admin_js_select2',
    'admin_js_datatable_js',
    'admin_layout_login_js',
    'admin_toastr_js',
    'cleave_js',
    'fonts',
    'admin_login_css',
    'admin_login_js',
    'front_css',
    'front_js',
    'admin_input_mask',
    'admin_auto_form_format_js',
    'front_jquery_js',
));
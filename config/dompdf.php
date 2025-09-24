<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Settings
    |--------------------------------------------------------------------------
    |
    | Set some default values. It is possible to add all defines that can be set
    | in dompdf_config.inc.php. You can also override the entire config file.
    |
    */
    'show_warnings' => false,   // Throw an Exception on warnings from dompdf
    'public_path' => null,  // Override the public path if needed

    /*
    |--------------------------------------------------------------------------
    | Defines
    |--------------------------------------------------------------------------
    |
    | List of constants from dompdf_config.inc.php to be defined before
    | loading dompdf.
    |
    */

    'defines' => [
        /*
         * The location of the DOMPDF font directory
         *
         * The location of the directory where DOMPDF will store fonts.
         * This directory must exist and be writable by the webserver process.
         * *Please note the trailing slash.*
         *
         * Notes regarding fonts:
         * Additional .afm font metrics can be added by executing
         * load_font.php from command line.
         *
         * Only the original "Base 14 fonts" are present on all pdf viewers.
         * Additional fonts must be embedded in the pdf file or the PDF may not
         * display correctly. This can significantly increase file size unless
         * font subsetting is enabled. Before embedding a font please review your
         * license agreement to ensure you have the rights to embed the font. If
         * you don't have a license to embed the font you can purchase one from
         * i.e. Adobe's stores or other vendors. You may also be able to use
         * your operating system's built-in fonts (i.e. if you are using Windows
         * and have the Windows Font Viewer installed, you can use fonts from
         * the Windows fonts directory).
         */
        // "font_dir" => storage_path('fonts/'), // advised by dompdf (https://github.com/dompdf/dompdf/pull/782)

        /*
         * The location of the DOMPDF font cache directory
         *
         * This directory contains the cached font metrics for the fonts used by DOMPDF.
         * This directory can be the same as DOMPDF_FONT_DIR
         *
         * Note: This directory must exist and be writable by the webserver process.
         */
        "font_cache" => storage_path('fonts/'),

        /*
         * The location of a temporary directory.
         *
         * The directory specified must be writeable by the webserver process.
         * The temporary directory is required to download remote images and when
         * using the PFDLib back end.
         */
        "temp_dir" => sys_get_temp_dir(),

        /*
         * ==== IMPORTANT ====
         *
         * dompdf's "chroot": Prepends to all relative URIs, as well as the location of
         * fonts, images, and stylesheets, when input not containing "protocol" part.
         * You can use a single type of path (but not mixed)
         *
         *  + Linux / Unix paths: /var/www, ../$path, ...
         *  + Windows paths: c:\xampp\htdocs, ./$path, ...
         *
         * Both relative and absolute paths are supported for chroot:
         *  + Type 1: absolute paths (recommended)
         *    - value: "/var/www/" or "c:\xampp\htdocs\"
         *    - meaning: chooting on this value
         *    - behavior: input of "/css/style.css" in HTML will be trans to:
         *      "/var/www/css/style.css" or "c:\xampp\htdocs\css\style.css"
         *    - current relative paths will be relative to chroot
         *
         *  + Type 2: relative paths
         *    - value: "../app/" or "./"
         *    - meaning: current directory is directory where .php script is located
         *    - behavior: input of "/css/style.css" in HTML will be trans to:
         *      "../app/css/style.css" if value is "../app/" and "../css/style.css" if value is "../"
         */
        "chroot" => realpath(base_path()),
    ],

];
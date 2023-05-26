const mix = require('laravel-mix');
const lodash = require("lodash");
const folder = {
    src: "resources/",
    dest: "public/",
    asset_dest: "public/admin_assets/"
};

let third_party_assets = {
    files: [
        {
            "name": "jquery",
            "filename": "jquery",
            "assets": ["./node_modules/jquery/dist/jquery.min.js"]
        },
        {
            "name": "bootstrap",
            "filename": "bootstrap",
            "assets": ["./node_modules/bootstrap/dist/js/bootstrap.bundle.js"]
        },
        {
            "name": "metismenu",
            "filename": "metismenu",
            "assets": ["./node_modules/metismenu/dist/metisMenu.js"]
        },
        {
            "name": "simplebar",
            "filename": "simplebar",
            "assets": ["./node_modules/simplebar/dist/simplebar.js"]
        },
        {
            "name": "node-waves",
            "filename": "node-waves",
            "assets": ["./node_modules/node-waves/dist/waves.js"]
        },
        {
            "name": "select2",
            "filename": "select2",
            "assets": ["./node_modules/select2/dist/js/select2.min.js", "./node_modules/select2/dist/css/select2.min.css"]
        },
        {
            "name": "jquery-confirm",
            "filename": "jquery-confirm",
            "assets": ["./node_modules/jquery-confirm/dist/jquery-confirm.min.js", "./node_modules/jquery-confirm/dist/jquery-confirm.min.css"]
        },
        {
            "name": "jscolor",
            "filename": "jscolor",
            "assets": ["./node_modules/@eastdesire/jscolor/jscolor.js"]
        },
        {
            "name": "daterangepicker",
            "filename": "daterangepicker",
            "assets": ["./node_modules/daterangepicker/daterangepicker.js", "./node_modules/daterangepicker/daterangepicker.css"]
        },

        {
            "name": "trumbowyg",
            "filename": "trumbowyg",
            "assets": [
                "./node_modules/trumbowyg/dist/trumbowyg.js",
                "./node_modules/trumbowyg/dist/ui/trumbowyg.css"
            ]
        },
        {
            "name": "trumbowyg/plugins/table",
            "filename": "table",
            "assets": [
                "./node_modules/trumbowyg/plugins/table/trumbowyg.table.js",
                "./node_modules/trumbowyg/plugins/table/ui/sass/trumbowyg.table.scss"
            ]
        },
        {
            "name": "trumbowyg/plugins/colors",
            "filename": "colors",
            "assets": [
                "./node_modules/trumbowyg/plugins/colors/trumbowyg.colors.js",
                "./node_modules/trumbowyg/plugins/colors/ui/sass/trumbowyg.colors.scss"
            ]
        },
        {
            "name": "trumbowyg/plugins/cleanpaste",
            "filename": "cleanpaste",
            "assets": [
                "./node_modules/trumbowyg/plugins/cleanpaste/trumbowyg.cleanpaste.js"
            ]
        },
        {
            "name": "trumbowyg/plugins/history",
            "filename": "history",
            "assets": [
                "./node_modules/trumbowyg/plugins/history/trumbowyg.history.js"
            ]
        },
        {
            "name": "trumbowyg/plugins/indent",
            "filename": "indent",
            "assets": [
                "./node_modules/trumbowyg/plugins/indent/trumbowyg.indent.js"
            ]
        },
        {
            "name": "trumbowyg/plugins/pasteimage",
            "filename": "pasteimage",
            "assets": [
                "./node_modules/trumbowyg/plugins/pasteimage/trumbowyg.pasteimage.js"
            ]
        },
        {
            "name": "trumbowyg/plugins/resizimg",
            "filename": "resizimg",
            "assets": [
                "./node_modules/trumbowyg/plugins/resizimg/trumbowyg.resizimg.js"
            ]
        },
        {
            "name": "trumbowyg/plugins/upload",
            "filename": "upload",
            "assets": [
                "./node_modules/trumbowyg/plugins/upload/trumbowyg.upload.js"
            ]
        },
        {
            "name": "datatables",
            "filename": "datatables",
            "assets": [
                "./node_modules/datatables.net/js/jquery.dataTables.min.js",
                "./node_modules/datatables.net-bs5/js/dataTables.bootstrap5.js",
                "./node_modules/datatables.net-responsive/js/dataTables.responsive.min.js",
                "./node_modules/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js",
                "./node_modules/datatables.net-buttons/js/dataTables.buttons.min.js",
                "./node_modules/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js",
                "./node_modules/datatables.net-buttons/js/buttons.html5.min.js",
                "./node_modules/datatables.net-buttons/js/buttons.flash.min.js",
                "./node_modules/datatables.net-buttons/js/buttons.print.min.js",
                "./node_modules/datatables.net-buttons/js/buttons.colVis.min.js",
                "./node_modules/datatables.net-keytable/js/dataTables.keyTable.min.js",
                "./node_modules/datatables.net-select/js/dataTables.select.min.js",
                "./node_modules/datatables.net-bs5/css/dataTables.bootstrap5.css",
                "./node_modules/datatables.net-responsive-bs5/css/responsive.bootstrap5.css",
                "./node_modules/datatables.net-buttons-bs5/css/buttons.bootstrap5.css",
            ]
        },
        {
            "name": "datatables/plugins/buttons",
            "filename": "buttons",
            "assets": [
                "vendor/yajra/laravel-datatables-buttons/src/resources/assets/buttons.server-side.js",
            ]
        },
        {
            "name": "sweetalert2",
            "filename": "sweetalert2",
            "assets": ["./node_modules/sweetalert2/dist/sweetalert2.min.js", "./node_modules/sweetalert2/dist/sweetalert2.min.css"]
        },
        {
            "name": "moment",
            "filename": "moment",
            "assets": ["./node_modules/moment/min/moment.min.js"]
        }
    ]
}

lodash.forEach(third_party_assets, function (assets, type) {
    lodash.forEach(assets, function (plugin) {

        let name = plugin['name'],
            filename = plugin['filename'],
            asset_list = plugin['assets'],
            css = [],
            js = [];

        lodash.forEach(asset_list, function (asset) {
            let ass = asset.split(',');
            for (let i = 0; i < ass.length; ++i) {
                if (ass[i].substring(ass[i].length - 3) === '.js') {
                    js.push(ass[i]);
                } else {
                    css.push(ass[i]);
                }
            }
        })

        if (js.length > 0) {
            mix.combine(js, folder.asset_dest + "/libs/" + name + "/" + filename + ".min.js");
        }
        if (css.length > 0) {
            mix.combine(css, folder.asset_dest + "/libs/" + name + "/" + filename + ".min.css");
        }
    })
})

mix.copyDirectory('./node_modules/tinymce', folder.asset_dest + '/libs/tinymce');

mix.js('resources/admin_assets/js/app.js', 'public/admin_assets/js')
    .minify('public/admin_assets/js/app.js')
    .sourceMaps();

mix.sass('resources/admin_assets/sass/app.scss', 'public/admin_assets/css')
    .minify('public/admin_assets/css/app.css')
    .sourceMaps();

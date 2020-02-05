var config = {
        paths: {
            'addtocart': 'Bss_ConfigurableMatrixView/js/catalog-add-to-cart',
            'bss/swatch': 'Bss_ConfigurableMatrixView/js/swatch',
            'bss/swatch_renderer': 'Bss_ConfigurableMatrixView/js/swatch-renderer',
            'tableHeadFixer': 'Bss_ConfigurableMatrixView/js/tableHeadFixer'
        },
        shim: {
            'addtocart': {
                deps: ['jquery']
            },
            'bss/swatch': {
                deps: ['jquery']
            },
            'bss/swatch_renderer': {
                deps: ['jquery']
            },
            'tableHeadFixer': {
                deps: ['jquery']
            }
        }
};

export const getMenus = () => {
    let Menus = [
        {
            label: "About", url: "", active: true,
            submenus: [
                {label: "History", url: route('history-index'), active: false},
                {label: "Success Stories", url: route('content-index-page', 'success-story'), active: false},
                {label: "Certifications", url: route('content-index-page', 'certification'), active: false},
                {label: "Stella Coffee Origins", url: route('content-index-page', 'stella-coffee-origin'), active: false},
                {label: "Contact Us", url: route('contact-us-request-creation-page'), active: false},
            ]
        },
        {
            label: "Roasting", url: "", active: false,
            submenus: [
                {label: "Roasting Process", url: route('content-index-page', 'roasting-process'), active: false},
                {label: "Quality Control Process", url: route('content-index-page', 'quality-control-process'), active: false},
                {label: "Our Roasting Machine ", url: route('content-index-page', 'roasting-machine'), active: false},
                {label: "Roasting Guides", url: route('content-index-page', 'roasting-guide'), active: false},
                {label: "Roasting Services", url: route('content-index-page', 'roasting-service'), active: false}
            ]
        },
        {
            label: "Products", url: "", active: false,
            submenus: [
                {label: "Packages", url: route('content-index-page', 'product-package'), active: false},
                {label: "Blends", url: route('content-index-page', 'product-blend'), active: false},
                // {label: "Packages", url: route('product-packages'), active: false},
                // {label: "Blends", url: "", active: false},
            ]
        },
        {
            label: "Find Us", url: "", active: false,
            submenus: [
                {label: "Export Destinations", url: route('export-destinations'), active: false},
                {label: "Our Stores", url: route('stores'), active: false},
                {label: "Our Shops", url: route('shops'), active: false},
                {label: "Duty Free Locations ", url: route('duty-free-locations'), active: false},
                {label: "Factory Locations", url: route('factory-locations'), active: false},
                {label: "Export Processes", url: route('export-processes'), active: false},
            ]
        },
        {
            label: "Cupping", url: "", active: false, submenus: [
                {label: "Cupping Procedures", url: route('content-index-page', 'cupping-procedure'), active: false},
                {label: "Cupping Events", url: route('content-index-page', 'cupping-event'), active: false}
            ]
        },
        {
            label: "News and Events", url: "", active: false,
            submenus: [
                {label: "News", url: route('content-index-page', 'news'), active: false},
            ]
        }
    ];
    return Menus;
}

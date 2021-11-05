export const getMenus = () => {
    let Menus = [
        {
            label: "About", url: "", active: true,
            submenus: [
                {label: "History", route: route('content-index-page', 'history'), active: false},
                {label: "Success Stories", route: route('content-index-page', 'success-story'), active: false},
                {label: "Certifications", route: route('content-index-page', 'certification'), active: false},
                {label: "Stella Coffee Origins", route: route('content-index-page', 'stella-coffee-origin'), active: false},
                {label: "Contact Us", route: route('content-index-page', 'contact-us-request'), active: false},
            ]
        },
        {
            label: "Roasting", url: "", active: false,
            submenus: [
                {label: "Roasting Process", route: route('content-index-page', 'roasting-process'), active: false},
                {label: "Quality Control Process", route: route('content-index-page', 'quality-control-process'), active: false},
                {label: "Our Roasting Machine ", route: route('content-index-page', 'roasting-machine'), active: false},
                {label: "Roasting Guides", route: route('content-index-page', 'roasting-guide'), active: false},
                {label: "Roasting Services", route: route('content-index-page', 'roasting-service'), active: false}
            ]
        },
        {
            label: "Products", url: "", active: false,
            submenus: [
                {label: "Packages", route: route('content-index-page', 'product-package'), active: false},
                {label: "Blends", route: route('content-index-page', 'product-blend'), active: false},
            ]
        },
        {
            label: "Find Us", url: "", active: false,
            submenus: [
                {label: "Export Destinations", route: route('content-index-page', 'export-destination'), active: false},
                {label: "Sales Locations", route: route('content-index-page', 'sales-location'), active: false},
                {label: "Our Stores", route: route('content-index-page', 'store'), active: false},
                {label: "Duty Free Locations ", route: route('content-index-page', 'duty-free-location'), active: false},
                {label: "Factory Location", route: route('content-index-page', 'factory-location'), active: false},
                {label: "Export Processes", route: route('content-index-page', 'export-process'), active: false},
            ]
        },
        {
            label: "Cupping", url: "", active: false, submenus: [
                {label: "Cupping Procedures", route: route('content-index-page', 'cupping-procedure'), active: false},
                {label: "Cupping Events", route: route('content-index-page', 'cupping-event'), active: false}
            ]
        },
        {
            label: "News and Events", route: route('content-index-page', 'news-and-events'), active: false
        }
    ];

    return Menus;
}

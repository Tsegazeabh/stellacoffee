export const getMenus = () => {
    let Menus = [
        {
            label: "About", url: "", active: true,
            submenus: [
                {label: "History", url: "", active: false},
                {label: "Success Stories", url: "", active: false},
                {label: "Certifications", url: "", active: false},
                {label: "Stella Coffee Origins", url: "", active: false},
                {label: "Contact Us", url: "", active: false},
            ]
        },
        {
            label: "Roasting", url: "", active: false,
            submenus: [
                {label: "Roasting Process", url: "", active: false},
                {label: "Quality Control Process", url: "", active: false},
                {label: "Our Roasting Machine ", url: "", active: false},
                {label: "Roasting Guides", url: "", active: false},
                {label: "Roasting Services", url: "", active: false}
            ]
        },
        {
            label: "Products", url: "", active: false,
            submenus: [
                {label: "Packages", url: route('product-packages'), active: false},
                {label: "Blends", url: "", active: false},
            ]
        },
        {
            label: "Find Us", url: "", active: false,
            submenus: [
                {label: "Export Destinations", url: "", active: false},
                {label: "Locations", url: "", active: false},
                {label: "Duty Free Locations ", url: "", active: false},
                {label: "Shops", url: "", active: false},
                {label: "Factory Location", url: "", active: false},
                {label: "Export Processes", url: "", active: false},
            ]
        },
        {
            label: "Cupping", url: "", active: false, submenus: [
                {label: "Cupping Procedures", url: "", active: false},
                {label: "Cupping Events", url: "", active: false}
            ]
        },
        {
            label: "News and Events", url: "", active: false
        }
    ];

    return Menus;
}

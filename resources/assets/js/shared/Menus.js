import axios from "axios";

let documentMenus = []
let publicationMenus = []

export const getDocumentMenus = async () => {
    let response = await axios.get(route('document-type'));
    let menu = {label: '', route: ''}
    documentMenus = response.data.map(docType => {
        menu = {
            label: docType.name, route: route('latest-document', docType.id)
        }
        return menu;
    })
}

export const getPublicationMenus = async () => {
    let response = await axios.get(route('publication-type'));

    let menu = {label: '', route: ''}
    publicationMenus = response.data.map(pubType => {
        menu = {
            label: pubType.name, route: route('latest-publication', pubType.id)
        }
        return menu;
    })
}

export const getMenus = async () => {
    await getDocumentMenus();
    await getPublicationMenus();
    let Menus = [
        {
            label: 'Home', route: route("home"), active: false, collapsed: true
        },
        {
            label: 'Company', route: route("home"), collapsed: true,
            submenus: [
                {label: 'About Us', route: route('content-index-page', 'about-us')},
                {label: 'Organizational Structure', route: route('content-index-page', 'organizational-structure')},
                {label: 'Profile', route: route('content-index-page', 'profile')},
                {label: 'History', route: route('history-index')},
                {label: 'Service Charter', route: route('content-index-page', 'service-charter')},
                {label: 'Innovation', route: route('content-index-page', 'innovation')},
                {label: 'CEO Message', route: route('content-index-page', 'ceo-message')},
                {label: 'Contact Offices', route: route('latest-contact-details')},
            ]
        },
        {
            label: 'Customer Services', route: route("home"), collapsed: true,
            submenus: [
                {label: 'Post Paid', route: route('content-index-page', 'postpaid')},
                {label: 'Pre Paid', route: route('content-index-page', 'prepaid')},
                {label: 'Bill Information', route: route('content-index-page', 'bill-information')},
                {label: 'Bill Complaint', route: route('content-index-page', 'bill-complaint')},
                {
                    label: 'Customer Service Centers',
                    route: route('latest-customer-service-center', {'service_center_type': 2})
                },
                {
                    label: 'Bill Sales Offices',
                    route: route('latest-customer-service-center', {'service_center_type': 1})
                },
                {label: 'Payment Options', route: route('content-index-page', 'payment-option')},
                {label: 'Billing', route: route('content-index-page', 'billing')},
                {label: 'Getting Electricity', route: route('content-index-page', 'getting-electricity')},
                {label: 'Customer Announcements', route: route('latest-customer-announcement')},
            ]
        },
        {
            label: 'Public Information', route: route("home"), collapsed: true,
            submenus: [
                {label: 'Electricity Tariffs', route: route('content-index-page', 'electricity-tariff')},
                {label: 'Power Interruptions', route: route('power-interruption-index')},
                {label: 'Complaint Handling', route: route('content-index-page', 'complaint-handling')},
                {label: 'Customer Rights/Duties', route: route('content-index-page', 'customer-right-and-duty')},
                {label: 'Electrical Tips', route: route('content-index-page', 'electrical-tip')},
                {label: 'Ease of Doing Business', route: route('content-index-page', 'ease-of-doing-business')},
                {label: 'Projects/Programs', route: route('content-index-page', 'project-and-program')},
                {label: 'CSR', route: route('content-index-page', 'social-responsibility')},
                {label: 'Citizen Engagements', route: route('content-index-page', 'citizen-engagement')},
                {label: 'Staff Announcements', route: route('latest-staff-announcement')},
                {label: 'Vacancies', route: route('latest-vacancy')},
                {label: 'Tenders', route: route('latest-tender')},
            ]
        },
        {
            label: 'Media', route: route("home"), collapsed: true,
            submenus: [
                {label: 'News', route: route('content-index-page', 'news')},
                {label: 'Press Releases', route: route('content-index-page', 'press-release')},
                {label: 'Events', route: route('content-index-page', 'events')},
                {label: 'Speeches', route: route('content-index-page', 'speeches')},
                {label: 'Gallery', route: route('photo-gallery')}
            ]
        },
        {
            label: 'Documents', route: route("home"), collapsed: true,
            submenus: documentMenus
        },
        {
            label: 'Publications', route: route("home"), collapsed: true,
            submenus: publicationMenus
        }
    ]

    return Menus;
}





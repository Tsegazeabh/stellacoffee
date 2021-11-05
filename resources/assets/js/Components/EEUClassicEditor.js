// import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import DocumentEditor from '@ckeditor/ckeditor5-build-decoupled-document';

const imageConfiguration =
    {
        resizeOptions: [
            {
                name: 'resizeImage:original',
                value: null,
                icon: 'original'
            },
            {
                name: 'resizeImage:50',
                value: '50',
                icon: 'medium'
            },
            {
                name: 'resizeImage:75',
                value: '75',
                icon: 'large'
            }
        ],
        toolbar: ['resizeImage:50', 'resizeImage:75', 'resizeImage:original']
    }

class EEUClassicEditor extends DocumentEditor {
}

// Plugins to include in the build.

// Editor configuration.
EEUClassicEditor.defaultConfig = {
    simpleUpload: {
        uploadUrl: route('lfm-upload-image'),
        withCredentials: false,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        }
    },
    // ckfinder: {
    //     uploadUrl: route('lfm-upload-image'),
    //     headers: {
    //         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    //     }
    // },
    height: '500px',
    toolbar: {
        items: [
            'heading',
            '|',
            'fontSize',
            'fontFamily',
            'fontColor',
            'fontBackgroundColor',
            '|',
            'bold',
            'italic',
            'underline',
            'highlight',
            'removeFormat',
            'todoList',
            '|',
            'alignment',
            '|',
            'numberedList',
            'bulletedList',
            '|',
            'indent',
            'outdent',
            '|',
            'link',
            'blockQuote',
            'imageUpload',
            'insertTable',
            '|',
            'undo',
            'redo'
        ]
    },
    imageConfiguration,
    image: {
        toolbar: [
            'imageStyle:alignLeft', 'imageStyle:alignCenter', 'imageStyle:alignRight',
            '|',
            'resizeImage',
            '|',
            'imageTextAlternative'
        ],
        styles: [
            'alignLeft', 'alignCenter', 'alignRight'
        ],
    },
    table: {
        contentToolbar: [
            'tableColumn',
            'tableRow',
            'mergeTableCells'
        ]
    },
    language: 'en',
    licenseKey: ''
};

EEUClassicEditor.fontFamily = {
    options: [], supportAllValues: true
};

EEUClassicEditor.fontSize = {
    options: [], supportAllValues: true
};

export default EEUClassicEditor;

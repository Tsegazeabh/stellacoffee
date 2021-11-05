import { logWarning } from '@ckeditor/ckeditor5-utils/src/ckeditorerror';


export default class CkEditorFileUploadAdapter2 extends Plugin {

    /**
     * @inheritDoc
     */
    init() {

        const editor = this.editor;

        console.log( 'Custom File Upload Adapter was Initialized' );

        editor.ui.componentFactory.add( 'insertImage', locale => {
            const view = new ButtonView( locale );

            view.set( {
                label: 'Insert image',
                icon: imageIcon,
                tooltip: true
            });

            // Callback executed once the image is clicked.
            view.on( 'execute', () => {
                const imageURL = prompt( 'Image URL' );
            });

            return view;
        } );

        const options = this.editor.config.get('ckEditorFileUpload');

        if ( !options ) {
            return;
        }

        if ( !options.uploadUrl ) {
            /**
             * The {@link module:upload/adapters/simpleuploadadapter~SimpleUploadConfig#uploadUrl `config.simpleUpload.uploadUrl`}
             * configuration required by the {@link module:upload/adapters/simpleuploadadapter~SimpleUploadAdapter `SimpleUploadAdapter`}
             * is missing. Make sure the correct URL is specified for the image upload to work properly.
             *
             * @error simple-upload-adapter-missing-uploadurl
             */
            logWarning( 'ck-editor-file-upload-adapter-missing-uploadurl');

            return;
        }

        this.editor.plugins.get('FileRepository').createUploadAdapter = loader => {
            return new EEUUploadAdapter( loader, options );
        };
    }
}


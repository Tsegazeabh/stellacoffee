
export default function MyCustomUploadAdapterPlugin(editor) {
    alert("Here");
    editor.plugins.get( 'FileRepository' ).createUploadAdapter = ( loader ) => {
        // Configure the URL to the upload script in your back-end here!
        return new EEUUploadAdapter(loader);
    };
}

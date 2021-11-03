import axios from "axios";

/**
 * Upload adapter.
 *
 * @private
 * @implements module:upload/filerepository~UploadAdapter
 */
class EEUUploadAdapter {

    constructor(loader, options) {
        // The file loader instance to use during the upload.
        this.loader = loader;

        /**
         * The configuration of the adapter.
         *
         * @member {module:upload/adapters/simpleuploadadapter~SimpleUploadConfig} #options
         */
        this.options = options;
    }

    // Starts the upload process.
    async upload() {
        const data = new FormData();
        data.append("image", await this.loader.file);
        //const res = await axios.post(this.options.uploadUrl, data, this.options.headers);

        return this.loader.file.then(file => {
            return new Promise((resolve, reject) => {
                this._initRequest();
                this._initListeners(resolve, reject, file);
                this._sendRequest(file);
            });
        });
    }

    // Aborts the upload process.
    abort() {
        if (this.xhr) {
            this.xhr.abort();
        }
    }

    // Initializes the XMLHttpRequest object using the URL passed to the constructor.
    _initRequest() {

        const xhr = this.xhr = new XMLHttpRequest();

        // Note that your request may look different. It is up to you and your editor
        // integration to choose the right communication channel. This example uses
        // a POST request with JSON as a data structure but your configuration
        // could be different.
        xhr.open('POST', this.options.uploadUrl, true);
        xhr.responseType = 'json';
    }

    // Initializes XMLHttpRequest listeners.
    _initListeners(resolve, reject, file) {
        const xhr = this.xhr;
        const loader = this.loader;
        const genericErrorText = `Couldn't upload file: ${file.name}.`;

        xhr.addEventListener('error', () => reject(genericErrorText));
        xhr.addEventListener('abort', () => reject());
        xhr.addEventListener('load', () => {
            const response = xhr.response;

            // This example assumes the XHR server's "response" object will come with
            // an "error" which has its own "message" that can be passed to reject()
            // in the upload promise.
            //
            // Your integration may handle upload errors in a different way so make sure
            // it is done properly. The reject() function must be called when the upload fails.
            if (!response || response.error) {
                return reject(response && response.error ? response.error.message : genericErrorText);
            }

            const urls = response.url ? {default: response.url} : response.urls;
            // If the upload is successful, resolve with the normalized `urls` property and pass the rest of the response
            // to allow customizing the behavior of features relying on the upload adapters.
            resolve({
                ...response,
                urls
            });
        });

        // Upload progress when it is supported. The file loader has the #uploadTotal and #uploaded
        // properties which are used e.g. to display the upload progress bar in the editor
        // user interface.
        if (xhr.upload) {
            xhr.upload.addEventListener('progress', evt => {
                if (evt.lengthComputable) {
                    loader.uploadTotal = evt.total;
                    loader.uploaded = evt.loaded;
                }
            });
        }
    }

    // Prepares the data and sends the request.
    _sendRequest(file) {
        // Important note: This is the right place to implement security mechanisms
        // like authentication and CSRF protection. For instance, you can use
        // XMLHttpRequest.setRequestHeader() to set the request headers containing
        // the CSRF token generated earlier by your application.

        // Set headers if specified.
        const headers = this.options.headers || {};

        // Use the withCredentials flag if specified.
        const withCredentials = this.options.withCredentials || false;

        for (const headerName of Object.keys(headers)) {
            this.xhr.setRequestHeader(headerName, headers[headerName]);
        }

        this.xhr.withCredentials = withCredentials;

        // Prepare the form data.
        const data = new FormData();
        data.append('image', file);

        // Send the request.
        this.xhr.send(data);
    }
}

export default EEUUploadAdapter;

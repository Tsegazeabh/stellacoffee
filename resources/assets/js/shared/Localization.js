module.exports = {
    /**
     * Translate the given key.
     */
    _trans(key, replace = {}) {
        let translations = this.$page.props.language;
        let keys = key.split('.');

        keys.some((k) => {
            if (translations != undefined && translations[k] != undefined) {
                translations = translations[k];
            } else {
                translations = key;
                return;
            }
        });

        Object.keys(replace).forEach(function (key) {
            translation = translation.replace(':' + key, replace[key])
        });

        return translations;
        let translation = this.$page.props.language != undefined && this.$page.props.language[key]
            ? this.$page.props.language[key]
            : key

        Object.keys(replace).forEach(function (key) {
            translation = translation.replace(':' + key, replace[key])
        });

        return translation
    }
}

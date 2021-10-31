const path = require('path');

module.exports = {
    resolve: {
        extensions: ['.js', '.json', '.vue'],
        alias: {
            '@': path.resolve('resources/assets/js'),
            '@jetstream': path.resolve('resources/assets/js/Jetstream'),
            '@components': path.resolve('resources/assets/js/Components'),
            '@layouts': path.resolve('resources/assets/js/Layouts'),
            '@models': path.resolve('resources/assets/js/Models'),
            '@services': path.resolve('resources/assets/js/Services'),
            '@pages': path.resolve('resources/assets/js/Pages'),
            '@shared': path.resolve('resources/assets/js/Shared'),
            '@images': path.resolve('resources/assets/Images'),
        },
    },
};

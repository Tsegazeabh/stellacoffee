const path = require('path');

module.exports = {
    resolve: {
        alias: {
            '@components': path.resolve('resources/assets/js/components'),
            '@layouts': path.resolve('resources/assets/js/layouts'),
            '@models': path.resolve('resources/assets/js/models'),
            '@services': path.resolve('resources/assets/js/services'),
            '@pages': path.resolve('resources/assets/js/Pages'),
            '@shared': path.resolve('resources/assets/js/shared'),
            '@images': path.resolve('resources/assets/images'),
        },
    },
};

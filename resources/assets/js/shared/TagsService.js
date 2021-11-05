import axios from "axios";

export function createNewTag(tag) {
    return new Promise((resolve, reject) => {
        let tagObj = {name: tag};
        axios.post(route('create-tag'), tagObj)
            .then(response => {
                if (response.data) {
                    resolve(response.data)
                }
                resolve()
            })
            .catch(function (error) {
                resolve();
            });
    });
}

export function getAllTags() {
    return new Promise((resolve, reject) => {
        axios.get(route('fetch-tags')).then(
            res => {
                resolve(res.data);
            })
            .catch(function (error) {
                resolve();
            });
    });
}

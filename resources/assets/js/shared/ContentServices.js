import {Inertia} from "@inertiajs/inertia";
import axios from "axios"

export const publish = async (content_id) => {
    await axios.put(route('publish-content', content_id))
}

export const unpublish = async (content_id) => {
    await axios.put(route('unpublish-content', content_id))
}

export const archive = async (content_id) => {
    await axios.put(route('archive-content', content_id))
}

export const restore = async (content_id) => {
    await axios.put(route('restore-content', content_id))
}

export const forceDelete = async (content_id) => {
    await axios.delete(route('delete-content', content_id))
}

export const forceDeleteRequest = async (content_id, $toast) => {
    await axios.delete(route('delete-request', content_id));
}

export const archiveRequest = async (content_id, $toast) => {
    await axios.put(route('archive-request', content_id));
}

export const closeRequest = async (request_id, $toast) => {
    await axios.put(route('close-request', request_id));
}

export const openRequest = async (request_id, $toast) => {
    await axios.put(route('open-request', request_id));
}

<template>
    <div class="breadcrump">
        <ul>
            <li>
                <inertia-link :href="route('home')">{{_trans("menu.Home")}}</inertia-link>
            </li>
            <li>
                <inertia-link :href="route('dashboard')">{{_trans('menu.CMS')}}</inertia-link>
            </li>
            <li>
                <inertia-link :href="route('news-management-page')">{{_trans("menu.News")}}</inertia-link>
            </li>
            <li>{{_trans("action.edit")}}</li>
        </ul>
    </div>
    <news-form :news="news"
               :error-message="errorMessage"
               :success-message="successMessage"
               :errors="errors"
               :method="'put'"
               :url="route('edit-news', news.id)">
    </news-form>
</template>

<script>
    import AdminLayout from "@layouts/AdminLayout"
    import NewsForm from "@components/NewsForm";

    export default {
        name: "edit-news",
        layout: (h, page) => h(AdminLayout, [page]), // if you want to use different persistence layout,
        components: {
            NewsForm
        },
        props: {
            news: {
                type: Object,
                default: {
                    title: '',
                    tags: [],
                    detail: '',
                    video_link:''
                },
                required: true
            },
            errors: {
                type: Object,
                default: {}
            },
            errorMessage: {
                type: String,
                default: ''
            },
            successMessage: {
                type: String,
                default: ''
            }
        }
    }
</script>

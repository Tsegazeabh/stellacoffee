<template>
    <div class="flex flex-wrap w-full gap-4 border-t py-4 my-4 justify-end">
        <facebook-button
            :url="url"
            :description="description"
            :modalWidth="modal.width"
            :modalHeight="modal.height"
            :isBlank="false"
            :appID="fb_app_id" />
        <twitter-button
            :url="url"
            :description="description"
            :modalWidth="modal.width"
            :modalHeight="modal.height"
            :isBlank="false"
        />
        <telegram-button
            :url="url"
            :description="description"
            :modalWidth="modal.width"
            :modalHeight="modal.height"
            :isBlank="false"
        />
        <pinterest-button
            :url="url"
            :description="description"
            :modalWidth="modal.width"
            :modalHeight="modal.height"
            :isBlank="false"
        />
        <linked-in-button
            :url="url"
            :description="description"
            :modalWidth="modal.width"
            :modalHeight="modal.height"
            :isBlank="false"
        />
        <whats-app-button
            :url="url"
            :description="description"
            :modalWidth="modal.width"
            :modalHeight="modal.height"
            :isBlank="false"
        />
    </div>
</template>

<script>
    import Button from "@components/Button";
    import TwitterButton from "vue-share-buttons/src/components/TwitterButton";
    import FacebookButton from "vue-share-buttons/src/components/FacebookButton";
    import TelegramButton from "vue-share-buttons/src/components/TelegramButton";
    import PinterestButton from "vue-share-buttons/src/components/PinterestButton";
    import LinkedInButton from "vue-share-buttons/src/components/LinkedInButton";
    import WhatsAppButton from "vue-share-buttons/src/components/WhatsAppButton";

    export default {
        name: "social-media-sharing-buttons",
        components: {Button, TwitterButton, FacebookButton, TelegramButton, PinterestButton, LinkedInButton, WhatsAppButton},

        data() {
            return {
                modal:{
                  width:500,
                  height:500
                },
                fb_app_id:'584951052526538',
                url: document.querySelector('meta[property="og\\:url"]') ? document.querySelector('meta[property="og\\:url"]').content:location.href,
                title: document.querySelector('meta[property="og\\:title"]') ? document.querySelector('meta[property="og\\:title"]').content : '',
                description: document.querySelector('meta[property="og\\:description"]') ? document.querySelector('meta[property="og\\:description"]').content: ''
            }
        }
    }
</script>

<style>
.share-button .share-button__icon, .share-button .share-button__text {
    margin: 0 3px !important;
}

.share-button {
    background-color: transparent !important;
    border: 1px solid rgba(180, 180, 180, 0.9) !important;
}

.share-button.share-button--facebook {
    border-color: #3b5897 !important;
}

.share-button.share-button--facebook .share-button__text {
    color: #3b5897 !important;
}

.share-button.share-button--facebook .share-button__icon path{
    fill: #3b5897 !important;
}
.share-button.share-button--twitter {
    border-color: #1ca0f2 !important;
}

.share-button.share-button--twitter .share-button__text {
    color: #1ca0f2 !important;
}

.share-button.share-button--twitter .share-button__icon path{
    fill: #1ca0f2 !important;
}

.share-button.share-button--telegram {
    border-color: #2ea5e0 !important;
}

.share-button.share-button--telegram .share-button__text {
    color: #2ea5e0 !important;
}

.share-button.share-button--telegram .share-button__icon path{
    fill: #2ea5e0 !important;
}

.share-button.share-button--pinterest {
    border-color: #bf081d !important;
}

.share-button.share-button--pinterest .share-button__text {
    color: #bf081d !important;
}

.share-button.share-button--pinterest .share-button__icon path{
    fill: #bf081d !important;
}

.share-button.share-button--linkedIn {
    border-color: #0074b3 !important;
}

.share-button.share-button--linkedIn .share-button__text {
    color: #0074b3 !important;
}

.share-button.share-button--linkedIn .share-button__icon path{
    fill: #0074b3 !important;
}

.share-button.share-button--whatsApp {
    border-color: #25d466 !important;
    color: #25d466 !important;
}

.share-button.share-button--whatsApp .share-button__text {
    color: #25d466 !important;
}

.share-button.share-button--whatsApp .share-button__icon path{
    fill: #25d466 !important;
}

.share-button .share-button__text {
    color: rgba(100, 100, 100, 0.9);
}
</style>


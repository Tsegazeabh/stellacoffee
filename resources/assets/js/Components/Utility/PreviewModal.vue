<template>
    <transition
        name="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center">
        <div class="modal-mask">
            <div class="modal-wrapper absolute w-full h-full bg-gray-900 opacity-50">
                <div
                    class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">

                    <!--                    <div class="modal-header">-->
                    <!--                        <slot name="header">-->
                    <!--                            default header-->
                    <!--                        </slot>-->
                    <!--                    </div>-->

                    <div class="modal-body w-full">
                        <!--                        <slot name="body">-->
                        <div class="w-full" v-if="content">
                            <div class="header1">{{ content.title }}</div>
                            <div v-html="content.detail"></div>

                            <div
                                class="flex flex-wrap justify-end items-center content-info text-gray-600 text-base pt-3 mt-3 text-right">
                                <div class="pr-2 font-bold">
                                    Pubished at: {{ formatDate() }}
                                </div>
                                <div class="ml-6">
                                    <span class="font-bold pr-2">Readers:</span>
                                    <span class="underline">234</span>
                                </div>
                            </div>
                            <!--                             <related-contents></related-contents>-->
                        </div>
                        <!--                        </slot>-->
                    </div>

                    <div class="modal-footer">
                        <!--                        <slot name="footer">-->
                        <button class="modal-default-button" @click="close">
                            Close
                        </button>
                        <!--                        </slot>-->
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>

import {defineAsyncComponent, provide, inject, onMounted} from 'vue'
import moment from 'moment'
import RelatedContentsLoadingState from '@components/RelatedContentsLoadingState'
import RelatedContentsLoadingError from '@components/RelatedContentsLoadingError'
import ContentsLayout from "@layouts/ContentsLayout"

const RelatedContents = defineAsyncComponent({
    // The factory function
    loader: () => import(/*webpackChunkName: 'RelatedContents'*/ '@components/RelatedContents.vue'),
    // Delay before showing the loading component. Default: 200ms.
    delay: 200,
    // The error component will be displayed if a timeout is provided and exceeded. Default: Infinity.
    timeout: 3000,
    // Defining if component is suspensible. Default: true.
    suspensible: false,
    // A component to use if the load fails
    errorComponent: RelatedContentsLoadingError,
    // A component to use while the async component is loading
    loadingComponent: RelatedContentsLoadingState
});
import {defineComponent} from 'vue'

export default defineComponent({
    name: "preview-modal",
    layout: (h, page) => h(ContentsLayout, [page]), // if you want to use different persistence layout
    emits: ['onClose'],
    provide: {
        'content_id': null,
        'tags': []
    },
    props: {
        showModal: false
    },
    components: {
        'related-contents': RelatedContents
    },

    setup() {
        let content = inject('content')
        return {content}
    },
    methods: {
        formatDate() {
            return moment(String(new Date())).format('MMM DD, YYYY')
        },

        close() {
            this.$emit('onClose')
        }
    }
})
</script>

<style scoped>
.modal-mask {
    position: fixed;
    z-index: 9998;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: table;
    transition: opacity 0.3s ease;
}

.modal-wrapper {
    display: table-cell;
    vertical-align: middle;
}

.modal-container {
    width: 600px;
    margin: 0px auto;
    padding: 20px 30px;
    background-color: #fff;
    border-radius: 2px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
    transition: all 0.3s ease;
    font-family: Helvetica, Arial, sans-serif;
}

.modal-header h3 {
    margin-top: 0;
    color: #42b983;
}

.modal-body {
    margin: 20px 0;
}

.modal-default-button {
    display: block;
    margin-top: 1rem;
}

/*
 * The following styles are auto-applied to elements with
 * transition="modal" when their visibility is toggled
 * by Vue.js.
 *
 * You can easily play with the modal transition by editing
 * these styles.
 */

.modal-enter {
    opacity: 0;
}

.modal-leave-active {
    opacity: 0;
}

.modal-enter .modal-container,
.modal-leave-active .modal-container {
    -webkit-transform: scale(1.1);
    transform: scale(1.1);
}
</style>

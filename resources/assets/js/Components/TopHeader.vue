<template>
    <header>
        <ul class="left">
            <li>
                <a><span class="fas fa-map-marker" aria-hidden="true"></span> Wolo Sefer, Addis Ababa, Ethiopia</a>
            </li>
            <li>
                <a><span class="fas fa-phone-alt" aria-hidden="true"></span> (+251) 911 213496</a>
            </li>
        </ul>
        <ul class="right">
            <li>
                <a href="#"><span class="fab fa-facebook-f" aria-hidden="true"></span></a>
            </li>
            <li>
                <a href="#"><span class="fab fa-twitter" aria-hidden="true"></span></a>
            </li>
            <li>
                <a><span class="fab fa-linkedin" aria-hidden="true"></span></a>
            </li>
            <li>
                <a href="#"><span class="fab fa-instagram" aria-hidden="true"></span></a>
            </li>
            <li>
                <a href="#"><span class="fab fa-youtube" aria-hidden="true"></span></a>
            </li>
            <li class="nav-item dropdown">
                <button title="Language">
                    <span>
                        {{ _trans('locale.' + $page.props.locale) }}
                    </span>
                    <i class="fa fa-angle-down ml-1"></i>
                </button>
                <ul class="dropdown-menu">
                    <li class="nav-item dropdown-item py-0 w-full">
                        <button @click.stop="changeLanguage('en')"
                                class="nav-link w-full"
                                :class="lang=='en'?'active':''">
                            English
                        </button>
                    </li>
                    <li class="dropdown-item">
                        <button @click.stop="changeLanguage('am')"
                                class="nav-link w-full"
                                :class="lang=='am'?'active':''">
                            አማርኛ
                        </button>
                    </li>
                    <li class="dropdown-item">
                        <button @click.stop="changeLanguage('fr')"
                                class="nav-link w-full"
                                :class="lang=='fr'?'active':''">
                            French
                        </button>
                    </li>
                    <li class="dropdown-item">
                        <button @click.stop="changeLanguage('it')"
                                class="nav-link"
                                :class="lang=='it'?'active':''">
                            Italiano
                        </button>
                    </li>
                </ul>
            </li>
            <li>
                <inertia-link class="nav-link" type="button" :href="route('login')">
                    Login
                </inertia-link>
            </li>
<!--            <li class="nav-item flex md:hidden">-->
<!--                <button @click.stop.prevent="toggleCollapse">-->
<!--                    <i class="fas fa-bars" v-show="collapse"></i>-->
<!--                    <i class="fas fa-times" v-show="!collapse"></i> Menu-->
<!--                </button>-->
<!--            </li>-->
        </ul>
    </header>
</template>

<script>
import Button from "@components/Button";
import BreezeDropdown from '@components/Dropdown'
import BreezeDropdownLink from '@components/DropdownLink'
import {defineComponent} from 'vue'

export default defineComponent({
    name: "top-header",
    components: {
        Button,
        BreezeDropdown,
        BreezeDropdownLink
    },
    emits: ['toggleCollapse'],
    data() {
        return {
            collapsed: this.collapse
        }
    },
    props: {
        collapse: {
            type: Boolean,
            default: false
        },
        breakpoint: {
            type: Object,
            required: true
        }
    },
    computed: {
        lang() {
            return this.$page.props.locale;
        }
    },
    methods: {
        toggleCollapse() {
            if (window.innerWidth < this.breakpoint.md) {
                this.collapsed = !this.collapsed
            } else {
                this.collapsed = true;
            }

            this.$emit('toggleCollapse', !this.collapse)
        },
    },
})
</script>

<style scoped>

</style>

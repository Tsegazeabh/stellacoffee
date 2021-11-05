<template>
    <nav class="cms-header-nav z-40">
        <div class="nav-brand-cont">
            <div class="nav-brand">
                <a :href="route('home')">
                    <img :src="logo" class="h-11" alt="EEU"/>
                </a>
                <h1 class="app-name">{{_trans('titles.EEU CMS')}}</h1>
            </div>
            <div class="navbar-container">
                <ul class="navbar">
                    <li class="nav-item dropdown">
                        <button type="button" class="nav-link">
                            <span class="mx-3">{{ $page.props.auth.user.name }}</span>
                            <i class="fa fa-angle-down"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li class="nav-item dropdown-item py-0 w-full" v-if="!$page.props.auth.user.is_admin">
                                <inertia-link class="nav-link w-full"
                                              :href="route('password-modification-page', $page.props.auth.user.id)">
                                    {{_trans('action.Change Password')}}
                                </inertia-link>
                            </li>
                            <li class="nav-item dropdown-item py-0 w-full">
                                <inertia-link class="nav-link w-full" method="post" :href="route('logout')">
                                    {{_trans('action.Logout')}}
                                </inertia-link>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <button
                            class="inline-flex items-center py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                            title="Language">
                            <span>
<!--                                <i class="fa fa-language"></i> -->
                                {{_trans('locale.'+$page.props.locale)}}
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
                            <li class="nav-item dropdown-item py-0 w-full">
                                <button @click.stop="changeLanguage('am')"
                                        class="nav-link w-full"
                                        :class="lang=='am'?'active':''">
                                    አማርኛ
                                </button>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item flex md:hidden">
                        <button @click.stop.prevent="toggleCollapse">
                            <i class="fas fa-bars" v-show="collapse"></i>
                            <i class="fas fa-times" v-show="!collapse"></i> Menu
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
    import logo from "../../images/logo.jpg"
    import BreezeDropdown from '@components/Dropdown'
    import BreezeDropdownLink from '@components/DropdownLink'
    import Button from "@components/Button";

    export default {
        name: "cms-header",
        emits: ['toggleCollapse'],
        components: {
            Button,
            BreezeDropdown,
            BreezeDropdownLink,
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
        data() {
            return {
                logo: logo,
                collapsed: this.collapse
            }
        },
    }
</script>

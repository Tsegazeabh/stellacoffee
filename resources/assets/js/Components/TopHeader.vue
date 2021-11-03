<template>
    <header>
        <ul class="left">
            <li>
                <a><span class="fas fa-map-marker" aria-hidden="true"></span> Bole, Addis Ababa, Ethiopia</a>
            </li>
            <li>
                <a><span class="fas fa-calendar-week" aria-hidden="true"></span> Monday - Saturday</a>
            </li>
            <li>
                <a><span class="fas fa-phone-alt" aria-hidden="true"></span> (+251) 11 545 8901</a>
            </li>
        </ul>
        <ul class="right">
            <li>
                <inertia-link class="nav-link" type="button" :href="route('login')">
                    {{_trans('menu.Login')}}
                </inertia-link>
            </li>
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
        </ul>
    </header>
</template>

<script>
export default {
    name: "top-header"
}
</script>

<style scoped>

</style>

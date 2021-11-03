<template>
    <div id="roasting-tabs">
        <div class="menu">
            <ul>
                <li class="active">
                    <a>Roasting Process</a>
                </li>
                <li>
                    <a>Quality Control Process</a>
                </li>
                <li>
                    <a>Our Roasting Machine</a>
                </li>
                <li>
                    <a>Roasting Guides</a>
                </li>
                <li>
                    <a>Roasting Services</a>
                </li>
            </ul>

        </div>
        <div class="tab-container">
            <div id="tab-1" class="tab-content border grid grid-cols-5">
                <div class="md:col-span-2 px-0 md:px-3">
                    <img src="http://127.0.0.1:8000/images/Ampersand-38.jpg" class="object-contain w-full"/>
                </div>
                <div
                    class="md:col-span-3 px-0 py-5 md:py-0 md:pl-3 flex flex-col flex-wrap items-start justify-between">
                    <h2 class="leading-header flex-grow-0">Who we are?</h2>
                    <h2 class="main-header flex-grow-0">Rich Taste, Great Aroma</h2>
                    <p class="summary flex-grow-1">
                        Free Wi-Fi, sockets near tables, friendly barista and a cozy atmosphere will help you in
                        your exciting work or evening relax..
                    </p>
                    <button class="flex-grow-0">Learn more &raquo;</button>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
export default {
    name: "RoastingTabs"
}
</script>

<style scoped>

</style>

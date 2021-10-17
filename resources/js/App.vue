<template>
    <section style="height: 100vh;">
        <globalNav></globalNav>
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <router-view></router-view>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import globalNav from './utilitys/global-nav'
export default {
    name: "App",
    components: {
        globalNav
    },
}
</script>

<style scoped>

</style>

<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid text-center justify-content-center">
            <a class="navbar-brand" href="/">
                <img src="/storage/coollogo_com-23051627.gif" alt="" class="img-fluid w-50">
            </a>
            <form class="d-flex" @submit.prevent="searchCaptions">
                <input class="form-control me-2"
                       type="search"
                       placeholder="Search"
                       aria-label="Search"
                       v-model.lazy="search"
                />
                <div class="btn-group">
                    <button class="btn btn-outline-danger" type="submit">Search</button>
                    <button class="btn btn-outline-success" @click.prevent="randomImage">Random</button>
                </div>
            </form>
        </div>
    </nav>
</template>

<script>
import {mapActions} from "vuex";

export default {
    name: "global-nav",
    data() {
        return {
            search: null,
        }
    },
    methods: {
        ...mapActions('search', ['textSearch', ]),
        ...mapActions('singleImage', ['instantImage', 'holdImage']),
        searchCaptions() {
            this.textSearch(this.search).then(() => {
                // TODO add loader  loading state here
                if (this.$route.path !== '/') this.$router.push('/')
            }).catch(e => console.error(e))
        },
        randomImage() {
            this.search = null
            this.holdImage(null)
            this.instantImage().then(() => {
                if (this.$route.path !== '/view-image') this.$router.push('/view-image')
            }).catch(e => console.error(e))
        }
    }
}
</script>

<style scoped>

</style>

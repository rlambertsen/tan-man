<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">
                <img src="/storage/coollogo_com-23051627.gif" alt="" class="img-fluid w-50">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                <form class="d-flex" @submit.prevent="searchCaptions">
                    <input class="form-control me-2"
                           type="search"
                           placeholder="Search"
                           aria-label="Search"
                           v-model.lazy="search"
                    />
                    <button class="btn btn-outline-danger" type="submit">Search</button>
                </form>
            </div>
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
        ...mapActions('search', ['textSearch']),
        ...mapActions('singleImage', ['holdImage']),
        searchCaptions() {
            this.textSearch(this.search).then(() => {
                // TODO add loader  loading state here
                if (this.$route.path !== '/') this.$router.push('/')
            }).catch(e => console.error(e))
        },
    }
}
</script>

<style scoped>

</style>

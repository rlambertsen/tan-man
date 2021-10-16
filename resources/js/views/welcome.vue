<template>
    <div>
        <form>

            <div class="form-group">
                <label>Search Captions</label>
                <input type="text" v-model.lazy="search"/>
            </div>
            <div class="form-group">
                <button class="btn btn-success" @click.prevent="searchCaptions">Search</button>
            </div>
        </form>
        <div class="row row-cols-1 row-cols-md-4 g-4" v-if="results">
            <div class="col" v-for="(block, index) in results">
                <div class="card" :key="index">
                    <img :src="block.url" alt="" :key="index" class="img-fluid">
<!--                    <div class="card-body">-->
<!--                        <p class="card-text">Season #: {{block.episodeSeason}}</p>-->
<!--                        <p class="card-text">Episode Title: {{block.episodeTitle}}</p>-->
<!--                        <p class="card-text">Episode #{{block.episodeNumber}}</p>-->
<!--                        <p class="card-text">Caption: {{block.text}}</p>-->
<!--                        <p class="card-text">Start: {{block.startTime}}</p>-->
<!--                        <p class="card-text">End: {{block.stopTime}}</p>-->
<!--                    </div>-->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "welcome",
    data() {
        return {
            captionFile: null,
            videoFile: null,
            search:null,
            results: null,
        }
    },
    methods: {

        searchCaptions() {
            window.axios.post('/search', {search: this.search}).then((response) => {
                this.results = response.data
            }).catch(error => console.log(error))
        },
    }
}
</script>

<style scoped>

</style>

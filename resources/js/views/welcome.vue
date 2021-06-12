<template>
    <div>
        <form>
            <div class="form-group">
                <label>File upload</label>
                <input type="file" @change="onFileChange"/>
            </div>
            <div class="form-group">
                <button class="btn btn-primary" @click.prevent="upload">save</button>
            </div>
            <div class="form-group">
                <label>Search Captions</label>
                <input type="text" v-model.lazy="search"/>
            </div>
            <div class="form-group">
                <button class="btn btn-success" @click.prevent="searchCaptions">Search</button>
            </div>
        </form>
        <template v-if="results">
            <template v-for="(text, index) in results">
                <div :key="index">
                    <p>Season #: {{text.episodeSeason}}</p>
                    <p>Episode Title: {{text.episodeTitle}}</p>
                    <p>Episode #{{text.episodeNumber}}</p>
                    <p>Caption: {{text.text}}</p>
                    <p>Start: {{text.startTime}}</p>
                    <p>End: {{text.stopTime}}</p>
                </div>
            </template>
        </template>
    </div>
</template>

<script>
export default {
    name: "welcome",
    data() {
        return {
            file: null,
            search:null,
            results: null,
        }
    },
    methods: {
        upload(e) {
            e.preventDefault();
            let currentObj = this;

            const config = {
                headers: { 'content-type': 'multipart/form-data' }
            }

            let formData = new FormData();
            formData.append('file', this.file);

            window.axios.post('/upload', formData, config).then(function (response) {
                currentObj.success = response.data.success;
            }).catch(function (error) {
                currentObj.output = error;
            });
        },
        onFileChange(e){
            console.log(e.target.files[0]);
            this.file = e.target.files[0];
        },
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

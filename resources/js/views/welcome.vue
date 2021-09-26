<template>
    <div>
        <form>
            <div class="form-group">
                <label>Upload Captions File First (.srt)</label>
                <input type="file" @change="onFileCaptionChange"/>
            </div>
            <div class="form-group">
                <button class="btn btn-primary" @click.prevent="uploadCaption">save</button>
            </div>
            <div class="form-group">
                <label>Then Upload Video File</label>
                <input type="file" @change="onFileVideoChange"/>
            </div>
            <div class="form-group">
                <button class="btn btn-primary" @click.prevent="uploadVideo">save</button>
            </div>
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
                    <div class="card-body">
                        <p class="card-text">Season #: {{block.episodeSeason}}</p>
                        <p class="card-text">Episode Title: {{block.episodeTitle}}</p>
                        <p class="card-text">Episode #{{block.episodeNumber}}</p>
                        <p class="card-text">Caption: {{block.text}}</p>
                        <p class="card-text">Start: {{block.startTime}}</p>
                        <p class="card-text">End: {{block.stopTime}}</p>
                    </div>
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
        uploadVideo(e) {
            e.preventDefault();
            let currentObj = this;

            const config = {
                headers: { 'content-type': 'multipart/form-data' }
            }

            let formData = new FormData();
            formData.append('file', this.videoFile);

            window.axios.post('/upload_video_file', formData, config).then(function (response) {
                currentObj.success = response.data.success;
            }).catch(function (error) {
                currentObj.output = error;
            });
        },
        uploadCaption(e) {
            e.preventDefault();
            let currentObj = this;

            const config = {
                headers: { 'content-type': 'multipart/form-data' }
            }

            let formData = new FormData();
            formData.append('file', this.captionFile);

            window.axios.post('/upload_caption_file', formData, config).then(function (response) {
                currentObj.success = response.data.success;
            }).catch(function (error) {
                currentObj.output = error;
            });
        },
        onFileVideoChange(e){
            console.log(e.target.files[0]);
            this.videoFile = e.target.files[0];
        },
        onFileCaptionChange(e){
            console.log(e.target.files[0]);
            this.captionFile = e.target.files[0];
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

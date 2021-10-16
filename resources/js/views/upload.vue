<template>
    <section class="row">
        <div class="col-12-lg">
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
        </div>
    </section>
</template>

<script>
export default {
    name: "upload",
    data(){
        return {
            captionFile: null,
            videoFile: null,
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
    },
}
</script>

<style scoped>

</style>

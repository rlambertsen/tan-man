<template>
    <section>
        <div class="row mt-3 justify-content-center align-items-center" v-if="imageObject">
            <div class="col-lg-4">
            <div class="card" style="background-color: #000">
                <div class="card-body text-center">
                    <template v-if="userImage">
                        <img :src="userImage" class="img-fluid text-center" alt=""/>
                        <button class="btn btn-sm btn-success mt-2" @click="downloadMeme">Download</button>
                    </template>
                    <template v-else>
                        <img :src="imageObject.url"
                             :alt="imageObject.text"
                             class="img-fluid text-center"
                             ref="currentImage"
                        />
                    </template>
                </div>
            </div>
        </div>
            <div class="col-lg-6">
                <div class="image-data" v-if="!makeMeme">
                    <h4>{{imageObject.episodeTitle}}</h4>
                    <p>
                        <small>Season: {{imageObject.episodeSeason}}</small> /
                        <small>Episode #: {{imageObject.episodeNumber}}</small>
                    </p>
                    <hr class="w-50"/>
                    <p v-if="removeText">"{{removeText}}"</p>
                    <button class="btn btn-sm btn-success" @click="createMeme">Make MEME</button>
                </div>
                <div class="meme-form row" v-if="makeMeme">
                    <div class="col-xs-12 text-white">
                        <h4>Add Your Text Here!</h4>
                        <div class="form-group w-50">
                            <textarea v-model="userMemeText" class="form-control"></textarea>
                        </div>
                        <button class="btn-warning btn btn-sm mt-2" @click="GIFSHOT">Generate MEME</button>
                    </div>
                </div>
            </div>
        </div>
        <nearImages v-if="nearImages"></nearImages>
    </section>
</template>

<script>
import nearImages from './near-image-list'
import {mapActions, mapState} from 'vuex'
export default {
    name: "view-image",
    components: {
        nearImages
    },
    computed: {
        ...mapState({
            imageObject: state => state.singleImage.imageObject,
            nearImages: state => state.singleImage.nearImages,
        }),
        removeText() {
            return (this.imageObject ? this.imageObject.text.replaceAll('%', '') : false)
        },
    },
    watch: {
        imageObject() {
            if (!this.imageObject) {
                this.makeMeme = false
                this.userMemeText = null
            } else {
                this.getNearImages(this.imageObject.id).catch(e => console.error(e))
            }
        },
    },
    data() {
        return {
            userImage: null,
            userMemeText: null,
            makeMeme: false,
        }
    },
    methods: {
        ...mapActions('singleImage', ['getSingleImage', 'getNearImages']),
        createMeme() {
            this.makeMeme = !this.makeMeme
            this.userMemeText = this.removeText
        },
        GIFSHOT() {
            this.$gifShot.createGIF({
                images: [{ src: this.imageObject.url}],
                gifWidth: this.$refs.currentImage.offsetWidth,
                gifHeight: this.$refs.currentImage.offsetHeight,
                text: this.userMemeText,
                resizeFont: true,
                textAlign: 'center',
                fontSize: '35px',
            },(obj) => {
                if (obj.error) {
                    alert('Oh no: ' + obj.error) // show the error to user
                    return false
                }
                if (!obj.error) {
                    this.userImage = obj.image
                }
            })
        },
        downloadMeme() {
            let a = document.createElement('a')
            a.href = 'data:image/png;' + this.userImage.split(';')[1]
            a.download = 'squidBillies.png'
            a.click()
            a.remove()
        }
    },
    created() {
        if (this.imageObject) this.getNearImages(this.imageObject.id).catch(e => console.error(e))
    },
}
</script>

<style scoped lang="scss">
.card{
    background-color: #000;
    color: #fff;
}
.image-data{
    color: #fff;
}
</style>

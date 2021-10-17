<template>
    <section>
        <div class="row mt-3 justify-content-center align-items-center" v-if="imageObject">
            <div class="col-lg-4">
            <div class="card" style="background-color: #000">
                <div class="card-body">
                    <img :src="imageObject.url"
                         :alt="imageObject.text"
                         class="img-fluid"
                         ref="currentImage"
                    />
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
                    <p v-if="removeText">{{removeText}}</p>
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
        <div class="row" v-if="userImage">
            <div class="col-lg-4">
                <img :src="userImage" class="img-fluid" alt=""/>
                <button class="btn btn-sm btn-success" @click="downloadMeme">Download</button>
            </div>
        </div>
    </section>
</template>

<script>
import {mapActions, mapState} from 'vuex'
export default {
    name: "view-image",
    computed: {
        ...mapState({
            imageObject: state => state.singleImage.imageObject,
        }),
        removeText() {
            return this.imageObject.text.replaceAll('%', '')
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
        ...mapActions('singleImage', ['getSingleImage']),
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
                console.log(obj)
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
    created() {},
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

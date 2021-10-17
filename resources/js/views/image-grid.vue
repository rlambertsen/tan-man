<template>
    <div class="row row-cols-1 row-cols-md-4 g-4 mt-2" v-if="results">
        <div class="col" v-for="(block, index) in results">
            <a href="#"
               @click.prevent="saveSingleImage(block)"
               :key="index"
            >
                <img :src="block.url" :alt="block.text" class="img-fluid">
            </a>
        </div>
    </div>
</template>

<script>
import {mapActions, mapState} from "vuex"
export default {
    name: "image-grid",
    computed: {
        ...mapState({
            results: state => state.search.results,
        })
    },
    data() {
        return {
            captionFile: null,
            videoFile: null,
        }
    },
    methods: {
        ...mapActions('singleImage', ['holdImage']),
        saveSingleImage(record) {
            this.holdImage(record)
            this.$router.push('/view-image')
        }
    }
}
</script>

<style scoped>

</style>

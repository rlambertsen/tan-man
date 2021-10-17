<template>
    <div class="row mt-3 justify-content-center align-items-center">
        <template v-for="(image, index) in nearImages">
            <div class="col-lg-2 text-center" :key="index">
                <img :src="image.url" class="img-fluid" :alt="image.text">
            </div>
        </template>
    </div>
</template>

<script>
import {mapState} from "vuex";

export default {
    name: "near-image-list",
    computed: {
        ...mapState({
            nearImages: state => [].concat.apply([], state.singleImage.nearImages).reverse(),
        }),
    },
}
</script>

<style scoped lang="scss">
.near-images{
    max-width: 155px;
}
</style>

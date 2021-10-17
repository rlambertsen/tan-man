<template>
    <div class="row justify-content-center align-items-center">
        <template v-if="!results">
            <div class="col-lg-12 text-center text-white">
                <h2>Here's The Beef &#10507;</h2>
                <h2>Tan-Man Stencils has all the juicy SquidBillies memes' you ever wanted!</h2>
                <p>Today's Earyl Culyer Hat Quote: Do something with your life, TAKE OFF YOUR TOP!</p>
            </div>
            <div class="col-sm-2">
                <img src="/storage/Early_Cuyler.png" alt="" class="img-fluid">
            </div>
            <div class="col-sm-2">
                <img src="/storage/Russell_Rusty_Cuyler.png" alt="" class="img-fluid">
            </div>
            <div class="col-sm-2">
                <img src="/storage/Granny_Cuyler.png" alt="" class="img-fluid">
            </div>
            <div class="col-sm-2">
                <img src="/storage/Sherif.png" alt="" class="img-fluid">
            </div>
            <div class="col-sm-2">
                <img src="/storage/DanHalen.png" alt="" class="img-fluid">
            </div>
        </template>
        <imageGrid v-else></imageGrid>
    </div>
</template>

<script>
// TODO add list of all of early hat sayins to title so every page gets a new hat quote
import imageGrid from './image-grid'
import {mapState} from "vuex";
export default {
    name: "home",
    components: {
        imageGrid
    },
    computed: {
        ...mapState({
            results: state => state.search.results,
        })
    },
}
</script>

<style scoped>

</style>

<script setup>

    defineProps({
        data: Object
    })


</script>

<template>
    <section class="social row">
        <h2 class="col-10 col-sm-7">SUIVEZ NOUS</h2>
        <div class="social__network col-10 col-md-8">
            <a :href=data[0].facebook><img src="https://gregory-wolff.com/images/facebook_logo.png" alt=""></a>
            <a :href=data[0].twitter><img src="https://gregory-wolff.com/images/twitter_logo.png" alt=""></a>
            <a :href=data[0].linkedin><img src="https://gregory-wolff.com/images/linkedin_logo.png" alt=""></a>
            <a :href=data[0].instagram><img src="https://gregory-wolff.com/images/instagram_logo.png" alt=""></a>
        </div>
    </section>

</template>

<style lang="scss" scoped>

    @import '../../../scss/variable.scss';
    @import '../../../scss/mixins.scss';

    .social{
        & h2{
            @include h2-main;
        }

        &__network{
            display: flex;
            justify-content: space-evenly;
            align-items: center;
            margin: 2em auto;
        }
    }

</style>
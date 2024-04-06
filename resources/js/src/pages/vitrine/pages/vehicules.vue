<script setup>

    import LinkPOO from '../../../components/LinkPOO.vue';
    import FilterFormComponent from '../../../components/FilterFormComponent.vue';

    defineProps({
        data: Object
    })

</script>

<template>
    <main class="row" id="top">

        <h1 class="col-10 col-sm-8 col-md-6">{{ data.count }}</h1>

        <FilterFormComponent :data="data"/>

        <div class="container__cards col-9 col-sm-6 col-lg-8">
            <div class="cards" v-for="annonce in data.annonces" :key="annonce.numero_annonce">
                <LinkPOO class="link" :to="`/dashboard/vehicule/${annonce.numero_annonce}`">
                    <div class="cards__image">
                        <img :src=annonce.images[0].adresse>
                    </div>
                    <div class="cards__description">
                        <div class="cards__description-title">
                            <h5>{{ annonce.marque }} {{ annonce.modele }}</h5>
                            <p>{{ annonce.motorisation }}</p>
                        </div>
                        <div class="cards__description-message">
                            <LinkPOO class="router" to="/dashboard/messages">
                                <div class="send">
                                    <i class="fa-solid fa-envelope" style="color: #f36639;"></i>
                                    <p>Demande de renseignement</p>
                                </div>
                            </LinkPOO>
                            <h3>{{ annonce.prix }}€</h3>
                        </div>
                    </div>
                </LinkPOO>
            </div>
        </div>
    </main>
</template>

<style lang="scss" scoped>


    @import '../../../../../scss/variable.scss';
    @import '../../../../../scss/mixins.scss';

    .link {
        text-decoration: none;
        color: $dark-grey;
    }

    .overflow-hidden {
        overflow-y: hidden;
    }

    p {
        font-size: 0.7em;
    }

    .router {
        text-decoration: none;
    }

    .send {
        display: flex;
        justify-content: center;
        align-items: center;
        
        & p {
            margin-left: 0.5em;
        }

        &__indicator {
            border-radius: 50%;
            background-color: blue;
            width: 1em;
            height: 1em;
            @include flex-center;
            color: white;
            position: absolute;
            transform: translate(-3.5em, -0.6em);

            & span {
                font-size: 0.7em;
            }
        }
    }

    h1 {
        margin: auto;
        text-align: center;
        margin-top: 5em;
        font-size: 2em;
    }

    h2,
    p,
    h5,
    h3 {
        margin: 0;
    }

    h3{
        color: $primary-color;
        font-weight: 800;
        font-size: 1.6em;
    }

    h2{
        @include h2-main;
        margin-top: 2em;
    }

    .addbtn {
        background-color: $primary-color;
        color: white;
        border: none;
        border-radius: 50%;
        width: 2em;
        height: 2em;
        font-size: 1.8em;
        position: fixed;
        right: 0;
        bottom: 20vh;
        box-shadow: 3px 3px 8px rgba($color: #000000, $alpha: 0.4);
        z-index: 100;
        transition: all 0.5s ease-in;
    }

    .closebtn {
        transform: rotate(405deg);
    }

    .container__cards {
        margin: auto;
    }

    .cards{
        display: flex;
        flex-direction: column;
        align-items: center;
        margin: 3em auto;
        font-family: $font-text-nav-card;
        box-shadow: 3px 3px 8px rgba($color: #000000, $alpha: 0.3);
        border-radius: 6px;

        &__description{
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            text-align: start;

            &-title{
                margin-top: 0.5em;
                margin-left: 0.5em;
                & p{
                    font-size: 0.8em;
                }
            }

            &-message{
                display: flex;
                justify-content: space-around;
                align-items: center;
                width: 100%;
                margin: 1em auto;
            }
        }

        &__image img{
            width: 100%;
            height: auto;
            border-radius: 6px 6px 0px 0px;
        }
    }

    .btn {
        display: flex;
        justify-content: center;
        align-items: center;
        margin: auto;

        span {
            padding: 0.5em 1em;
        }
    }

    .table {
        display: none;
        font-size: 0.8em;
        margin: 2em auto;
        margin-bottom: 5em;

        h5,
        h6 {
            color: $primary-color;
            margin-bottom: 2em;
        }

        &__header {
            margin: 1em auto;
            margin-top: 3em;
            padding: 1em;
            border-radius: 5px;
            box-shadow: 3px 3px 8px rgba($color: #000000, $alpha: 0.25);
            border: 1px solid rgba($color: #000000, $alpha: 0.1);
    
            &-head {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            &-cat {
                display: flex;
                justify-content: space-between;
            }
        }

        &__btn {
            display: flex;
            justify-content: end;
            margin: auto;

            &-btn {
                @include btn-style($primary-color);
                margin: 0;
                padding: 0.5em;
                font-size: 1.2em;
                text-decoration: none;

                & i {
                    color: $primary-color;
                    background: none;
                }

                &:hover i {
                    color: white;
                }
            }
        }

        &__body {

            margin: 0.4em auto;
            display: flex;
            flex-direction: column;
            border-radius: 5px;
            box-shadow: 3px 3px 8px rgba($color: #000000, $alpha: 0.25);
            height: 100%;
            padding: 1em;
            border: 1px solid rgba($color: #000000, $alpha: 0.1);

            &-elem {
                display: flex;
                justify-content: space-between;
                align-items: center;
                width: 100%;
                height: 100%;
            }
        }

        .elem {
            height: 100%;
            display: flex;
            align-items: center;
            padding: 0;

            &-btn {
                @include flex-center;
                flex-direction: column;
                color: $primary-color;
                cursor: pointer;
            }
        }
        .elem1 {
            width: 15%;

            & img {
                    height: auto;
                    width: 100%;
                }
        }

        .elem2 {
            width: 15%;
            justify-content: center;
            text-align: center;
            padding: 0.5em;
        }

        .elem3 {
            width: 15%;
            justify-content: center;
        }

        .elem4 {
            width: 15%;
        }

        .elem5 {
            width: 15%;
        }

        .elem6 {
            width: 25%;
            display: flex;
            justify-content: space-around;

            & i {
                font-size: 1.8em;
            }
        }
    }

    .top-page {
        @include btn-style($primary-color);
        position: relative;
        left: 35%;
        border-radius: 50%;
        width: 4vh;
        height: 4vh;
        font-size: 2em;
        padding: 0.5em;
        background-color: $primary-color;
        color: white;
        display: flex;
        justify-content: center;
        align-items: center;
        text-decoration: none;

            &:hover {
                transform: scale(1.3);
            }
    }


    @media screen and (min-width: 560px) {

        h2 {
            margin-top: 5em;
        }

        .row {
            flex-direction: column;
        }

        .container__cards {
            display: flex;
            flex-wrap: wrap;
            margin: 5em auto;

            & .cards{
                width: 50vw;
            }
        }
        
    }

    @media screen and (min-width: 720px) {

        .table {
            display: block;
        }

        form {
            width: 70vw;
            margin: auto;
            display: block;
        }
        .container__cards,
        .addbtn {
            // display: none;
        }

        .show {
            display:flex;
        }
    }

    @media screen and (min-width: 940px) {
        .container__cards .cards {
            width: 35vw;
        }

        h2 {
            margin-top: 5em;
        }
    }

    @media screen and (min-width: 1100px) {

        .container__cards .cards {
            width: 28vw;
        }
    }

    @media screen and (min-width: 1300px) {

        .container__cards .cards {
            width: 20vw;
        }
    }
</style>
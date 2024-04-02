<script setup>

    import LayoutView from '../../Layout/LayoutView.vue';
    import LinkPOO from '../../components/LinkPOO.vue';

    defineProps({
        data: Object
    })

</script>

<template>

    <LayoutView>

        <template #content>
        <main class="row" id="top">

            <h1 class="col-10 col-sm-8 col-md-6">{{ data.count }}</h1>

            <div class="container__cards col-9 col-sm-6 col-lg-8">
                <div class="cards" v-for="annonce in data" :key="annonce.numero_annonce">
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

    </LayoutView>

</template>

<style lang="scss" scoped>


    @import '../../../../scss/variable.scss';
    @import '../../../../scss/mixins.scss';

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

    form {
        display: none;
    }

    .offcanvas-header {
        background-color: $dark-grey;
        color: white;
        font-family: $font-text-nav-card;
    }

    .offcanvas__select {
        inset: none;
        appearance: none;
        border: none;
        border-bottom: 2px solid $color-text-dark;
        background-color: white;
        width: 80vw;
        color: $color-text-dark;
        font-size: 1em;
    }

    .offcanvas__selectdiv {

        &:after {
            content: '\2304';
            font-size: 30px;
            position: relative;
            left: 75vw;
            top: -7vh;
            color: $color-text-dark;
        }
    }

    .offcanvas__row {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 1em;
        width: 90%;
        margin: 1em auto 0 auto;
    }

    .offcanvas__btn {
        display: flex;
        justify-content: space-around;
        align-items: center;

        & button {
            @include btn-style($primary-color);
            margin: 0;
        }
    }

    .range-slider {
        position: relative;
        width: 80vw;
        height: 5vh;
        text-align: center;
        margin: 3em;

        & h6 {
            position: absolute;
            bottom: 150%;
            color: $color-text-dark;
        }

        & input {
            pointer-events: none;
            position: absolute;
            overflow: hidden;
            left: 0;
            top: 15px;
            width: 80vw;
            outline: none;
            height: 18px;
            margin: 0;
            padding: 0;

            &::-webkit-slider-thumb {
                pointer-events: all;
                position: relative;
                z-index: 1;
                outline: 0;
            }

            &::-moz-range-thumb {
                pointer-events: all;
                position: relative;
                z-index: 10;
                -moz-appearance: none;
                width: 9px;
            }

            &::-moz-range-track {
                position: relative;
                z-index: -1;
                background-color: rgba(0, 0, 0, 1);
                border: 0;
            }
        }

        & input:last-of-type::-moz-range-track {
            -moz-appearance: none;
            background: none transparent;
            border: 0;
        }

        & input[type=range]::-moz-focus-outer {
            border: 0;
        }
    }
    .output {
        position: absolute;
        border:1px solid #999;
        text-align: center;
        color: $primary-color;
        border-radius: 4px;
        display: inline-block;
        font: bold 15px/30px Helvetica, Arial;
        bottom: 75%;
        left: 0%;
        transform: translate(-50%, 0);
        padding: 0.1em 0.5em;
    }

    .output.outputTwo {
        left: 100%;
    }

    input[type=range] {
        -webkit-appearance: none;
        background: none;
    }

    input[type=range]::-webkit-slider-runnable-track {
        height: 5px;
        border: none;
        border-radius: 3px;
        background: transparent;
    }

    input[type=range]::-ms-track {
        height: 5px;
        background: transparent;
        border: none;
        border-radius: 3px;
    }

    input[type=range]::-moz-range-track {
        height: 5px;
        background: transparent;
        border: none;
        border-radius: 3px;
    }

    input[type=range]::-webkit-slider-thumb {
        -webkit-appearance: none;
        border: none;
        height: 16px;
        width: 16px;
        border-radius: 50%;
        background: #555;
        margin-top: -5px;
        position: relative;
        z-index: 10000;
    }

    input[type=range]::-ms-thumb {
        -webkit-appearance: none;
        border: none;
        height: 16px;
        width: 16px;
        border-radius: 50%;
        background: #555;
        margin-top: -5px;
        position: relative;
        z-index: 10000;
    }

    input[type=range]::-moz-range-thumb {
        -webkit-appearance: none;
        border: none;
        height: 16px;
        width: 16px;
        border-radius: 50%;
        background: #555;
        margin-top: -5px;
        position: relative;
        z-index: 10000;
    }

    input[type=range]:focus {
        outline: none;
    }

    .full-range,
    .incl-range {
        width: 100%;
        height: 5px;
        left: 0;
        top: 21px;
        position: absolute;
        background: #DDD;
    }

    .incl-range {
        background: rgb(195, 195, 195);
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

        .offcanvas,
        .btn-offcanvas {
            display: none;
        }

        .offcanvas__row {
            flex-direction: row;
            justify-content: space-around;
        }

        .offcanvas__select,
        .range-slider input {
            width: 100%;
        }
        .offcanvas__selectdiv,
        .range-slider {
            width: 25%;
        }

        .range-slider {
            margin: 3em 0;

            .output {
                font-size: 0.8em;
            }
        }

        .offcanvas__selectdiv::after {
            left: 90%;
            top: -5vh;
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
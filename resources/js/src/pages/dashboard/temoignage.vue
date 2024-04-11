<script setup>

    import LayoutView from '../../Layout/LayoutView.vue';

    const props = defineProps({
        data: Object
    })

    console.log(props.data)

</script>

<template>
    <LayoutView>
        <template #content>
            <main class="row">
                <section class="mobile">
                    <h1 class="col-9">{{ data.count }}</h1>
                    <h2 class="col-9" v-if="countMessages<=1">TEMOIGNAGE NON TRAITE</h2>
                    <h2 class="col-9" v-else>TEMOIGNAGES NON TRAITES</h2>

                    <TransitionGroup name="slide-fade">
                    <div class="message col-9" v-for="showAwaitTestimony in showAwaitTestimonys" :key="showAwaitTestimony.id" @click="isAction ? isAction=false : isAction=true">
                        <div class="message__element">
                            <p class="message__element-title">Nom/Prénom:</p>
                            <p>{{ showAwaitTestimony.nom }} {{ showAwaitTestimony.prenom }}</p>
                        </div>
                        <div class="message__element">
                            <p class="message__element-title">Date:</p>
                            <p>{{ showAwaitTestimony.date }}</p>
                        </div>
                        <div class="message__element">
                            <p class="message__element-title">Note:</p>
                            <p class="message__element-result">{{ showAwaitTestimony.note }}</p>
                        </div>
                        <div class="message__text">
                            <p class="message__element-title">Commentaire:</p>
                            <p>{{ showAwaitTestimony.commentaire }}</p>
                        </div>

                            <div class="message__option" v-if="isAction">
                                <div class="message__option-btn" @click="goAccept(showAwaitTestimony.id)">
                                    <i class="fa-regular fa-circle-check"></i>
                                </div>
                                <div class="message__option-btn" @click="goRefuse(showAwaitTestimony.id)">
                                    <i class="fa-regular fa-circle-xmark"></i>
                                </div>
                            </div>
                    </div>
                    </TransitionGroup>
                </section>

                <section class="other">
                    <h2 class="col-10 col-sm-7 col-md-10">{{ data.count }} TEMOIGNAGE PUBLIE</h2>
                    <div class="testimony">
                        <TransitionGroup name="slide-fade">
                            <div class="testimony__card col-8 col-sm-7 col-md-3" v-for="temoignage in data.temoignages_publie" :key="temoignage.id" @click="goWithdraw(temoignage.id)">
                                <div class="testimony__card-person">
                                    <img src="http://gregory-wolff.com/images/anonymous1_avatars_grey_circles.jpg" alt="">
                                    <div class="delete-item">
                                        <i class="fa-regular fa-circle-xmark"></i>
                                        <span>Retirer du site</span>
                                    </div>
                                </div>
                                <div class="testimony__card-stars" v-if="temoignage.note === 1">
                                    <i class="fa-solid fa-star" style="color: #f36639;"></i>
                                    <i class="fa-regular fa-star" style="color: #f36639;"></i>
                                    <i class="fa-regular fa-star" style="color: #f36639;"></i>
                                    <i class="fa-regular fa-star" style="color: #f36639;"></i>
                                    <i class="fa-regular fa-star" style="color: #f36639;"></i>
                                </div>
                                <div class="testimony__card-stars" v-if="temoignage.note === 2">
                                    <i class="fa-solid fa-star" style="color: #f36639;"></i>
                                    <i class="fa-solid fa-star" style="color: #f36639;"></i>
                                    <i class="fa-regular fa-star" style="color: #f36639;"></i>
                                    <i class="fa-regular fa-star" style="color: #f36639;"></i>
                                    <i class="fa-regular fa-star" style="color: #f36639;"></i>
                                </div>
                                <div class="testimony__card-stars" v-if="temoignage.note === 3">
                                    <i class="fa-solid fa-star" style="color: #f36639;"></i>
                                    <i class="fa-solid fa-star" style="color: #f36639;"></i>
                                    <i class="fa-solid fa-star" style="color: #f36639;"></i>
                                    <i class="fa-regular fa-star" style="color: #f36639;"></i>
                                    <i class="fa-regular fa-star" style="color: #f36639;"></i>
                                </div>
                                <div class="testimony__card-stars" v-if="temoignage.note === 4">
                                    <i class="fa-solid fa-star" style="color: #f36639;"></i>
                                    <i class="fa-solid fa-star" style="color: #f36639;"></i>
                                    <i class="fa-solid fa-star" style="color: #f36639;"></i>
                                    <i class="fa-solid fa-star" style="color: #f36639;"></i>
                                    <i class="fa-regular fa-star" style="color: #f36639;"></i>
                                </div>
                                <div class="testimony__card-stars" v-if="temoignage.note === 5">
                                    <i class="fa-solid fa-star" style="color: #f36639;"></i>
                                    <i class="fa-solid fa-star" style="color: #f36639;"></i>
                                    <i class="fa-solid fa-star" style="color: #f36639;"></i>
                                    <i class="fa-solid fa-star" style="color: #f36639;"></i>
                                    <i class="fa-solid fa-star" style="color: #f36639;"></i>
                                </div>
                                <div class="testimony__card-text">
                                    <p>{{ temoignage.commentaire }}</p>
                                </div>
                                <div class="testimony__card-name">
                                    <p>{{ temoignage.prenom }} {{ temoignage.nom }}</p>
                                </div>
                            </div>
                        </TransitionGroup>
                    </div>
                    
                        <div class="table row">
                            <div class="table__header col-md-10 col-lg-8">
                                <div class="table__header-head">
                                    <h5>Nouveau témoignages clients</h5>
                                    <h5>{{ data.count_attente }}</h5>
                                </div>
                                <div class="table__header-cat">
                                    <h6 class="elem elem1">Nom</h6>
                                    <h6 class="elem elem2">Prénom</h6>
                                    <h6 class="elem elem3">Date</h6>
                                    <h6 class="elem elem4">Note</h6>
                                    <h6 class="elem elem5">Message</h6>
                                    <h6 class="elem elem6">Actions</h6>
                                </div>
                            </div>
                            <TransitionGroup name="slide-fade">
                            <div class="table__body col-md-10 col-lg-8" v-for="showAwaitTestimony in data.temoignages_attente" :key="showAwaitTestimony.id" @click="showOptions(showAwaitTestimony.id)">
                                <div class="table__body-elem">
                                    <span class="elem elem1">{{ showAwaitTestimony.nom }}</span>
                                    <span class="elem elem2">{{ showAwaitTestimony.prenom }}</span>
                                    <span class="elem elem3">{{ showAwaitTestimony.date }}</span>
                                    <span class="elem elem4">
                                        <i class="fa-solid fa-star" v-for="note in showAwaitTestimony.note"></i>
                                    </span>
                                    <span class="elem elem5">{{ showAwaitTestimony.commentaire }}</span>
                                
                                    <span class="elem elem6">
                                        <div class="elem-btn" @click="goAccept(showAwaitTestimony.id)">
                                            <i class="fa-regular fa-circle-check"></i>
                                            <p>Publier sur le site</p>
                                        </div>
                                        <div class="elem-btn" @click="goRefuse(showAwaitTestimony.id)">
                                            <i class="fa-regular fa-circle-xmark"></i>
                                            <p>Supprimer</p>
                                        </div>
                                    </span>
                                </div>
                            </div>
                            </TransitionGroup>
                        </div>
                </section>
            </main>
        </template>
    </LayoutView>
</template>

<style lang="scss" scoped>

    @import '../../../../scss/variable.scss';
    @import '../../../../scss/mixins.scss';

    main {
        margin-bottom: 3em;
    }

    h2 {
        @include h2-main;
        margin-top: 0.5em;
        margin-bottom: 2em;
    }

    h1 {
        margin: auto;
        text-align: center;
        margin-top: 3em;
    }

    .testimony {
        width: 75vw;
        margin: auto;
    }

    .testimony__card{
        display: flex;
        flex-direction: column;
        align-items: center;
        margin: 3em auto;
        cursor: pointer;

        &-person img{
            width: 25vw;
            height: 25vw;
            @include flex-center;
            box-shadow: 3px 3px 6px rgba($color: #000000, $alpha: 0.3);
            border-radius: 50%;
            margin: 1em auto;
        }

        .delete-item {
            position: absolute;
            transform: translate(4vw, -10vh);
            font-size: 1.2em;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: start;

            & span {
                font-size: 0.8em;
            }
        }

        &-stars{
            margin: 1em auto;
        }

        &-text{
            font-size: 0.9em;
            text-align: center;
        }

        &-name{
            font-weight: 600;
        }
    }

    .message{
        border-radius: 5px;
        box-shadow: 3px 3px 8px rgba($color: #000000, $alpha: 0.4);
        margin: 1em auto;
        padding: 1em;

        &__element {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.8em;

            &-title {
                font-weight: 600;
            }

            &-result {
                color: $primary-color;
                font-weight: 600;
            }
        }

        &__text {
            font-size: 0.8em;
        }

        &__option {
            display: flex;
            justify-content: space-around;
            align-items: center;
            border-top: 1px solid rgba($color: #000000, $alpha: 0.8);
            padding-top: 1.5em;

            &-btn {
                border: 2px solid $primary-color;

                & i {
                    color: $primary-color;
                    padding: 1em;
                }

                &:hover {
                    border: none;
                    background-color: $primary-color;

                    & i {
                        color: white;
                    }
                }
            }
        }
    }
    .table {
        font-size: 0.8em;
        margin: 2em auto;
        margin-bottom: 5em;

        h5,
        h6 {
            color: $primary-color;
            margin-bottom: 2em;
        }

        &__header {
            margin: 2em auto;
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

            & h6 {
                color: $color-text-dark;
                margin: 0;
                margin-bottom: 0.5em;
                margin-top: 2em;
                font-size: 1.2em;
            }
        }

        &__body {

            margin: 0.2em auto;
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

        .higer {
            height: 10vh;
        }

        .elem {
            height: 100%;
            display: flex;
            align-items: center;
            padding: 0;
            color: $color-text-dark;

            &-btn {
                display: flex;
                flex-direction: column;
                justify-content: space-around;
                align-items: center;
                color: $primary-color;
                cursor: pointer;

                & i {
                    font-size: 1.4em;
                }
            }
        }
        .elem1 {
            width: 8%;
        }

        .elem2 {
            width: 8%;
        }

        .elem3 {
            width: 10%;
        }

        .elem4 {
            width: 10%;
        }

        .elem5 {
            width: 46%;
        }

        .elem6 {
            width: 30%;
            display: flex;
            justify-content: space-around;
        }
    }

    .message__option-2 {
        display: none;
        border: none;
    }

    .other {
        display: none;
    }

    .active {
        display: flex;
    }

    .v-enter-active,
    .v-leave-active {
    transition: all 0.75s ease-out;
    }

    .v-enter-to {
    height: auto;
    opacity: 1;
    }

    .v-enter-from {
    height: 0;
    opacity: 0;
    }

    .v-leave-to {
    height: auto;
    opacity: 0;
    }

    .v-leave-from {
    height: auto;
    opacity: 1;
    }

    @media screen and (min-width: 768px) {
        .other {
            display: block;
        }

        .mobile {
            display: none;
        }

        .testimony {
            display: flex;
            flex-wrap: wrap;
        }
        .testimony__card{

            &-person img{
                width: 8vw;
                height: 8vw;
            }

            &-person .delete-item {
                transform: translate(9vw, -10vh);
            }

            &-text {
                width: 50%;
            }
        }
    }

    @media screen and (min-width: 960px) {
        .testimony__card{

            &-person img{
                width: 8vw;
                height: 8vw;
            }

            &-text {
                font-size: 0.8em;
            }
        }
    }

    @media screen and (min-width: 1260px) {

        .testimony__card{

            &-person img{
                width: 3vw;
                height: 3vw;
            }

            .delete-item {
            position: absolute;
            transform: translate(4vw, -12vh);
            font-size: 1.2em;
        }

            &-text {
                font-size: 0.9em;
            }
        }
    }

</style>
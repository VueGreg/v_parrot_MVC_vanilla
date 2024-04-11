<script setup>

    import Link from './LinkPOO.vue';

    defineProps({
        isConnect: Boolean
    })

</script>

<template>
    <nav class="row" v-if="isConnect">
        <div class="bar col-10 col-sm-8 m-auto">
            <Link class="link" to="http://parrotpoo.test/dashboard/employe">
                <div class="bar__btn">
                    <i class="fa-solid fa-users"></i>
                    <div class="bar__btn-indicator">
                        <span>{{ countUsers }}</span>
                    </div>
                    <h5 v-if="isConnect">EMPLOYES</h5>
                </div>
            </Link>
            <Link class="link" to="http://parrotpoo.test/dashboard/parametre">
                <div class="bar__btn">
                    <i class="fa-solid fa-gear"></i>
                    <h5 v-if="isConnect">INFORMATIONS ENTREPRISE</h5>
                </div>
            </Link>
            <Link class="link" to="http://parrotpoo.test/dashboard/message">
                <div class="bar__btn">
                    <i class="fa-solid fa-message"></i>
                    <div class="bar__btn-indicator">
                        <span>{{ countMessages }}</span>
                    </div>
                    <h5 v-if="isConnect">MESSAGES CLIENTS</h5>
                </div>
            </Link>
            <RouterLink class="link" to="/annonces">
                <div class="bar__btn" :class="{'active': path =='/annonces'}"> 
                    <i class="fa-solid fa-car"></i>
                    <div class="bar__btn-indicator">
                        <span>{{ countVehicles }}</span>
                    </div>
                    <h5 v-if="isConnect">PARC AUTOMOBILE</h5>
                </div>
            </RouterLink>
            <Link class="link" to="http://parrotpoo.test/dashboard/temoignage">
                <div class="bar__btn"> 
                    <i class="fa-regular fa-comment-dots"></i>
                    <div class="bar__btn-indicator">
                        <span>{{ countTestimony }}</span>
                    </div>
                    <h5 v-if="isConnect">TEMOIGNAGES</h5>
                </div>
            </Link>
        </div>
    </nav>
    <nav class="row" v-else-if="path != '/connexion' && path != '/erreur'">
        <div class="bar  col-10 col-sm-8 m-auto">
            <RouterLink class="link" to="/reparations">
                <div class="bar__btn">
                    <i class="fa-solid fa-screwdriver-wrench"></i>
                    <div class="bar__btn-text">
                        <h5>SERVICE REPARATION</h5>
                        <p>Découvrez l'ensemble de nos prestations</p>
                    </div>
                </div>
            </RouterLink>
            <RouterLink class="link" to="/">
                <div class="bar__btn">
                    <i class="fa-solid fa-book"></i>
                    <div class="bar__btn-text">
                        <h5>DONNEZ NOUS VOTRE AVIS</h5>
                        <p>Découvrez l'ensemble de nos prestations</p>
                    </div>
                </div>
            </RouterLink>
            <RouterLink class="link" to="/contact/0">
                <div class="bar__btn">
                    <i class="fa-solid fa-users"></i>
                    <div class="bar__btn-text">
                        <h5>CONTACTEZ NOUS</h5>
                        <p>Découvrez l'ensemble de nos prestations</p>
                    </div>
                </div>
            </RouterLink>
            <RouterLink class="link" to="/annonces">
                <div class="bar__btn">
                    <i class="fa-solid fa-car"></i>
                    <div class="bar__btn-text">
                        <h5>NOTRE PARC D'OCCASIONS</h5>
                        <p>Découvrez l'ensemble de nos prestations</p>
                    </div>
                </div>
            </RouterLink>
        </div>
    </nav>

</template>

<style lang="scss" scoped>

    @import '../../../scss/variable.scss';
    @import '../../../scss/mixins.scss';

    nav {
        display: none;
    }

    .appBar {
        display: block;
    }

    .link {
        text-decoration: none;
    }

    .bar {
        display: flex;
        justify-content: center;
        align-items: center;
        margin: auto;
        position: fixed;
        bottom: 0;
        z-index: 20;
        left: 8%;
        height: 60px;

        &__btn {
            background-color: $primary-color;
            height: 60px;
            width: 60px;
            @include flex-center;

            & i {
                color: white;
            }

            & h5,
            & p {
                display: none;
            }

            &-indicator {
                background-color: blue;
                height: 1.2em;
                width: 1.2em;
                border-radius: 50%;
                position: absolute;
                transform: translate(0.8em, -0.8em);
                @include flex-center;
                color: white;

                & span {
                    font-size: 0.6em;
                }
            }
        }
    }

    .active {
        background: none;
        box-shadow: 0 0 8px rgba($color: white, $alpha: 0.8);

        & i,
        & h5 {
            color: $primary-color;
        }
    }

    @media screen and (min-width: 576px) {

        nav {
            display: block;
        }
        .bar {
            display: flex;
            flex-wrap: nowrap;
            gap: 1em;
            position: absolute;
            left: 16vw;
            top: 14vh;

            &__btn {
                height: 90px;
                width: 90px;
                flex-direction: column;
                justify-content: space-around;
                text-align: center;
                color: white;

                & h5 {
                    font-size: 0.7em;
                    display: block;
                }

                & i {
                    font-size: 30px;
                }

                &-indicator {
                    transform: translate(25px, -35px);
                }
            }
        }
    }

    @media screen and (min-width: 768px) {
        .bar {
            top: 16vh;
        }
    }

    @media screen and (min-width: 992px) {
        .bar {
            top: 28vh;

            &__btn {
                height: 120px;
                width: 120px;

                & h5 {
                    font-size: 1em;
                    display: block;
                }

                & i {
                    font-size: 40px;
                }

                &-indicator {
                    transform: translate(25px, -48px);
                }
            }
        }
    }

    @media screen and (min-width: 1200px) {
        .bar {
            top: 78vh;
            &__btn {
                height: 150px;
                width: 150px;

                & h5 {
                    font-size: 1.1em;
                    display: block;
                }

                & i {
                    font-size: 45px;
                }

                &-indicator {
                    transform: translate(30px, -60px);
                }
            }
        }
    }

    @media screen and (min-width: 1400px) {
        .bar {
            &__btn {
                height: 170px;
                width: 170px;

                & h5 {
                    font-size: 1.2em;
                    display: block;
                }

                & p {
                    font-size: 0.8em;
                    display: block;
                }

                & i {
                    font-size: 55px;
                }

                &-indicator {
                    transform: translate(30px, -68px);
                }
            }
       
        }
    }

    @media screen and (min-width: 1700px) {
        .bar {
            &__btn {
                height: 200px;
                width: 200px;

                & h5 {
                    font-size: 1.2em;
                    display: block;
                }

                & p {
                    font-size: 0.8em;
                    display: block;
                }

                & i {
                    font-size: 55px;
                }
            }
        }
    }


</style>
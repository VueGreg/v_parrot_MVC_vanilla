<script setup>

</script>


<template>
    <nav class="navbar navbar-expand-lg navbar-expand-sm navbar-dark nav__navigate">
    <div class="container-fluid">
            <RouterLink class="nav__navigate-link" :class="{'active': path == '/'}" to="/">Acceuil</RouterLink>
            <RouterLink class="nav__navigate-link" :class="{'active': path == '/reparations'}" to="/reparations">Reparation</RouterLink>
            <RouterLink class="nav__navigate-link" :class="{'active': path == '/annonces'}" to="/annonces">Véhicules d'occasion</RouterLink>
        <button class="nav__navigate-btn navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
            <RouterLink class="nav__navigate-link" active-class="active" to="/contact/0">Contact</RouterLink>
            <RouterLink class="nav__navigate-link" to="/dashboard/messages" v-if="isConnect">Tableau de bord</RouterLink>
        </div>
        </div>
    </div>
</nav>
</template>

<style lang="scss" scoped>
    @import '../../../scss/variable.scss';
    @import '../../../scss/mixins.scss';

    .navbar,
    .navbar-nav {

        height: 100%;
        padding: 0;
    }

    .navbar-nav {
        background-color: $primary-color;
        padding-left: 2em;
    }

    .active {

        color: $dark-grey;

        &:focus{
                color: $dark-grey;
            }

        &:focus::before{
            content: '';
                position: absolute;
                width: 110%;
                height: 90%;
                border-bottom: 5px solid rgb(255, 255, 255);
                animation: animate 0.2s linear;
        }
    }
    .nav__navigate{
        background-color: $primary-color;
        height: 6vh;

        &-link{
            text-decoration: none;
            color: white;
            font-family: $font-text-nav-card;
            font-weight: 500;
            position: relative;
            padding: 0;
            height: 100%;

            &:focus{
                color: $dark-grey;
            }

            &:focus::before{
                content: '';
                position: absolute;
                width: 110%;
                height: 90%;
                border-bottom: 5px solid rgb(255, 255, 255);
                animation: animate 0.2s linear;;
            }
        }

        &-btn{
            background-color: $primary-color;
            border: none;
        }
    }

    @keyframes animate {
        0%{
            width: 0;
        }
        100%{
            width: 100%;
        }
    }

    @media screen and (min-width: 575px) {

        .container-fluid,
        .navbar-collapse{
            width: 80vw;
            display: flex;
            justify-content: space-around;
            align-items: center;
            height: 100%;

            a{
                display: flex;
                align-items: center;
            }
        }

        .container-fluid {
            margin-left: 8vw;
        }

        #navbarNavAltMarkup {
            width: 28vw;
            flex-grow: 0;
        }

        .navbar-nav {
            width: 100%;
            justify-content: space-between;
        }

        .nav__navigate-link{

            &:focus::before{
                content: '';
                position: absolute;
                width: 110%;
                height: 90%;
                border-bottom: 5px solid rgb(255, 255, 255);
                animation: animate 0.2s linear;
            }

            &:hover::before{
                content: '';
                position: absolute;
                width: 110%;
                height: 90%;
                border-bottom: 5px solid rgb(255, 255, 255);
                animation: animate 0.2s linear;
            }
        }
    }

    @media screen and (min-width: 1200px) {
        .container-fluid {
            width: 50vw;
        }

        #navbarNavAltMarkup {
            width: 16vw;
        }

    }
</style>
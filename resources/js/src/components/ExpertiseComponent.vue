<template>
    <section class="expertise row">
            <h2 class="expertise__title col-10 col-sm-7 col-md-10">NOTRE SAVOIR FAIRE</h2>
            <img class="expertise__image col-9 col-sm-6 col-md-4" src="https://gregory-wolff.com/images/123919893_l_normal_none.jpg" alt="">
            <p class="expertise__text col-10 col-sm-7 col-md-4">
                Intervenant sur tous les types de véhicules , votre mécanicien V.PARROT vous propose des réparations de mécaniques respectueuses des données constructeur autant dans le remplacement des pièces moteur que des organes de distribution, systèmes de freinage, amortisseurs… 
                Notre expert en mécanique générale se tient à votre disposition pour réaliser le diagnostic de la panne ou du dysfonctionnement de votre véhicule et pour vous remettre un devis détaillé et transparent sur les réparations à prévoir. Au sein de notre garage automobile, nous intervenons sur plusieurs types de pannes avec des solutions de réparations sur mesure et avec la garantie de repartir au volant avec un véhicule parfaitement sécurisé.
            </p>
    </section>
</template>

<style lang="scss" scoped>

    @import '../../../scss/variable.scss';
    @import '../../../scss/mixins.scss';

    .expertise{
        background-color: $light-grey;
        padding: 1em;
        text-align: center;

        &__title {
            @include h2-main;
        }

        &__image {
            height: auto;
            margin: auto;
        }

        &__text{
            margin: 3em auto;
            font-size: 0.9em;
        }
    }

    @media screen and (min-width: 1200px) {
        
        .expertise {
            display: flex;
            align-items: center;
        
            &__image {
                height: 60vh;
            }

            &__text {
                font-size: 1em;
                line-height: 2em;
            }
        }
    }

    @media screen and (min-width: 1800px) {
        
        .expertise {
        
            &__image {
                height: 90vh;
            }

            &__text {
                line-height: 3em;
            }
        }
    }

</style>
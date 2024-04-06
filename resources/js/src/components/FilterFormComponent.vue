<script setup>
    import useFilterForm from './services/_FilterFormServices';
    import { onMounted, ref, watch, reactive } from 'vue';
    import axios from 'axios';

    const { getBaseFilter, baseFilter } = useFilterForm();
    const isRotated = ref(false);

    const formData = reactive({
        marque: null,
        modele: null
    });

    const listMarque = ref([]);
    const listModele = ref([]);
    const listEnergie = ref([]);

    const toggleRotation = () => {
        isRotated.value = !isRotated.value;
    };

    onMounted(async() => {
        await getBaseFilter();
        if (baseFilter && baseFilter.value) {
            listMarque.value = baseFilter.value.marqueDispo;
            listModele.value = baseFilter.value.modeleDispo;
            listEnergie.value = baseFilter.value.energieDispo;
        }
    });

    watch(() => formData.marque, async(param) => {
        if (!param) return;
        try {
            const response = await axios.get(`http://parrotpoo.test/filtre/params?marque=${param.marque}`);
            listModele.value = response.data;
            listEnergie.value = response.data;
        } catch (error) {
            console.error(error);
        }
    });

    watch(() => formData.modele, async(param) => {
        if (!param) return;
        try {
            const values = Object.values(baseFilter.value.modeleEtMarque);
            values.forEach(element => {
                if (element.modele === param) {
                    formData.marque = element.marque;
                }
            });
            const response = await axios.get(`http://parrotpoo.test/filtre/params?modele=${param.modele}`);
            listEnergie.value = response.data;
        } catch (error) {
            console.error(error);
        }
    });
</script>


<template>

    <form>
        <div class="offcanvas__row">
            <div class="offcanvas__selectdiv" :class="{ 'rotated': isRotated }" @click="toggleRotation">
                    <select class="offcanvas__select" v-model="formData.marque" name="marque" id="marque">
                        <option value="0" disabled selected>Marque</option>
                        <option v-for="marque in listMarque" :value="marque">{{ marque.marque }}</option>
                    </select>
                </div>
                <div class="offcanvas__selectdiv" :class="{ 'rotated': isRotated }" @click="toggleRotation">
                    <select class="offcanvas__select" v-model="formData.modele" name="modele" id="modele">
                        <option value="0" disabled selected>Modèle</option>
                        <option v-for="modele in listModele" :value="modele">{{ modele.modele }}</option>
                    </select>
                </div>
                <div class="offcanvas__selectdiv" :class="{ 'rotated': isRotated }" @click="toggleRotation">
                    <select class="offcanvas__select" v-model="energie" name="energie" id="energie">
                        <option value="0" disabled selected>Energie</option>
                        <option v-for="energie in listEnergie" :value="energie">{{ energie.energie || energie.nom }}</option>
                    </select>
                </div>
        </div>
        <div class="offcanvas__row">
                <section class="range-slider">
                    <h6>Prix</h6>
                    <label for="priceMini" class="output outputOne outputPriceMini">{{ prixMin }}€</label>
                    <label for="priceMaxi" class="output outputTwo outputPriceMaxi">{{ prixMax }}€</label>
                    <span class="full-range"></span>
                    <span class="incl-range"></span>
                    <input id="priceMini" name="priceMini" :min="prixMinRequest" :max="prixMaxRequest" step="100" type="range" v-model="prixMin">
                    <input id="priceMaxi" name="priceMaxi" :min="prixMinRequest" :max="prixMaxRequest" step="100" type="range" v-model="prixMax">
                </section>

                <section class="range-slider">
                    <h6>Kilométrage</h6>
                    <label for="kilometerMin" class="output outputOne outputKilometerMin">{{ kilometerMin }}km</label>
                    <label for="kilometerMax" class="output outputTwo outputKilometerMax">{{ kilometerMax }}km</label>
                    <span class="full-range"></span>
                    <span class="incl-range"></span>
                    <input id="kilometerMin" name="kilometerMin" :min="kilometerMinRequest" :max="kilometerMaxRequest" step="1000" type="range" v-model="kilometerMin">
                    <input id="kilometerMax" name="kilometerMax" :min="kilometerMinRequest" :max="kilometerMaxRequest" step="1000" type="range" v-model="kilometerMax">
                </section>

                <section class="range-slider">
                    <h6>Année</h6>
                    <label for="yearMin" class="output outputOne outputYearMin">{{ yearMin }}</label>
                    <label for="yearMax" class="output outputTwo outputYearMax">{{ yearMax }}</label>
                    <span class="full-range"></span>
                    <span class="incl-range"></span>
                    <input id="yearMin" name="yearMin" :min="yearMinRequest" :max="yearMaxRequest" step="1" type="range" v-model="yearMin">
                    <input id="yearMax" name="yearMax" :min="yearMinRequest" :max="yearMaxRequest" step="1" type="range" v-model="yearMax">
                </section>
            </div>
            <div class="offcanvas__btn">
                <button @click.prevent="initialize()">Reinitialiser</button>
                <button data-bs-dismiss="offcanvas" @click.prevent="searchCars()">Rechercher</button>
            </div>
    </form>

</template>

<style lang="scss" scoped>

    @import '../../../scss/variable.scss';
    @import '../../../scss/mixins.scss';

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

        position: relative;

        &:after {
            content: '<';
            font-size: 1.6rem;
            font-family: Georgia, 'Times New Roman', Times, serif;
            position: absolute;
            left: 75vw;
            transform: rotate(-90deg);
            transition: all 0.3s ease-in-out;
            color: $color-text-dark;
        }

        &.rotated::after {
            transform: rotate(90deg);
            transition: all 0.3s ease-in-out;
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

    @media screen and (min-width: 720px) {
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
            top: -0.5rem;
        }
    }

</style>
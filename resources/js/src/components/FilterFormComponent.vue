<script setup>
    import useFilterForm from './services/_FilterFormServices';
    import { onMounted, ref, watch, reactive } from 'vue';
    import axios from 'axios';
    import DropDown from './tools/DropDown.vue';

    const { getBaseFilter, baseFilter } = useFilterForm();

    const yearMaxRequest = ref()
    const yearMinRequest = ref()
    const kilometerMaxRequest = ref()
    const kilometerMinRequest = ref()
    const prixMaxRequest = ref()
    const prixMinRequest = ref()
    const ecartAnnee = ref()
    const ecartKilometer = ref()
    const ecartPrix = ref()

    const formData = reactive({
        marque: null,
        modele: null,
        prixMin: null,
        prixMax: null,
        kilometerMin: null,
        kilometerMax: null,
        yearMin: null,
        yearMax: null,
        energie: null
    });

    const listMarque = ref([]);
    const listModele = ref([]);
    const listEnergie = ref([]);

    const selected = ref(false);

    const emit = defineEmits(['update:formData'])

    onMounted(async() => {
        await getBaseFilter();
        console.log(baseFilter.value)
        if (baseFilter && baseFilter.value) {
            listMarque.value = baseFilter.value.marqueDispo;
            listModele.value = baseFilter.value.modeleDispo;
            listEnergie.value = baseFilter.value.energieDispo;
            prixMinRequest.value = baseFilter.value.minPrice;
            prixMaxRequest.value = baseFilter.value.maxPrice;
            kilometerMinRequest.value = baseFilter.value.minKilometer;
            kilometerMaxRequest.value = baseFilter.value.maxKilometer;
            yearMinRequest.value = baseFilter.value.minYear;
            yearMaxRequest.value = baseFilter.value.maxYear;

            ecartAnnee.value = yearMaxRequest.value - yearMinRequest.value;
            ecartKilometer.value = kilometerMaxRequest.value - kilometerMinRequest.value;
            ecartPrix.value = prixMaxRequest.value - prixMinRequest.value;

            formData.prixMin = baseFilter.value.minPrice;
            formData.prixMax = baseFilter.value.maxPrice;
            formData.kilometerMin = baseFilter.value.minKilometer;
            formData.kilometerMax = baseFilter.value.maxKilometer;
            formData.yearMin = baseFilter.value.minYear;
            formData.yearMax = baseFilter.value.maxYear;

        }
    });

    watch(() => formData.marque, async(param) => {
        if (!param) return;
        try {
            selected.value = false
            const response = await axios.get(`http://parrotpoo.test/filtre/params?marque=${param}`);
            listModele.value = response.data;
            listEnergie.value = response.data;
        } catch (error) {
            console.error(error);
        }
    });

    watch(() => formData.modele, async(param) => {
        if (!param) return;
        try {
            selected.value = false
            const values = Object.values(baseFilter.value.modeleEtMarque);
            values.forEach(element => {
                if (element.modele === param) {
                    formData.marque = element.marque;
                }
            });
            const response = await axios.get(`http://parrotpoo.test/filtre/params?modele=${param}`);
            listEnergie.value = response.data;
        } catch (error) {
            console.error(error);
        }
    });

    watch(() => formData.prixMin, () => {
        document.querySelector('.outputPriceMini').style.left = (formData.prixMin - prixMinRequest.value)*(100 / (ecartPrix.value)) + '%'
        if (formData.prixMin >= formData.prixMax) {
            formData.prixMax = prixMaxRequest.value
        }
    })

    watch(() => formData.prixMax, () => {
        document.querySelector('.outputPriceMaxi').style.left =  (formData.prixMax - prixMinRequest.value)*(100 / (ecartPrix.value)) + '%'
        if (formData.prixMax <= formData.prixMin) {
            formData.prixMin = prixMinRequest.value
        }
    })

    watch(() => formData.kilometerMin, () => {
        document.querySelector('.outputKilometerMin').style.left = (formData.kilometerMin - kilometerMinRequest.value)*(100 / (ecartKilometer.value)) + '%'
        if (formData.kilometerMin >= formData.kilometerMax) {
            formData.kilometerMax = kilometerMaxRequest.value
        }
    })

    watch(() => formData.kilometerMax, () => {
        document.querySelector('.outputKilometerMax').style.left = (formData.kilometerMax - kilometerMinRequest.value)*(100 / (ecartKilometer.value)) + '%'
        if (formData.kilometerMax <= formData.kilometerMin) {
            formData.kilometerMin = kilometerMinRequest.value
        }
    })

    watch(() => formData.yearMin, () => {
        document.querySelector('.outputYearMin').style.left = (formData.yearMin - yearMinRequest.value)*(100 / (ecartAnnee.value)) + '%'
        if (formData.yearMin >= formData.yearMax) {
            formData.yearMax = yearMaxRequest.value
        }
    })

    watch(() => formData.yearMax, () => {
        document.querySelector('.outputYearMax').style.left = (formData.yearMax - yearMinRequest.value)*(100 / (ecartAnnee.value)) + '%'
        if (formData.yearMax <= formData.yearMin) {
            formData.yearMin = yearMinRequest.value
        }
    })

    const searchCars = () => {
        emit('update:formData', formData)
    }

    const initialize = async() => {
        formData.prixMin = prixMinRequest.value;
        formData.prixMax = prixMaxRequest.value;
        formData.kilometerMin = kilometerMinRequest.value;
        formData.kilometerMax = kilometerMaxRequest.value;
        formData.yearMin = yearMinRequest.value;
        formData.yearMax = yearMaxRequest.value;
        formData.modele = null;
        formData.marque = null;
        formData.energie = null;

        selected.value = true

        emit('update:formData', formData)
    }

</script>


<template>

    <form>
        <div class="offcanvas__row">
            <DropDown :options="listMarque" default="marque" class="offcanvas__selectdiv" v-model="formData.marque" :watcher="selected"/>
            <DropDown :options="listModele" default="modele" class="offcanvas__selectdiv" v-model="formData.modele" :watcher="selected"/>
            <DropDown :options="listEnergie" default="energie" class="offcanvas__selectdiv" v-model="formData.energie" :watcher="selected"/>
        </div>
        <div class="offcanvas__row">
                <section class="range-slider">
                    <h6>Prix</h6>
                    <label for="priceMini" class="output outputOne outputPriceMini">{{ formData.prixMin }}€</label>
                    <label for="priceMaxi" class="output outputTwo outputPriceMaxi">{{ formData.prixMax }}€</label>
                    <span class="full-range"></span>
                    <span class="incl-range"></span>
                    <input id="priceMini" name="priceMini" :min="prixMinRequest" :max="prixMaxRequest" step="100" type="range" v-model="formData.prixMin">
                    <input id="priceMaxi" name="priceMaxi" :min="prixMinRequest" :max="prixMaxRequest" step="100" type="range" v-model="formData.prixMax">
                </section>

                <section class="range-slider">
                    <h6>Kilométrage</h6>
                    <label for="kilometerMin" class="output outputOne outputKilometerMin">{{ formData.kilometerMin }}km</label>
                    <label for="kilometerMax" class="output outputTwo outputKilometerMax">{{ formData.kilometerMax }}km</label>
                    <span class="full-range"></span>
                    <span class="incl-range"></span>
                    <input id="kilometerMin" name="kilometerMin" :min="kilometerMinRequest" :max="kilometerMaxRequest" step="1000" type="range" v-model="formData.kilometerMin">
                    <input id="kilometerMax" name="kilometerMax" :min="kilometerMinRequest" :max="kilometerMaxRequest" step="1000" type="range" v-model="formData.kilometerMax">
                </section>

                <section class="range-slider">
                    <h6>Année</h6>
                    <label for="yearMin" class="output outputOne outputYearMin">{{ formData.yearMin }}</label>
                    <label for="yearMax" class="output outputTwo outputYearMax">{{ formData.yearMax }}</label>
                    <span class="full-range"></span>
                    <span class="incl-range"></span>
                    <input id="yearMin" name="yearMin" :min="yearMinRequest" :max="yearMaxRequest" step="1" type="range" v-model="formData.yearMin">
                    <input id="yearMax" name="yearMax" :min="yearMinRequest" :max="yearMaxRequest" step="1" type="range" v-model="formData.yearMax">
                </section>
            </div>

            <div class="offcanvas__btn">
                <button @click.prevent="initialize()">Reinitialiser</button>
                <button @click.prevent="searchCars()">Rechercher</button>
            </div>
    </form>

</template>

<style lang="scss" scoped>

    @import '../../../scss/variable.scss';
    @import '../../../scss/mixins.scss';

    form {
        display: none;
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
            margin: 3rem auto;
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
    }

</style>
<template>
    <v-container>
        <v-row justify="center" align="stretch" class="pricing-container">
            <v-col
                v-for="plan in plans"
                :key="plan.id"
                cols="12"
                md="4"
                sm="6"
                class="d-flex justify-center"
            >
                <v-card
                    :elevation="plan.popular ? 12 : 4"
                    class="pricing-card"
                    outlined
                    color="white"
                    width="400px"
                >
                    <v-card-title class="text-h5 font-weight-bold d-flex justify-center align-center">
                        {{ plan.name }}
                    </v-card-title>

                    <v-card-subtitle
                        class="text-center text-h4 font-weight-bold"
                        :class="plan.popular ? 'text-primary' : ''"
                    >
                        {{ calculatePrice(plan.price) }} ₸
                    </v-card-subtitle>

                    <v-card-text class="text-center mb-3">
                        <span class="text-caption">за {{ getPeriodLabel() }}</span>
                    </v-card-text>

                    <v-list dense>
                        <v-list-item
                            v-for="feature in plan.features"
                            :key="feature.name"
                        >
                            <v-list-item-title>
                                <v-icon
                                    :color="feature.included ? 'primary' : 'grey'"
                                >
                                    {{ feature.included ? 'mdi-check' : 'mdi-close' }}
                                </v-icon>
                                {{ feature.name }}
                            </v-list-item-title>
                        </v-list-item>
                    </v-list>
<!--                    <v-radio-group v-model="selectedPeriod" row class="period-selector d-flex justify-space-between">-->
<!--                        <v-radio-->
<!--                            v-for="period in periods"-->
<!--                            :key="period.value"-->
<!--                            :label="period.label"-->
<!--                            :value="period.value"-->
<!--                        />-->
<!--                    </v-radio-group>-->
                    <v-card-actions class="justify-center">
                        <v-btn
                            block
                            color="primary"
                            @click="buy(plan.id)"
                            :disabled="plan.id === props.current_tariff"
                        >
                            <template v-if="plan.id === props.current_tariff">
                                Текущий тариф
                            </template>
                            <template v-else>
                                Выбрать
                            </template>
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script setup lang="ts">
import {ref, onMounted, defineProps} from "vue";
import { axiosGetRequest } from "../../utils/helper";
const props = defineProps({
    current_tariff: {
        type: Number,
        required: true,
    },
});
interface Feature {
    name: string;
    included: boolean;
}

interface Plan {
    id: number;
    name: string;
    price: number;
    features: Feature[];
}

const periods = ref([
    { label: "Месяц", value: "month", months: 1, discount: 0 },
    { label: "3 месяца", value: "3months", months: 3, discount: 5 },
    { label: "Полгода", value: "6months", months: 6, discount: 10 },
    { label: "Год", value: "year", months: 12, discount: 15 },
]);

const selectedPeriod = ref("month");

const plans = ref<Plan[]>([]);

const calculatePrice = (monthlyPrice: number) => {
    const period = periods.value.find((p) => p.value === selectedPeriod.value);
    if (!period) return monthlyPrice;

    const total = monthlyPrice * period.months;
    const discount = (total * period.discount) / 100;
    return Math.round(total - discount);
};

const getPeriodLabel = () => {
    const period = periods.value.find((p) => p.value === selectedPeriod.value);
    return period ? period.label : "месяц";
};

const getTariffs = () => {
    axiosGetRequest(`user/tariff`, (response) => {
        plans.value = response.data;
    });
};

onMounted(() => {
    getTariffs();
    if (!document.querySelector('script[src="https://widget.tiptoppay.kz/bundles/widget.js"]')) {
        const script = document.createElement('script');
        script.src = 'https://widget.tiptoppay.kz/bundles/widget.js';
        script.async = true;
        document.body.appendChild(script);
    }
});

function buy(id: number) {
    if (!(window as any).tiptop || !(window as any).tiptop.Widget) {
        return;
    }

    const plan = plans.value.find(plan => plan.id === id);
    if (!plan) {
        return;
    }

    const period = periods.value.find(p => p.value === selectedPeriod.value);
    if (!period) {
        return;
    }

    const totalAmount = calculatePrice(plan.price);

    const widget = new (window as any).tiptop.Widget();

    widget.pay(
        'auth',
        {
            publicId: 'pk_246ec9bec531525522dc041e98351',
            description: `Оплата тарифа ${plan.name} на ${getPeriodLabel()}`,
            amount: totalAmount,
            currency: 'KZT',
            accountId: 'user@example.com',
            invoiceId: '1234567',
            email: '',
            skin: 'mini',
            autoClose: 3,
            data: {
                myProp: 'myProp value',
            },
            payer: {
                firstName: 'Тест',
                    lastName: 'Тестов',
                    middleName: 'Тестович',
                    birth: '1955-02-24',
                    address: 'тестовый проезд дом тест',
                    street: 'Lenina',
                    city: 'MO',
                    country: 'KZ',
                    phone: '123',
                    postcode: '345',
            },
        },
        {
            onSuccess: (options: any) => {
                console.log('Payment successful:', options);
            },
            onFail: (reason: any, options: any) => {
                console.error('Payment failed:', reason);
            },
            onComplete: (paymentResult: any, options: any) => {
                console.log('Payment completed:', paymentResult);
            },
        }
    );
}
</script>
<style scoped>
.pricing-container {
    margin-top: 20px;
}

.pricing-card {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 100%;
}

.v-card-title {
    text-align: center;
}
</style>

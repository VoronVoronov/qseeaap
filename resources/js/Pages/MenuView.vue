<template>
    <v-card
        :disabled="loading"
        :loading="loading"
        max-width="374"
    >
        <template v-slot:loader="{ isActive }">
            <v-progress-linear
                :active="isActive"
                color="deep-purple"
                height="4"
                indeterminate
            ></v-progress-linear>
        </template>
        <v-img
            height="250"
            src="https://cdn.vuetifyjs.com/images/cards/cooking.png"
            cover
        ></v-img>
        <v-card-item>
            <v-card-title>Cafe Badilico</v-card-title>
        </v-card-item>
        <v-card-text>
            <div>Small plates, salads & sandwiches - an intimate setting with 12 indoor seats plus patio seating.</div>
        </v-card-text>
        <v-card-actions>
            <v-btn
                color="deep-purple-lighten-2"
                text="Reserve"
                block
                border
                @click="reserve"
            >
                Reserve
            </v-btn>
            <v-btn
                color="deep-purple-lighten-2"
                text="Pay"
                block
                border
                @click="pay"
            >
                Pay
            </v-btn>
        </v-card-actions>
    </v-card>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import "https://widget.tiptoppay.kz/bundles/widget.js";

const loading = ref(false);

function reserve() {
    loading.value = true;

    setTimeout(() => {
        loading.value = false;
    }, 2000);
}

function pay() {
    const tiptop = (window as any).tiptop;
    if (!tiptop || !tiptop.Widget) {
        console.error("TipTopPay widget is not loaded.");
        return;
    }

    const payments = new tiptop.Widget({
        language: "ru-RU",
        email: "",
        applePaySupport: true,
        googlePaySupport: true,
    });

    payments
        .pay("charge", {
            publicId: "pk_605899eddc5a414c7da449a5f6543",
            description: "Тестовая оплата",
            amount: 100,
            currency: "KZT",
            invoiceId: "123",
            accountId: "123",
            email: "",
            skin: "modern",
            requireEmail: true,
        })
        .then((widgetResult: any) => {
            console.log("result", widgetResult);
        })
        .catch((error: any) => {
            console.error("error", error);
        });
}
</script>

<template>
    <div class="max-w-4xl mx-auto mt-10 px-4">
        <div class="bg-white shadow-md rounded-lg p-6 mt-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">
                Simulate Transactions
            </h2>
            <form @submit.prevent="submitForm">
                <div class="mb-4">
                    <label for="phone" class="block text-gray-700 font-medium mb-2">Phone</label>
                    <input type="phone" id="phone" v-model="phone"
                        class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-400"
                        required />
                </div>
                <div class="mb-4">
                    <label for="amount" class="block text-gray-700 font-medium mb-2">Amount</label>
                    <input type="amount" id="amount" v-model="amount"
                        class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-400"
                        required />
                </div>
                <div class="mb-4">
                    <label for="account" class="block text-gray-700 font-medium mb-2">Account</label>
                    <input type="text" id="account" v-model="account"
                        class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-400"
                        required />
                </div>
                <button @click="simulateStk" type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    Simulate STK
                </button>
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import Swal from "sweetalert2";
import axios from "axios";
import { usePage } from "@inertiajs/vue3";

const amount = ref("");
const account = ref("");
const phone = ref("");

const simulateStk = async () => {
    
    const data = {
        amount: amount.value,
        account: account.value,
        phone: phone.value,
    };

    try {
        const response = await axios.post("/stk-push", data);
        console.log(response.data);
        Swal.fire({
            icon: "success",
            title: "Success",
            text: response.data.message,
            
        });
    } catch (error) {
        Swal.fire({
            icon: "error",
            title: "Error",
            text: error.response.data.message,
        });
    }
};

</script>
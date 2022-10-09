<script setup>
defineProps(['company']);
</script>

<template>
    <div
        class="
            col-span-1
            p-5
            border border-gray-200
            flex flex-col
            justify-between
        "
    >
        <div class="text-xl text-gray-800 my-4 font-bold">
            {{ company.name }}
        </div>
        <div class="text-gray-600 my-4">
            {{ company.description }}
        </div>
        <div
            class="
                flex
                items-center
                justify-start
                text-gray-800
                font-semibold
                gap-10
                text-lg
            "
        >
            <a :href="'mailto:' + company.email">Enviar email</a>
            <a
                :href="'https://wa.me/' + company.formatted_phone"
                target="_blank"
                >WhatsApp</a
            >
        </div>
    </div>
</template>
